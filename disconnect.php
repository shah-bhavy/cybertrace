<?php
// disconnect.php
session_start();
function disconnectDevice() {
    // This function can be extended to perform any additional cleanup if needed
    session_start();
    unset($_SESSION['connected_device']);
    header("Location: findDevice.php?message=disconnected");
    exit;
}