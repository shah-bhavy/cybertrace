# CyberTrace

**CyberTrace** is a forensic and investigation tool for Android devices, built with PHP and ADB. It provides a modern dashboard to preview call logs, messages, device directories, AI-powered insights, and more. The project can be run as a web app (with XAMPP) or as a standalone Windows desktop app using PHP Desktop.

---

## Features

- **Device Connection:** Detect and connect to Android devices via ADB.
- **Call Logs Preview:** View and group call logs by date, type, and contact.
- **Messages Preview:** Browse SMS messages, grouped by contact, with suspicious message detection.
- **Directory Browser:** Explore main folders and files on the connected device.
- **AI Insights:** Get smart summaries like total contacts, suspicious messages, unknown callers, most called/chatted contacts, and external APKs installed.
- **Export AI Insights:** Download AI insights as a CSV report.
- **Modern UI:** Responsive, dark-themed interface with Tailwind CSS and FontAwesome icons.
- **Session Security:** Access key protection for the dashboard.
- **Logout:** Secure logout from any page.
- **Portable:** Can be run as a web app (XAMPP) or packaged as a Windows EXE (PHP Desktop).

---

## Screenshots

> _Add screenshots here of the dashboard, call logs, messages, AI insights, etc._

---

## Requirements

- **Windows OS**
- **ADB (Android Debug Bridge)**
- **PHP 7.4+**
- **XAMPP** (for web server) or **PHP Desktop** (for desktop app)
- **Android device with USB debugging enabled**

---

## Installation

### 1. Install ADB

- Download the [Android Platform Tools](https://developer.android.com/studio/releases/platform-tools) for Windows.
- Extract the ZIP (e.g., to `C:\platform-tools`).
- Add the folder to your system PATH (optional, but recommended).
- Make sure `adb.exe` path in `config.php` matches your installation.

### 2. Install XAMPP (for web version)

- Download [XAMPP](https://www.apachefriends.org/index.html) and install.
- Start **Apache** from the XAMPP Control Panel.
- Place the project folder (e.g., `cccs`) in `C:\xampp\htdocs\`.
- Open `http://localhost/cccs/index.php` in your browser.

### 3. Install PHP Desktop (for desktop version)

- Download [phpdesktop-chrome](https://github.com/cztomczak/phpdesktop/releases) for Windows.
- Extract it (e.g., to `C:\phpdesktop`).
- Copy all your project files into the `www` folder inside the PHP Desktop directory.
- Edit `settings.json`:
    - Set `"default_url": "index.php"`
    - Set `"www_directory": "www"`
    - Set `"start_fullscreen": true` and `"default_size": [1600, 900]` for 16:9 fullscreen.
- Double-click `phpdesktop-chrome.exe` to run as a desktop app.

---

## Usage

1. **Connect your Android device** via USB and enable USB debugging.
2. **Start ADB** (it will auto-start if in your PATH).
3. **Launch CyberTrace** (via browser or desktop app).
4. **Enter your access key** to unlock the dashboard.
5. **Browse device data:**  
   - **Call Logs:** View, group, and identify callers.
   - **Messages:** Preview SMS, flag suspicious content, see chat history.
   - **Directories:** Explore device folders.
   - **AI Insights:** See smart summaries and export as CSV.
6. **Logout** securely from any page.

---

## File Structure

```
cccs/
│
├── config.php           # Configuration and session management
├── index.php            # Access key entry and login
├── dashboard.php        # Main dashboard UI
├── connect.php          # Device connection and main cards
├── findDevice.php       # Device discovery page
├── previewDetails.php   # Call logs preview
├── previewMessages.php  # Messages preview
├── aiInsights.php       # AI insights cards
├── logout.php           # Secure logout
├── ... (other assets, css, js, etc.)
```

---

## ADB Setup Tips

- Enable **Developer Options** and **USB Debugging** on your Android device.
- Connect your device via USB.
- Run `adb devices` in a terminal to verify connection.
- If not detected, check drivers or try a different cable/port.

---

## Troubleshooting

- **Session errors:** Ensure no whitespace before `<?php` in PHP files, especially `config.php`.
- **ADB not found:** Check the path in `config.php` and your system PATH.
- **Permissions:** Run XAMPP/PHP Desktop as administrator if needed.
- **Device not detected:** Ensure USB debugging is enabled and device is authorized.

---

## Customization

- **AI Insights:** Edit `aiInsights.php` and the export logic in `connect.php` to add more insights.
- **ADB Path:** Change the `$adbPath` variable in `config.php` if your ADB is in a different location.
- **Styling:** Tailwind CSS and FontAwesome are used for easy UI tweaks.

---

## Credits

- [PHP Desktop](https://github.com/cztomczak/phpdesktop)
- [Tailwind CSS](https://tailwindcss.com/)
- [FontAwesome](https://fontawesome.com/)
- [Android Platform Tools (ADB)](https://developer.android.com/studio/releases/platform-tools)

---

## License

MIT License (or your preferred license)

---

**Enjoy using CyberTrace for your Android forensic investigations!**
