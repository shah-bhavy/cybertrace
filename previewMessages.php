<?php
// Sample data
$contacts = [
    [
        'id' => 1,
        'name' => 'Harsh',
        'number' => '+919228744444',
        'last_message' => 'See you soon!',
        'last_time' => strtotime('-1 hour'),
        'messages' => [
            ['from_me' => false, 'body' => 'Hey, are you coming?', 'time' => strtotime('-2 hours')],
            ['from_me' => true, 'body' => 'Yes, on my way!', 'time' => strtotime('-1.5 hours')],
            ['from_me' => false, 'body' => 'See you soon!', 'time' => strtotime('-1 hour')],
        ]
    ],
    [
        'id' => 2,
        'name' => 'Bhavya',
        'number' => '+9199244860100',
        'last_message' => 'Thanks!',
        'last_time' => strtotime('-3 hours'),
        'messages' => [
            ['from_me' => true, 'body' => 'Sent the files.', 'time' => strtotime('-4 hours')],
            // Suspicious message added below
            ['from_me' => false, 'body' => 'Don\'t tell anyone, but the password is "qwerty123".', 'time' => strtotime('-3.5 hours')],
            ['from_me' => false, 'body' => 'Thanks!', 'time' => strtotime('-3 hours')],
        ]
    ],
    [
        'id' => 3,
        'name' => 'Charlie',
        'number' => '+911112223334',
        'last_message' => 'Let\'s catch up tomorrow.',
        'last_time' => strtotime('-1 day'),
        'messages' => [
            ['from_me' => false, 'body' => 'Let\'s catch up tomorrow.', 'time' => strtotime('-1 day')],
        ]
    ],
];

$selected = $_GET['contact'] ?? 1;
$current = null;
foreach ($contacts as $c) {
    if ($c['id'] == $selected) $current = $c;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sample Chat Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 to-indigo-900 min-h-screen text-gray-800">
<!-- Floating Back to Dashboard Button -->
<a href="dashboard.php"
   class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 font-semibold text-lg transition-all"
   style="box-shadow: 0 8px 32px rgba(30,64,175,0.25);">
    <i class="fas fa-arrow-left"></i>
    Back to Dashboard
</a>
<div class="flex h-screen">
    <!-- Sidebar: Contacts -->
    <div class="w-80 bg-blue-950/80 text-white flex flex-col border-r border-blue-900">
        <div class="p-6 text-2xl font-bold flex items-center border-b border-blue-900">
            <i class="fas fa-comments mr-3 text-blue-400"></i> Chats
        </div>
        <div class="flex-1 overflow-y-auto">
            <?php foreach ($contacts as $c): ?>
                <a href="?contact=<?php echo $c['id']; ?>"
                   class="block px-6 py-4 border-b border-blue-900 hover:bg-blue-900/40 transition
                   <?php if ($c['id'] == $selected) echo 'bg-blue-900/60'; ?>">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-400 rounded-full w-10 h-10 flex items-center justify-center text-xl font-bold">
                            <?php echo strtoupper($c['name'][0]); ?>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold"><?php echo htmlspecialchars($c['name']); ?></div>
                            <div class="text-xs text-blue-200 truncate"><?php echo htmlspecialchars($c['last_message']); ?></div>
                        </div>
                        <div class="text-xs text-blue-300 ml-2">
                            <?php echo date('h:i A', $c['last_time']); ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Main: Chat Messages -->
    <div class="flex-1 flex flex-col bg-gradient-to-br from-blue-900 to-indigo-900">
        <div class="border-b border-blue-900 px-8 py-4 flex items-center gap-4">
            <div class="bg-blue-400 rounded-full w-12 h-12 flex items-center justify-center text-2xl font-bold">
                <?php echo strtoupper($current['name'][0]); ?>
            </div>
            <div>
                <div class="font-bold text-white text-lg"><?php echo htmlspecialchars($current['name']); ?></div>
                <div class="text-xs text-blue-200"><?php echo htmlspecialchars($current['number']); ?></div>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto px-8 py-6 space-y-4">
            <?php foreach ($current['messages'] as $msg): ?>
                <div class="flex <?php echo $msg['from_me'] ? 'justify-end' : 'justify-start'; ?>">
                    <div class="<?php echo $msg['from_me'] ? 'bg-blue-500 text-white' : 'bg-white text-gray-800'; ?> rounded-lg px-4 py-2 max-w-lg shadow">
                        <div><?php echo nl2br(htmlspecialchars($msg['body'])); ?></div>
                        <div class="text-xs mt-1 text-right <?php echo $msg['from_me'] ? 'text-blue-100' : 'text-gray-400'; ?>">
                            <?php echo date('d M h:i A', $msg['time']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="border-t border-blue-900 px-8 py-4 bg-blue-950/80">
            <form class="flex gap-4">
                <input type="text" class="flex-1 rounded-lg px-4 py-2 bg-blue-900 text-white placeholder-blue-300 focus:outline-none" placeholder="Type a message..." disabled>
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold" disabled>
                    <i class="fas fa-paper-plane"></i> Send
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>