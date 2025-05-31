<html>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</html>

<p align="center">
    <i class="fas fa-shield-alt mr-3 text-blue-400"></i>
</p>
<h1 align="center">CYBERTRACE</h1>
<p align="center">
	<em><code>A Modern Forensic & Investigation Tool for Android Devices</code></em>
</p>
<p align="center">
	<img src="https://img.shields.io/github/license/shah-bhavy/cybertrace?style=default&logo=opensourceinitiative&logoColor=white&color=0080ff" alt="license">
	<img src="https://img.shields.io/github/last-commit/shah-bhavy/cybertrace?style=default&logo=git&logoColor=white&color=0080ff" alt="last-commit">
	<img src="https://img.shields.io/github/languages/top/shah-bhavy/cybertrace?style=default&color=0080ff" alt="repo-top-language">
	<img src="https://img.shields.io/github/languages/count/shah-bhavy/cybertrace?style=default&color=0080ff" alt="repo-language-count">
</p>

**CyberTrace** is a powerful, open-source forensic and investigation tool for Android devices, built with PHP and ADB. Featuring a sleek, dark-themed dashboard powered by Tailwind CSS and FontAwesome, it offers real-time insights into call logs, messages, device directories, and AI-driven analytics. Run it as a web app with XAMPP or as a standalone Windows desktop app with PHP Desktop.

---

## 🚀 Features

- 🔌 **Device Connection**: Seamlessly connect to Android devices via ADB.
- 📞 **Call Logs Preview**: Group and analyze call logs by date, type, and contact.
- 💬 **Messages Preview**: Browse SMS, with AI-powered suspicious message detection.
- 📁 **Directory Browser**: Explore device folders and files with ease.
- 🧠 **AI Insights**: Smart summaries including total contacts, suspicious messages, unknown callers, most contacted individuals, and external APKs.
- 📊 **Export Insights**: Download AI insights as CSV reports.
- 🎨 **Modern UI**: Responsive, dark-themed interface with Tailwind CSS and FontAwesome icons.
- 🔒 **Session Security**: Access key protection for secure dashboard access.
- 🚪 **Secure Logout**: Log out securely from any page.
- 💻 **Portable**: Run as a web app (XAMPP) or a Windows desktop app (PHP Desktop).

---

## 📸 Screenshots

| Dashboard | Call Logs | AI Insights |
| --- | --- | --- |
|  |  |  |

*Add your own screenshots to the* `screenshots/` *folder and update the links above.*

---

## 🛠️ Requirements

- **Operating System**: Windows
- **ADB**: Android Debug Bridge (Platform Tools)
- **PHP**: Version 7.4 or higher
- **Web Server**: XAMPP (for web app) or PHP Desktop (for desktop app)
- **Android Device**: USB debugging enabled

---

## ⚙️ Installation

### 1. Install ADB

1. Download Android Platform Tools for Windows.
2. Extract to a folder (e.g., `C:\platform-tools`).
3. (Optional) Add the folder to your system PATH.
4. Update the ADB path in `config.php` to match your installation.

### 2. Web Version (XAMPP)

1. Download and install XAMPP.
2. Start Apache from the XAMPP Control Panel.
3. Place the project folder (e.g., `cccs`) in `C:\xampp\htdocs\`.
4. Open `http://localhost/cccs/index.php` in your browser.

### 3. Desktop Version (PHP Desktop)

1. Download PHP Desktop (Chrome).
2. Extract to a folder (e.g., `C:\phpdesktop`).
3. Copy project files to the `www` folder in the PHP Desktop directory.
4. Edit `settings.json`:

   ```json
   {
     "default_url": "index.php",
     "www_directory": "www",
     "start_fullscreen": true,
     "default_size": [1600, 900]
   }
   ```
5. Double-click `phpdesktop-chrome.exe` to launch.

---

## 📖 Usage

1. Connect your Android device via USB with USB debugging enabled.
2. Start ADB (auto-starts if in PATH).
3. Launch CyberTrace:
   - **Web**: Navigate to `http://localhost/cccs/index.php`.
   - **Desktop**: Run `phpdesktop-chrome.exe`.
4. Enter your access key to unlock the dashboard.
5. Explore features:
   - **Call Logs**: View and group call logs, identify callers.
   - **Messages**: Browse SMS, flag suspicious content, view chat history.
   - **Directories**: Navigate device folders.
   - **AI Insights**: Access smart summaries and export as CSV.
6. Log out securely from any page.

---

## 📂 File Structure

```
cccs/
├── api/
    ├── mock.php 
├── config.php           # Configuration and session management
├── index.php           # Access key entry and login
├── dashboard.php       # Main dashboard UI
├── connect.php         # Device connection and main cards
├── findDevice.php      # Device discovery page
├── previewDetails.php  # Call logs preview
├── previewMessages.php # Messages preview
├── aiInsights.php      # AI insights cards
├── logout.php          # Secure logout
├── assets/             # CSS, JS, and other resources
```

---

## 🔧 ADB Setup Tips

- Enable **Developer Options** and **USB Debugging** on your Android device.
- Connect via USB and run `adb devices` in a terminal to verify.
- If the device isn't detected, check drivers or try a different cable/port.

---

## 🛡️ Troubleshooting

- **Session Errors**: Ensure no whitespace before `<?php` in PHP files, especially `config.php`.
- **ADB Not Found**: Verify the ADB path in `config.php` and system PATH.
- **Permissions**: Run XAMPP or PHP Desktop as administrator if needed.
- **Device Not Detected**: Ensure USB debugging is enabled and the device is authorized.

---

## 🎨 Customization

- **AI Insights**: Modify `aiInsights.php` and `connect.php` for additional insights.
- **ADB Path**: Update `$adbPath` in `config.php` for custom ADB locations.
- **Styling**: Tweak Tailwind CSS and FontAwesome in the `assets/` folder.

---

## 📜 License

CyberTrace is licensed under the MIT License.

---

## 🙌 Credits

- PHP Desktop
- Tailwind CSS
- FontAwesome
- Android Platform Tools (ADB)

---

## 📬 Contact

- **GitHub Issues**: Open an Issue
- **Email**: bhavyashahbvs@gmail.com

---

⭐ **Star this repo** if CyberTrace helps your forensic investigations!\
Happy investigating! 🕵️‍♂️
