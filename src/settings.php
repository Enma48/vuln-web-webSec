<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Data hash statis sesuai permintaan Anda
$legacy_hash_from_db = '97d76fe3211836509af8315b2f2900b4';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Course Shop - Settings</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .settings-content {
            padding: 20px;
        }
        .card-box {
            background-color: #2c2c38;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"], 
        .form-group input[type="password"],
        .form-group input[type="checkbox"] {
            /* Menyesuaikan style untuk checkbox agar lebih rapi */
            margin-right: 10px;
        }
        .form-group input[type="text"], 
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #444;
            background-color: #2a2a2e;
            color: white;
            font-family: 'Roboto Mono', monospace;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .detail-item {
            margin-bottom: 10px;
        }
        .detail-item strong {
            display: inline-block;
            width: 250px;
        }
        .sub-card {
            border-bottom: 1px solid #444;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .sub-card:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .download-link {
            background-color: #6c757d;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .download-link:hover {
            background-color: #5a6268;
        }
        .legacy-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="#">My Courses</a>
            <a href="profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>">My Profile</a>
            <a href="settings.php" class="active">Settings</a>
            <a href="support.php">Support</a>
            <a href="logout.php">Logout</a>
        </nav>
    </aside>

    <header class="header">
        <div class="header-left">
            <button class="hamburger-btn" id="hamburger-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="dashboard.php" class="logo">CyberCourse</a>
        </div>
        <div class="header-right">
            <div class="profile">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <div class="profile-icon">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container settings-content">
            <h1>Account Settings</h1>
            <p>Manage your account preferences and security settings here.</p>

            <div class="card-box">
                <h2 style="margin-top: 0;">General Account Settings</h2>
                <div class="sub-card">
                    <h3 style="margin-top: 0;">Change Username</h3>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="new_username">New Username:</label>
                            <input type="text" id="new_username" name="new_username" placeholder="Enter your new username">
                        </div>
                        <button type="submit" class="btn-submit">Update Username</button>
                    </form>
                </div>
                
                <div class="sub-card">
                    <h3 style="margin-top: 0;">Change Password</h3>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="current_password">Current Password:</label>
                            <input type="password" id="current_password" name="current_password" placeholder="Enter your current password">
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" id="new_password" name="new_password" placeholder="Enter your new password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
                        </div>
                        <button type="submit" class="btn-submit">Update Password</button>
                    </form>
                </div>
            </div>

            <div class="card-box">
                <div class="legacy-header">
                    <h2 style="margin: 0;">Legacy System Security Notes</h2>
                    <a href="guesses.txt" download class="download-link">Download Wordlist</a>
                </div>
                <p>This information is for developers only and details our old, insecure hashing method. It is intentionally left here for backward compatibility and is part of a security challenge. You will need this to solve the verification above.</p>
                <div class="detail-item">
                    <strong>Hashed Data from our old system:</strong>
                    <span style="font-family: 'Roboto Mono', monospace; color: #a0a0a0; word-break: break-all;">
                        <?= htmlspecialchars($legacy_hash_from_db); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Hashing Algorithm:</strong> MD5
                </div>
            </div>

            <div class="card-box">
                <h3 style="margin-top: 0;">Notification Preferences</h3>
                <p>Manage which notifications you receive.</p>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="notification_email" checked> Email Notifications
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="notification_sms"> SMS Notifications
                    </label>
                </div>
            </div>

            <div class="card-box">
                <h3 style="margin-top: 0;">Account Management</h3>
                <p>Permanently delete your account and all associated data.</p>
                <button class="btn-submit" style="background-color: #dc3545;">Delete Account</button>
            </div>
            
        </div>
    </main>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const closeBtn = document.getElementById('close-btn');
        const sidebar = document.getElementById('sidebar');

        if (hamburgerBtn && closeBtn && sidebar) {
            function toggleSidebar() {
                sidebar.classList.toggle('active');
            }
            hamburgerBtn.addEventListener('click', toggleSidebar);
            closeBtn.addEventListener('click', toggleSidebar);
        }
    });
    </script>

</body>
</html>