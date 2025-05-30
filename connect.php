<?php
require 'config.php';
    
if (!isAccessGranted()) {
    header("Location: index.php");
    exit;
}

$deviceId = $_GET['device_id'] ?? '';
$device = null;
$directories = [];
$status = '';
$statusType = 'success';

// Fetch device info (make sure 'id' is the real ADB serial)
$devices = getDevices();
foreach ($devices as $d) {
    if ($d['id'] == $deviceId) {
        $device = $d;
        break;
    }
}

if (!$device) {
    $status = "Device not found.";
    $statusType = 'error';
} else {
     $_SESSION['connected_device'] = [
        'id' => $device['id'],
        'name' => $device['name'],
        'connected_at' => time()
    ];
    // Use the full path to adb.exe if needed
    $adbPath = "C:\\platform-tools\\adb.exe"; // Change this to your actual adb.exe path
    $safeDeviceId = escapeshellarg($deviceId);

    // Use double quotes for Windows shell, and a simple ls command
    $command = "$adbPath -s $deviceId shell ls -d /storage/emulated/0/*/ 2>&1";
    $output = shell_exec($command);

    // Debug output (optional, remove in production)
    // echo "<pre>COMMAND: $command\nOUTPUT:\n$output</pre>";

    if ($output === null || stripos($output, 'error') !== false || stripos($output, 'not found') !== false || stripos($output, 'unauthorized') !== false) {
        $status = "Failed to fetch folders. Make sure your device is connected, unlocked, authorized for USB debugging, and file transfer is enabled.<br><small><code>" . htmlspecialchars($output) . "</code></small>";
        $statusType = 'error';
    } else {
        // Extract only folder names
        $directories = array_filter(array_map(function($line) {
            $line = trim($line);
            return basename(rtrim($line, '/'));
        }, explode("\n", $output)));
        $status = "Device connected successfully.";
        $statusType = 'success';
    }
}

$showDirs = isset($_GET['show_dirs']) && $_GET['show_dirs'] == '1';

// Export AI Insights as CSV if requested
if (isset($_GET['export_ai']) && $device) {
    // Sample data (should match aiInsights.php)
    $insights = [
        ['Total Contacts', '153', 'Contacts found in device address book.'],
        ['Suspicious Messages', '4', 'Messages flagged as suspicious (e.g., password, OTP, links).'],
        ['Unknown Callers', '12', 'Calls from numbers not saved in contacts.'],
        ['Most Called With', 'Harsh (+919228744444)', 'Contact with the highest call frequency.'],
        ['Mostly Chatted With', 'Bhavya (+9199244860100)', 'Contact with the most messages exchanged.'],
        ['External APKs Installed', '3', 'Apps installed from outside the Play Store.'],
    ];

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="ai_insights_' . $device['id'] . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Insight', 'Value', 'Description']);
    foreach ($insights as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Device - CyberTrace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3a8a 0%, #111827 100%); font-family: 'Inter', sans-serif; }
        .sidebar { backdrop-filter: blur(10px); background: rgba(31, 41, 55, 0.9); }
        .card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.95); 
            transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s;
            border: 2px solid transparent;
        }
        .card:hover { 
            transform: translateY(-5px) scale(1.03); 
            box-shadow: 0 10px 24px rgba(59, 130, 246, 0.15);
            border: 2px solid #3b82f6;
        }
        .card .fa-arrow-right {
            transition: transform 0.2s;
        }
        .card:hover .fa-arrow-right {
            transform: translateX(4px) scale(1.1);
        }
        .status-success {
            background: linear-gradient(90deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
        }
        .status-error {
            background: linear-gradient(90deg, #ef4444 0%, #b91c1c 100%);
            color: #fff;
        }
    </style>
</head>
<body class="text-gray-800">
    <div class="flex h-screen">
        <div class="w-72 sidebar text-white flex flex-col">
            <div class="p-6 text-3xl font-bold flex items-center">
                <i class="fas fa-shield-alt mr-3 text-blue-400"></i> CyberTrace
            </div>
            <nav class="flex-1">
                <a href="dashboard.php" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a>
                <a href="findDevice.php" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-plug mr-3"></i> Connect Device</a>
                <a href="previewDetails.php?action=call_logs" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-eye mr-3"></i> Calls Preview</a>
                <a href="aiInsights.php" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-brain mr-3"></i> AI Insights</a>
                <a href="connect.php?device_id=<?php echo urlencode($device['id']); ?>&export_ai=1"
                   class="block p-4 hover:bg-blue-900/50 flex items-center">
                    <i class="fas fa-file-export mr-3"></i> Export AI Insights
                </a>
            </nav>
            <a href="logout.php" class="block p-4 hover:bg-blue-900/50 flex items-center text-red-400">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>
        </div>
        <div class="flex-1 p-8 overflow-auto bg-white/5">
            <h2 class="text-3xl font-bold mb-6 text-white flex items-center"><i class="fas fa-plug mr-3"></i> Device Connection</h2>
            
            <!-- Status Message -->
            <?php if ($status): ?>
            <div class="mb-6 card <?php echo $statusType === 'success' ? 'status-success' : 'status-error'; ?>">
                <div class="p-4 flex items-center w-full">
                    <i class="fas <?php echo $statusType === 'success' ? 'fa-check-circle' : 'fa-times-circle'; ?> mr-3 text-2xl"></i>
                    <span class="font-semibold"><?php echo $status; ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Device Info -->
            <?php if ($device): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="card p-6 rounded-2xl">
                    <div>
                        <div class="text-gray-500 text-sm mb-1">Device Name</div>
                        <div class="text-lg font-bold"><?php echo htmlspecialchars($device['name']); ?></div>
                    </div>
                </div>
                <div class="card p-6 rounded-2xl">
                    <div>
                        <div class="text-gray-500 text-sm mb-1">Device ID</div>
                        <div class="text-lg font-bold"><?php echo htmlspecialchars($device['id']); ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Loading Message -->
            <?php if ($device && empty($directories)): ?>
            <div class="card p-6 rounded-2xl mb-6 flex items-center">
                <i class="fas fa-spinner fa-spin mr-4 text-blue-500 text-2xl"></i>
                <span class="font-semibold text-blue-900">It's great if you keep the device connected and file transfer turned on.</span>
            </div>
            <?php endif; ?>

            <!-- Directory Cards -->
            <?php if (!empty($directories)): ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Main Directories Card (Clickable, Modern) -->
    <a href="?show_dirs=1&device_id=<?php echo urlencode($device['id']); ?>"
       class="card rounded-2xl p-8 shadow-lg group cursor-pointer hover:scale-105 transition-transform duration-200 flex flex-col items-center justify-center focus:outline-none focus:ring-4 focus:ring-blue-300<?php if($showDirs) echo ' ring-4 ring-blue-400'; ?>">
        <div class="icon flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4 shadow-lg text-3xl text-blue-600">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="text-2xl font-extrabold tracking-tight mb-2">Main folders</div>
        <div class="text-lg font-bold text-blue-700"><?php echo count($directories); ?></div>
    </a>
    <!-- View Call Logs Card -->
    <a href="previewDetails.php?action=call_logs"
       class="card rounded-2xl p-8 shadow-lg flex flex-col items-center justify-center cursor-pointer hover:scale-105 transition-transform duration-200">
        <div class="icon flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4 shadow-lg text-3xl text-green-600">
            <i class="fas fa-phone-alt"></i>
        </div>
        <div class="text-2xl font-extrabold tracking-tight mb-2">Call Logs</div>
        <span class="btn mt-4">View</span>
    </a>
    <!-- View Recent Messages Card -->
    <a href="previewMessages.php"
       class="card rounded-2xl p-8 shadow-lg flex flex-col items-center justify-center cursor-pointer hover:scale-105 transition-transform duration-200">
        <div class="icon flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 mb-4 shadow-lg text-3xl text-purple-600">
            <i class="fas fa-sms"></i>
        </div>
        <div class="text-2xl font-extrabold tracking-tight mb-2">Messages</div>
        <span class="btn mt-4">View</span>
    </a>
    <!-- AI Insights Card -->
    <a href="aiInsights.php?device_id=<?php echo urlencode($device['id']); ?>"
       class="card rounded-2xl p-8 shadow-lg flex flex-col items-center justify-center cursor-pointer hover:scale-105 transition-transform duration-200">
        <div class="icon flex items-center justify-center w-16 h-16 rounded-full bg-blue-200 mb-4 shadow-lg text-3xl text-blue-700">
            <i class="fas fa-brain"></i>
        </div>
        <div class="text-2xl font-extrabold tracking-tight mb-2">AI Insights</div>
        <span class="btn mt-4">View</span>
    </a>
</div>
<!-- Show Directories Below Cards -->
<?php if ($showDirs): ?>
    <div class="mt-8 bg-white/80 rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <div class="text-xl font-bold text-blue-900 flex items-center">
                <i class="fas fa-folder-open mr-2"></i> Main folders <?php echo count($directories); ?>
            </div>
            <a href="?device_id=<?php echo urlencode($device['id']); ?>" class="btn bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-700 transition">Close</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($directories as $dir): ?>
                <div class="flex items-center bg-blue-50 rounded-xl px-4 py-3 shadow text-blue-900 font-semibold">
                    <i class="fas fa-folder mr-3 text-yellow-500"></i>
                    <?php echo htmlspecialchars($dir); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>
        </div>
    </div>
    </body>
    </html>