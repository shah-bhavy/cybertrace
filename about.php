<?php
// about.php - About Us page for CyberTrace
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - CyberTrace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3a8a 0%, #111827 100%); font-family: 'Inter', sans-serif; }
        .profile-card {
            background: rgba(255,255,255,0.97);
            border-radius: 1.5rem;
            box-shadow: 0 10px 24px rgba(59,130,246,0.10);
            padding: 2.5rem 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .profile-card:hover {
            transform: translateY(-4px) scale(1.025);
            box-shadow: 0 16px 32px rgba(59,130,246,0.18);
        }
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #3b82f6 60%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="text-gray-800">
    <!-- Floating Back to Dashboard Button -->
    <a href="dashboard.php"
       class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 font-semibold text-lg transition-all"
       style="box-shadow: 0 8px 32px rgba(30,64,175,0.25);">
        <i class="fas fa-arrow-left"></i>
        Back to Dashboard
    </a>
    <div class="flex flex-col items-center min-h-screen px-4 py-10">
        <div class="w-full max-w-3xl mb-10">
            <h1 class="text-4xl font-extrabold text-white mb-4 flex items-center gap-3">
                <i class="fas fa-users text-blue-300"></i> Meet the CyberTrace Team
            </h1>
            <p class="text-lg text-blue-100 mb-8">
                CyberTrace is the result of a unique collaboration between passionate minds in software development and cyber security. Our mission is to empower digital investigations with powerful, user-friendly tools that bridge the gap between technology and real-world forensics.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-3xl">
            
            <!-- CyberSec Side -->
            <div class="profile-card flex flex-col items-center text-center">
                <div class="avatar bg-gradient-to-br from-green-500 to-green-900 shadow-lg mb-3">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h2 class="text-2xl font-bold text-blue-900 mb-1">Harsh Kothari</h2>
                <div class="text-green-600 font-semibold mb-2">Cyber Security Specialist</div>
                <p class="text-gray-700 mb-3">
                    Harsh brings his expertise in cyber security and digital forensics to the heart of CyberTrace. He ensures that every feature is designed with real investigative needs in mind, focusing on data integrity, privacy, and actionable intelligence. Harsh is dedicated to making digital investigations smarter and safer.
                </p>
                <div class="flex gap-3 text-green-500 text-xl">
                    <a href="mailto:harsh@example.com" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://linkedin.com/in/harshkothari" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <!-- Developer Side -->
            <div class="profile-card flex flex-col items-center text-center">
                <div class="avatar bg-gradient-to-br from-blue-500 to-blue-900 shadow-lg mb-3">
                    <i class="fas fa-code"></i>
                </div>
                <h2 class="text-2xl font-bold text-blue-900 mb-1">Bhavya Shah</h2>
                <div class="text-blue-500 font-semibold mb-2">Lead Developer</div>
                <p class="text-gray-700 mb-3">
                    Bhavya is the creative force behind CyberTrace's robust and intuitive interface. With a deep love for coding and problem-solving, he has crafted a platform that makes complex forensic tasks accessible to everyone. Bhavya believes in building technology that not only works, but truly empowers its users.
                </p>
                <div class="flex gap-3 text-blue-400 text-xl">
                    <a href="mailto:bhavya@example.com" title="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://github.com/bhavyashah" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
        <div class="w-full max-w-3xl mt-12">
            <div class="bg-white/90 rounded-2xl shadow-lg p-6 text-center">
                <h3 class="text-xl font-bold text-blue-900 mb-2"><i class="fas fa-bullseye text-blue-400 mr-2"></i>Our Mission</h3>
                <p class="text-gray-700">
                    We believe that technology should empower investigators, not stand in their way. CyberTrace is built to simplify digital forensics, making it accessible, efficient, and secure for professionals and enthusiasts alike.
                </p>
            </div>
        </div>
    </div>
</body>
</html>