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
    // Use the full path to adb.exe if needed
    $adbPath = "C:\\platform-tools\\adb.exe"; // Change this to your actual adb.exe path
    $safeDeviceId = escapeshellarg($deviceId);

    // Use double quotes for Windows shell, and a simple ls command
    $command = "$adbPath -s $deviceId shell ls -d /storage/emulated/0/*/ 2>&1";
    $output = shell_exec($command);

    // Debug output (optional, remove in production)
    // echo "<pre>COMMAND: $command\nOUTPUT:\n$output</pre>";

    if ($output === null || stripos($output, 'error') !== false || stripos($output, 'not found') !== false || stripos($output, 'unauthorized') !== false) {
        $status = "Failed to fetch directories. Make sure your device is connected, unlocked, authorized for USB debugging, and file transfer is enabled.<br><small><code>" . htmlspecialchars($output) . "</code></small>";
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
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-plug mr-3"></i> Connect Device</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-eye mr-3"></i> Data Preview</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-brain mr-3"></i> AI Insights</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-file-export mr-3"></i> Export Report</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-cog mr-3"></i> Settings</a>
            </nav>
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
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($directories as $dir): 
                    $dirName = rtrim($dir, '/');
                ?>
                <div class="card p-6 rounded-2xl cursor-pointer flex items-center justify-between group">
                    <div class="flex items-center">
                        <i class="fas fa-folder text-yellow-500 text-2xl mr-3"></i>
                        <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($dirName); ?></span>
                    </div>
                    <span class="ml-4 flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 opacity-80 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>