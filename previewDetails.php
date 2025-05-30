<?php
require 'config.php';

if (!isset($_SESSION['connected_device'])) {
    header("Location: findDevice.php?error=not_connected");
    exit;
}

$deviceId = $_SESSION['connected_device']['id'];
$action = $_GET['action'] ?? '';

function groupByDate($timestamp) {
    $today = strtotime('today', time() + (5.5 * 3600)); // Adjust for IST
    $yesterday = strtotime('yesterday', time() + (5.5 * 3600)); // Adjust for IST
    $ts_seconds = $timestamp / 1000; // Convert ms to seconds
    if ($ts_seconds >= $today) return "Today";
    if ($ts_seconds >= $yesterday && $ts_seconds < $today) return "Yesterday";
    return date("d M Y", $ts_seconds);
}

$adbPath = "C:\platform-tools\adb.exe"; // Or your full adb.exe path

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Details - CyberTrace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .call-incoming { border-left: 6px solid #3b82f6; }
        .call-outgoing { border-left: 6px solid #22c55e; }
        .call-missed { border-left: 6px solid #ef4444; }
        .call-card { background: #fff; }
        .call-icon { font-size: 1.5rem; }
        .call-incoming .call-icon { color: #3b82f6; }
        .call-outgoing .call-icon { color: #22c55e; }
        .call-missed .call-icon { color: #ef4444; }
        .date-group { font-weight: bold; font-size: 1.1rem; margin-top: 2rem; margin-bottom: 1rem; color:rgb(255, 255, 255); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 to-indigo-900 min-h-screen text-gray-800">

<!-- Floating Back to Dashboard Button -->
<a href="connect.php?device_id=<?php echo urlencode($deviceId); ?>"
   class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 font-semibold text-lg transition-all"
   style="box-shadow: 0 8px 32px rgba(30,64,175,0.25);">
    <i class="fas fa-arrow-left"></i>
    Back to Dashboard
</a>

<div class="flex h-screen">
    <div class="flex-1 p-8 overflow-auto">
        <h2 class="text-3xl font-bold mb-8 text-white flex items-center">
            <?php if ($action == "call_logs"): ?>
                <i class="fas fa-phone-alt mr-3"></i> Call Logs
            <?php elseif ($action == "message"): ?>
                <i class="fas fa-sms mr-3"></i> Messages
            <?php elseif ($action == "apps"): ?>
                <i class="fas fa-th-list mr-3"></i> Installed Apps
            <?php endif; ?>
        </h2>
        <?php if ($action == "call_logs"): ?>
            <?php
            // Fetch call logs with specific projection
            $output = [];
            $command = "$adbPath -s $deviceId shell content query --uri content://call_log/calls --projection number:date:type:duration:name 2>&1";
            @exec($command, $output);

            $calls = [];
            foreach ($output as $line) {
                if (strpos($line, 'Row:') === 0) {
                    $parts = explode(' ', $line, 3); // Split to remove "Row: [number]"
                    if (isset($parts[2])) {
                        $data = [];
                        $pairs = explode(',', $parts[2]);
                        foreach ($pairs as $pair) {
                            $kv = explode('=', $pair, 2);
                            if (count($kv) == 2) {
                                $data[trim($kv[0])] = trim($kv[1]);
                            }
                        }
                        if (isset($data['number']) && isset($data['date']) && isset($data['type'])) {
                            $data['date'] = (int)($data['date']); // Date is already in ms
                            $calls[] = $data;
                        }
                    }
                }
            }

            // Group by date
            $grouped = [];
            foreach ($calls as $call) {
                $group = groupByDate($call['date']);
                $grouped[$group][] = $call;
            }

            // Reverse the order of calls within each group
            foreach ($grouped as &$group) {
                $group = array_reverse($group);
            }
            unset($group); // Unset the reference

            // Sort the groups by date descending (latest first)
            uksort($grouped, function($a, $b) {
                // "Today" and "Yesterday" should always be on top in order
                $special = ["Today" => 2, "Yesterday" => 1];
                $aVal = $special[$a] ?? 0;
                $bVal = $special[$b] ?? 0;
                if ($aVal !== $bVal) return $bVal - $aVal;
                // For date strings, compare as dates
                $aTime = strtotime($a);
                $bTime = strtotime($b);
                return $bTime <=> $aTime;
            });

            // Call type icons/colors
            function callType($type) {
                // 1: Incoming, 2: Outgoing, 3: Missed
                if ($type == 1) return ['Incoming', 'call-incoming', 'fa-arrow-down-left'];
                if ($type == 2) return ['Outgoing', 'call-outgoing', 'fa-arrow-up-right'];
                if ($type == 3) return ['Missed', 'call-missed', 'fa-arrow-rotate-left'];
                return ['Other', '', 'fa-question'];
            }
            ?>

            <?php if (empty($grouped) && !empty($output)): ?>
                <div class='bg-yellow-100 text-yellow-700 p-4 rounded mb-4'>
                    The ADB command executed successfully, but no call logs were parsed into the expected format.
                    <pre class="text-xs mt-2"><?php print_r($output); ?></pre>
                </div>
            <?php endif; ?>

            <?php foreach ($grouped as $date => $calls): ?>
                <div class="date-group"><?php echo htmlspecialchars($date); ?></div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <?php foreach ($calls as $call):
                        list($typeLabel, $typeClass, $icon) = callType($call['type']);
                        ?>
                        <div class="call-card <?php echo $typeClass; ?> rounded-xl p-5 flex items-center gap-4 shadow">
                            <div class="call-icon">
                                <i class="fas <?php echo $icon; ?>"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-lg">
                                    <span class="text-gray-500">
                                        <?php
                                        $displayName = $call['name'] ?? '';
                                        $displayNumber = $call['number'];
                                        if ($displayName && $displayName !== $displayNumber) {
                                            echo htmlspecialchars($displayName) . " <span class='text-xs text-gray-100'>(" . htmlspecialchars($displayNumber) . ")</span>";
                                        } else {
                                            echo htmlspecialchars($displayNumber);
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo $typeLabel; ?>
                                    <?php if (!empty($call['duration']) && $call['duration'] > 0): ?>
                                        • <?php echo gmdate("i\m s\s", $call['duration']); ?>
                                    <?php endif; ?>
                                </div>
                                <!-- Identify Button -->
                                <form method="post" action="identifyContact.php" class="mt-2">
                                    <input type="hidden" name="number" value="<?php echo htmlspecialchars($displayNumber); ?>">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-semibold py-1 px-3 rounded">
                                        Identify
                                    </button>
                                </form>
                            </div>
                            <div class="text-xs text-gray-900 ml-2">
                                <?php echo date("h:i A", $call['date'] / 1000); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-white rounded-xl p-8 shadow text-center text-gray-500 text-xl">
                <?php if ($action == "message"): ?>
                    Message preview coming soon.
                <?php elseif ($action == "apps"): ?>
                    Installed apps preview coming soon.
                <?php else: ?>
                    Select a preview action from the sidebar.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php
        if (empty($output) && $action == 'call_logs') {
            echo "<div class='bg-red-100 text-red-700 p-4 rounded'>No output from ADB for call logs. Check device connection and permissions.</div>";
        }
        ?>
    </div>
</div>
</body>
</html>