<?php
header('Content-Type: application/json');
$devices = [
    ['id' => 1, 'name' => 'Device 1', 'port' => 'USB Port 1'],
    ['id' => 2, 'name' => 'Device 2', 'port' => 'USB Port 2'],
    ['id' => 3, 'name' => 'External Storage', 'port' => 'USB Port 3']
];
echo json_encode($devices);
?>
