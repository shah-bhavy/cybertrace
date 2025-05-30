<?php
require 'config.php';
if (!isAccessGranted()) {
    header("Location: index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'rename') {
        $id = $_POST['device_id'] ?? 0;
        $new_name = $_POST['new_name'] ?? '';
        if ($id && $new_name) {
            updateDeviceName($id, $new_name);
        }
        header("Location: dashboard.php");
        exit;
    }
}
?>