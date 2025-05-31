<!-- dashboard.php -->
<?php
require 'config.php';
if (!isAccessGranted()) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberTrace - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3a8a 0%, #111827 100%); font-family: 'Inter', sans-serif; }
        .sidebar { backdrop-filter: blur(10px); background: rgba(31, 41, 55, 0.9); }
        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.95); 
            transition: transform 0.3s, box-shadow 0.3s, border 0.3s;
            border: 2px solid transparent;
            min-height: 180px;
        }
        .card:hover { 
            transform: translateY(-5px) scale(1.03); 
            box-shadow: 0 10px 24px rgba(59, 130, 246, 0.15);
            border: 2px solid #3b82f6;
        }
        .card .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .card-connect { background: linear-gradient(120deg, #3b82f6 60%, #1e3a8a 100%); color: #fff; }
        .card-docs { background: linear-gradient(120deg, #f59e42 60%, #fbbf24 100%); color: #fff; }
        .card-about { background: linear-gradient(120deg, #10b981 60%, #047857 100%); color: #fff; }
        .card-testimonial { background: linear-gradient(120deg, #a78bfa 60%, #6366f1 100%); color: #fff; }
        .card-subscription { background: linear-gradient(120deg, #f43f5e 60%, #be185d 100%); color: #fff; }
        .card .btn {
            margin-top: 1.5rem;
            background: rgba(255,255,255,0.15);
            color: inherit;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .card .btn:hover {
            background: rgba(255,255,255,0.3);
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
                <a href="dashboard.php" class="block p-4 bg-blue-900/50 flex items-center"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a>
                <a href="findDevice.php" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-plug mr-3"></i> Connect Devices</a>
                <a href="#" data-disabled="1" class="block p-4 flex items-center opacity-50 cursor-not-allowed bg-gray-800"><i class="fas fa-eye mr-3"></i> Calls Preview</a>
                <a href="#" data-disabled="1" class="block p-4 flex items-center opacity-50 cursor-not-allowed bg-gray-800"><i class="fas fa-brain mr-3"></i> AI Insights</a>
                <a href="#" data-disabled="1" class="block p-4 flex items-center opacity-50 cursor-not-allowed bg-gray-800"><i class="fas fa-file-export mr-3"></i> Export Report</a>
            </nav>
            <a href="logout.php" class="block p-4 hover:bg-blue-900/50 flex items-center text-red-400">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>
        </div>
        <div class="flex-1 p-8 overflow-auto">
            <h2 class="text-3xl font-bold mb-8 text-white flex items-center"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Connect Devices Card -->
                <div class="card card-connect rounded-2xl p-6 shadow-lg">
                    <div>
                        <div class="icon"><i class="fas fa-plug"></i></div>
                        <div class="text-xl font-bold mb-2">Connect Devices</div>
                        <div>View and manage all connected Android devices for investigation.</div>
                    </div>
                    <a href="findDevice.php" class="btn">Go to Devices</a>
                </div>
                <!-- View Docs Card -->
                <div class="card card-docs rounded-2xl p-6 shadow-lg">
                    <div>
                        <div class="icon"><i class="fas fa-book"></i></div>
                        <div class="text-xl font-bold mb-2">View Docs</div>
                        <div>Access documentation and guides for using CyberTrace tools.</div>
                    </div>
                    <a href="docs.php" class="btn">Read Docs</a>
                </div>
                <!-- About Us Card -->
                <div class="card card-about rounded-2xl p-6 shadow-lg">
                    <div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <div class="text-xl font-bold mb-2">Know About Us</div>
                        <div>Learn more about the CyberTrace team and our mission.</div>
                    </div>
                    <a href="about.php" class="btn">About Us</a>
                </div>
                <!-- Testimonial Card -->
                <div class="card card-testimonial rounded-2xl p-6 shadow-lg">
                    <div>
                        <div class="icon"><i class="fas fa-comment-dots"></i></div>
                        <div class="text-xl font-bold mb-2">Testimonials</div>
                        <div>See what law enforcement and cyber experts say about CyberTrace.</div>
                    </div>
                    <a href="#" class="btn">View Testimonials</a>
                </div>
                <!-- Welcome Card (spans two columns on large screens) -->
                <div class="card rounded-2xl p-8 shadow-lg col-span-1 md:col-span-2 lg:col-span-2 flex-row items-center justify-center bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 text-white">
                    <div class="flex flex-col items-start">
                        <div class="text-2xl font-bold mb-2"><i class="fas fa-shield-alt mr-2"></i>Welcome to CyberTrace</div>
                        <div class="text-lg">
                            Your all-in-one toolkit for digital forensics and cyber investigations. Use the cards above to quickly access device management, documentation, and more.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this just before </body> -->
    <script>
        // Toast function
        function showToast(msg) {
            let toast = document.createElement('div');
            toast.innerText = msg;
            toast.className = "fixed bottom-8 right-8 z-50 bg-red-600 text-white px-6 py-3 rounded shadow-lg text-lg font-semibold animate-bounce";
            toast.style.minWidth = "220px";
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 2200);
        }

        // Attach click handler to disabled sidebar links
        document.querySelectorAll('.sidebar a[data-disabled="1"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showToast('First connect to some device');
            });
        });
    </script>
</body>
</html>