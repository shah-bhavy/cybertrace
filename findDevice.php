<!-- dashboard.php -->
<?php
require 'config.php';
if (!isAccessGranted()) {
    header("Location: index.php");
    exit;
}
$devices = getDevices();
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
        .btn-primary { background: linear-gradient(to right, #1e3a8a, #3b82f6); transition: all 0.3s ease; }
        .btn-primary:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4); }
        .modal { display: none; }
        .modal.active { display: flex; }
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
                <a href="#" class="block p-4 bg-blue-900/50 flex items-center"><i class="fas fa-plug mr-3"></i> Connect Device</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-eye mr-3"></i> Data Preview</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-brain mr-3"></i> AI Insights</a>
                <a href="#" class="block p-4 hover:bg-blue-900/50 flex items-center"><i class="fas fa-file-export mr-3"></i> Export Report</a>
            </nav>
            <a href="logout.php" class="block p-4 hover:bg-blue-900/50 flex items-center text-red-400">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>
        </div>
        <div class="flex-1 p-8 overflow-auto">
            <h2 class="text-3xl font-bold mb-6 text-white flex items-center"><i class="fas fa-plug mr-3"></i> Connect Available Devices</h2>
            <div id="deviceGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        </div>
    </div>
    <script>
        function renderDevices(devices) {
            let html = '';
            devices.forEach(device => {
                html += `
                <div class="card p-6 rounded-2xl cursor-pointer flex items-center justify-between group" onclick="window.location.href='connect.php?device_id=${device.id}'">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">${device.name}</h3>
                    </div>
                    <button class="ml-4 flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-700 opacity-80 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>`;
            });
            document.getElementById('deviceGrid').innerHTML = html;
        }

        function fetchDevices() {
            fetch('devices.php')
                .then(res => res.json())
                .then(data => renderDevices(data));
        }

        // Poll every 1000ms (1 second)
        setInterval(fetchDevices, 1000);
        fetchDevices(); // Initial load
    </script>
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
        document.querySelectorAll('.sidebar a:not([href="dashboard.php"]):not([href="#"]):not(.bg-blue-900\\/50)').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showToast('First connect to some device');
            });
        });

        // For this sidebar, disable all except Dashboard and Connect Device
        document.querySelectorAll('.sidebar a:not([href="dashboard.php"]):not(.bg-blue-900\\/50)').forEach(link => {
            link.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none', 'bg-gray-800');
            link.removeAttribute('href');
        });
    </script>
</body>
</html>