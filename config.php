<?php
session_start();

function setAccessGranted($key) {
    $_SESSION['access_key'] = $key;
    $_SESSION['devices'] = [
        ['id' => 1, 'name' => 'Device 1', 'port' => 'USB Port 1'],
        ['id' => 2, 'name' => 'Device 2', 'port' => 'USB Port 2'],
        ['id' => 3, 'name' => 'External Storage', 'port' => 'USB Port 3']
    ]; // Mock initial device list
}

function isAccessGranted() {
    return isset($_SESSION['access_key']);
}

function getDevices() {
    // Only return ADB devices
    return getAdbDevices();
}

function updateDeviceName($id, $newName) {
    $devices = &$_SESSION['devices'];
    foreach ($devices as &$device) {
        if ($device['id'] == $id) {
            $device['name'] = $newName;
            break;
        }
    }
}

function getAdbDevices() {
    $adbPath = "C:\\platform-tools\\adb.exe"; // Change to your adb.exe path
    $output = [];
    @exec("$adbPath devices -l", $output);

    $devices = [];
    foreach ($output as $line) {
        if (preg_match('/^([^\s]+)\s+device\b.*model:([^\s]+)/i', $line, $matches)) {
            $serial = $matches[1];
            $model = $matches[2];
            $devices[] = [
                'id' => $serial,
                'name' => $model,
                'port' => 'ADB'
            ];
        }
    }
    return $devices;
}
?>