<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$profile_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;


$sql = "SELECT id, username, bio, legacy_secret_hash FROM users WHERE id = ?";
$user_data = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $profile_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        $user_data['username'] = "Not Found"; 
        $user_data['bio'] = "<i>The requested user does not exist.</i>";
        $user_data['legacy_secret_hash'] = null; 
    }
    mysqli_stmt_close($stmt);
} else {
    die("Database query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - <?= htmlspecialchars($user_data['username']); ?></title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="#">My Courses</a>
            <a href="profile.php?user_id=<?= htmlspecialchars($_SESSION['id']); ?>" class="active">My Profile</a>
            <a href="#">Settings</a>
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
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-icon-large">
                        <?= strtoupper(substr(htmlspecialchars($user_data['username']), 0, 1)); ?>
                    </div>
                    <h2><?= htmlspecialchars($user_data['username']); ?></h2>
                </div>
                <div class="profile-body">
                    <h3>Bio:</h3>
                    <div class="bio-box">
                        <p>
                            <?php 
                                if (!empty($user_data['bio'])) {
                                    echo nl2br(htmlspecialchars($user_data['bio']));
                                } else {
                                    echo "<i>This user has not set a bio yet.</i>";
                                }
                            ?>
                        </p>
                    </div>

                    <?php if (isset($user_data['legacy_secret_hash']) && !empty($user_data['legacy_secret_hash'])): ?>
                    <div class="sensitive-data-section" style="background-color: #2c2c38; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                        <h2>Legacy System Data (Admin Only)</h2>
                        <p>This section contains a unique identifier from our old system for certain administrative accounts. It's hashed for security, but we don't use this method anymore.</p>
                        <div class="detail-item">
                            <strong>Legacy Secret Hash:</strong>
                            <span style="font-family: 'Roboto Mono', monospace; color: #a0a0a0; word-break: break-all;">
                                <?= htmlspecialchars($user_data['legacy_secret_hash']); ?>
                            </span>
                            <p style="font-size: 0.8em; color: #777; margin-top: 5px;">*This hash should ideally not be visible. Can you find the original secret?</p>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <div class="profile-footer">
                    <a href="dashboard.php" class="btn">&larr; Back to Dashboard</a>
                </div>
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