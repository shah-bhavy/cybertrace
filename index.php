<!-- index.php -->
<?php
require 'config.php';
if (isAccessGranted()) {
    header("Location: dashboard.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $access_key = $_POST['access_key'] ?? '';
    if (!empty($access_key)) {
        setAccessGranted($access_key);
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Please enter an access key";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberTrace - Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3a8a 0%, #111827 100%); font-family: 'Inter', sans-serif; }
        .card { background: rgba(255, 255, 255, 0.95); transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); }
        .btn-primary { background: linear-gradient(to right, #1e3a8a, #3b82f6); transition: all 0.3s ease; }
        .btn-primary:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }
    </style>
</head>
<body class="text-gray-800 flex items-center justify-center h-screen">
    <div class="card p-8 rounded-2xl max-w-md w-full">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center justify-center">
            <i class="fas fa-shield-alt mr-3 text-blue-600"></i> CyberTrace Access
        </h2>
        <?php if (isset($error)) echo "<p class='text-red-600 text-center'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700">Access Key</label>
                <input type="text" name="access_key" class="w-full p-3 border rounded-lg mt-1 focus:ring-2 focus:ring-blue-500" placeholder="Enter your access key" required>
            </div>
            <button type="submit" class="w-full btn-primary text-white p-3 rounded-lg font-semibold">Grant Access</button>
        </form>
    </div>
</body>
</html>