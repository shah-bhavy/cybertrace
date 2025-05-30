<?php
// Sample data for insights
session_start();
$deviceId = $_SESSION['connected_device']['id'];
$insights = [
    [
        'icon' => 'fa-address-book',
        'title' => 'Total Contacts',
        'value' => '153',
        'desc' => 'Contacts found in device address book.',
        'color' => 'bg-blue-500'
    ],
    [
        'icon' => 'fa-exclamation-triangle',
        'title' => 'Suspicious Messages',
        'value' => '4',
        'desc' => 'Messages flagged as suspicious (e.g., password, OTP, links).',
        'color' => 'bg-red-500'
    ],
    [
        'icon' => 'fa-user-secret',
        'title' => 'Unknown Callers',
        'value' => '12',
        'desc' => 'Calls from numbers not saved in contacts in past 30.',
        'color' => 'bg-yellow-500'
    ],
    [
        'icon' => 'fa-phone-volume',
        'title' => 'Most Called With',
        'value' => 'Harsh (+919228744444)',
        'desc' => 'Contact with the highest call frequency.',
        'color' => 'bg-green-500'
    ],
    [
        'icon' => 'fa-comments',
        'title' => 'Mostly Chatted With',
        'value' => 'Bhavya (+9199244860100)',
        'desc' => 'Contact with the most messages exchanged.',
        'color' => 'bg-purple-500'
    ],
    [
        'icon' => 'fa-android',
        'title' => 'External APKs Installed',
        'value' => '3',
        'desc' => 'Apps installed from outside the Play Store.',
        'color' => 'bg-pink-500'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Insights - CyberTrace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 to-indigo-900 min-h-screen text-gray-800">
    <!-- Floating Back to Dashboard Button -->
    <a href="connect.php?device_id=<?php echo urlencode($deviceId); ?>"
       class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 font-semibold text-lg transition-all"
       style="box-shadow: 0 8px 32px rgba(30,64,175,0.25);">
        <i class="fas fa-arrow-left"></i>
        Back to Dashboard
    </a>
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <h2 class="text-4xl font-bold mb-10 text-white flex items-center gap-3">
            <i class="fas fa-brain text-blue-300"></i> AI Insights <p> as per past 30 days</p>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl">
            <?php foreach ($insights as $insight): ?>
                <div class="rounded-2xl shadow-lg p-8 flex flex-col items-center <?php echo $insight['color']; ?> bg-opacity-90 text-white">
                    <div class="mb-4">
                        <i class="fas <?php echo $insight['icon']; ?> text-4xl"></i>
                    </div>
                    <div class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($insight['title']); ?></div>
                    <div class="text-4xl font-extrabold mb-2"><?php echo htmlspecialchars($insight['value']); ?></div>
                    <div class="text-md text-blue-100 text-center"><?php echo htmlspecialchars($insight['desc']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>