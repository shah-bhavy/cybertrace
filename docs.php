<?php
// docs.php - Modern documentation page for CyberTrace
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CyberTrace Documentation</title>
    <meta name="viewport" content="width=1200, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .doc-section { background: rgba(255,255,255,0.95); }
        .doc-nav a.active { background: #1e3a8a; color: #fff; }
        .doc-nav a { transition: background 0.2s, color 0.2s; }
        .doc-section code { background: #f3f4f6; color: #1e40af; padding: 2px 6px; border-radius: 4px; }
        .doc-section pre { background: #f3f4f6; color: #1e40af; padding: 12px; border-radius: 8px; }
        .doc-section ul { list-style: disc; margin-left: 1.5rem; }
        .doc-section li { margin-bottom: 0.5rem; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 to-indigo-900 min-h-screen text-gray-800">
    <!-- Floating Back to Dashboard Button -->
    <a href="dashboard.php"
       class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 font-semibold text-lg transition-all"
       style="box-shadow: 0 8px 32px rgba(30,64,175,0.25);">
        <i class="fas fa-arrow-left"></i>
        Back to Dashboard
    </a>
    <div class="flex flex-col items-center min-h-screen px-4 py-8">
        <div class="w-full max-w-5xl">
            <div class="flex items-center gap-4 mb-8">
                <i class="fas fa-book text-4xl text-blue-300"></i>
                <h1 class="text-4xl font-extrabold text-white">CyberTrace Documentation</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Sidebar Navigation -->
                <nav class="doc-nav flex flex-col gap-2 md:col-span-1">
                    <a href="#overview" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Overview</a>
                    <a href="#features" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Features</a>
                    <a href="#requirements" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Requirements</a>
                    <a href="#installation" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Installation</a>
                    <a href="#usage" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Usage Guide</a>
                    <a href="#troubleshooting" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Troubleshooting</a>
                    <a href="#faq" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">FAQ</a>
                    <a href="#credits" class="rounded-lg px-4 py-2 font-semibold text-blue-900 bg-white/80 hover:bg-blue-100">Credits</a>
                </nav>
                <!-- Main Documentation Content -->
                <div class="doc-section rounded-2xl shadow-lg p-8 md:col-span-3">
                    <section id="overview" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-info-circle"></i> Overview</h2>
                        <p>
                            <b>CyberTrace</b> is a modern forensic and investigation dashboard for Android devices. It allows you to connect, preview, and analyze device data (calls, messages, directories, AI insights) using a beautiful, secure, and responsive interface.
                        </p>
                    </section>
                    <section id="features" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-star"></i> Features</h2>
                        <ul>
                            <li><b>Device Discovery & Connection</b> via ADB</li>
                            <li><b>Call Logs Preview</b> (grouped by date/type, identify unknown callers)</li>
                            <li><b>SMS Messages Preview</b> (grouped by contact, suspicious message detection)</li>
                            <li><b>Directory Browser</b> (explore device folders)</li>
                            <li><b>AI Insights</b> (contacts, suspicious messages, unknown callers, most called/chatted, external APKs)</li>
                            <li><b>Export AI Insights</b> as CSV</li>
                            <li><b>Modern UI</b> with Tailwind CSS & FontAwesome</li>
                            <li><b>Session Security</b> (access key, logout)</li>
                            <li><b>Portable</b> (web or desktop app)</li>
                        </ul>
                    </section>
                    <section id="requirements" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-cogs"></i> Requirements</h2>
                        <ul>
                            <li>Windows OS</li>
                            <li>ADB (Android Debug Bridge)</li>
                            <li>PHP 7.4+</li>
                            <li>XAMPP (for web) or PHP Desktop (for desktop)</li>
                            <li>Android device with USB debugging enabled</li>
                        </ul>
                    </section>
                    <section id="installation" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-download"></i> Installation</h2>
                        <ol class="list-decimal ml-6 mb-4">
                            <li>
                                <b>ADB Setup:</b>
                                <ul>
                                    <li>Download <a href="https://developer.android.com/studio/releases/platform-tools" class="text-blue-600 underline" target="_blank">Android Platform Tools</a> and extract to <code>C:\platform-tools</code>.</li>
                                    <li>(Optional) Add <code>C:\platform-tools</code> to your Windows PATH.</li>
                                    <li>Enable <b>Developer Options</b> and <b>USB Debugging</b> on your Android device.</li>
                                    <li>Connect your device via USB and run <code>adb devices</code> to verify.</li>
                                </ul>
                            </li>
                            <li>
                                <b>XAMPP Setup (Web):</b>
                                <ul>
                                    <li>Download and install <a href="https://www.apachefriends.org/index.html" class="text-blue-600 underline" target="_blank">XAMPP</a>.</li>
                                    <li>Start <b>Apache</b> from the XAMPP Control Panel.</li>
                                    <li>Copy the CyberTrace project folder (e.g., <code>cccs</code>) to <code>C:\xampp\htdocs\</code>.</li>
                                    <li>Open <code>http://localhost/cccs/index.php</code> in your browser.</li>
                                </ul>
                            </li>
                            <li>
                                <b>PHP Desktop Setup (Desktop App):</b>
                                <ul>
                                    <li>Download <a href="https://github.com/cztomczak/phpdesktop/releases" class="text-blue-600 underline" target="_blank">phpdesktop-chrome</a>.</li>
                                    <li>Extract to a folder (e.g., <code>C:\phpdesktop</code>).</li>
                                    <li>Copy all CyberTrace files into the <code>www</code> folder inside PHP Desktop.</li>
                                    <li>Edit <code>settings.json</code>:
                                        <ul>
                                            <li><code>"default_url": "index.php"</code></li>
                                            <li><code>"www_directory": "www"</code></li>
                                            <li><code>"start_fullscreen": true</code>, <code>"default_size": [1600, 900]</code> for 16:9 fullscreen.</li>
                                        </ul>
                                    </li>
                                    <li>Run <code>phpdesktop-chrome.exe</code>.</li>
                                </ul>
                            </li>
                        </ol>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded mb-2">
                            <b>ADB Path:</b> Edit <code>config.php</code> and set the correct path for <code>$adbPath</code>.<br>
                            <code>$adbPath = "C:\\platform-tools\\adb.exe";</code>
                        </div>
                    </section>
                    <section id="usage" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-play-circle"></i> Usage Guide</h2>
                        <ol class="list-decimal ml-6 mb-4">
                            <li><b>Access Key & Login:</b> On first launch, enter your access key to unlock the dashboard.</li>
                            <li><b>Dashboard Overview:</b> Use the sidebar to navigate between features. Disabled features are faded until a device is connected.</li>
                            <li><b>Device Connection:</b> Go to <b>Connect Device</b> to scan for available Android devices via ADB. Click a device to connect and view its data.</li>
                            <li><b>Call Logs:</b> Access <b>Calls Preview</b> to see all call logs grouped by date and type. Identify unknown numbers with the "Identify" button.</li>
                            <li><b>Messages:</b> Access <b>Messages</b> to view SMS grouped by contact. Suspicious messages are flagged. Click a contact to view the full chat history.</li>
                            <li><b>Directory Browser:</b> Explore main folders and files on the device. Click "Main folders" to expand/collapse the directory view.</li>
                            <li><b>AI Insights:</b> Go to <b>AI Insights</b> for smart summaries (contacts, suspicious messages, unknown callers, etc.).</li>
                            <li><b>Exporting Insights:</b> Click <b>Export AI Insights</b> to download a CSV report for the connected device.</li>
                            <li><b>Logout:</b> Use the <b>Logout</b> button in the sidebar to securely end your session.</li>
                        </ol>
                    </section>
                    <section id="troubleshooting" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-tools"></i> Troubleshooting</h2>
                        <ul>
                            <li><b>Session errors:</b> Ensure no whitespace before <code>&lt;?php</code> in PHP files, especially <code>config.php</code>.</li>
                            <li><b>ADB not found:</b> Check the path in <code>config.php</code> and your system PATH.</li>
                            <li><b>Device not detected:</b> Ensure USB debugging is enabled and device is authorized.</li>
                            <li><b>Permissions:</b> Run XAMPP/PHP Desktop as administrator if needed.</li>
                        </ul>
                    </section>
                    <section id="faq" class="mb-10">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-question-circle"></i> FAQ</h2>
                        <ul>
                            <li><b>Can I use this on Linux/Mac?</b> The project is designed for Windows, but may work on other OSes with PHP and ADB installed.</li>
                            <li><b>How do I add more AI insights?</b> Edit <code>aiInsights.php</code> and the export logic in <code>connect.php</code>.</li>
                            <li><b>Is my data secure?</b> All data is processed locally. No data is sent to external servers.</li>
                        </ul>
                    </section>
                    <section id="credits">
                        <h2 class="text-2xl font-bold mb-3 text-blue-900 flex items-center gap-2"><i class="fas fa-user-friends"></i> Credits</h2>
                        <ul>
                            <li><a href="https://github.com/cztomczak/phpdesktop" class="text-blue-600 underline" target="_blank">PHP Desktop</a></li>
                            <li><a href="https://tailwindcss.com/" class="text-blue-600 underline" target="_blank">Tailwind CSS</a></li>
                            <li><a href="https://fontawesome.com/" class="text-blue-600 underline" target="_blank">FontAwesome</a></li>
                            <li><a href="https://developer.android.com/studio/releases/platform-tools" class="text-blue-600 underline" target="_blank">Android Platform Tools (ADB)</a></li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</body>
</html>