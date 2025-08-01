<?php
session_start();

require_once 'db.php'; 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Course Shop - Dashboard</title>
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
            <a href="#">Dashboard</a>
            <a href="#">My Courses</a>
            <a href="profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>">My Profile</a>
            <a href="settings.php">Settings</a>
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
            <a href="#" class="logo">CyberCourse</a>
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
            <h1>Available Courses</h1>
            <p>Start your journey into cybersecurity with our expert-led courses.</p>
                <?php
                    if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'):
                ?>
                    <div class="flag-box">
                        <p class="flag-title">-- ADMIN FLAG UNLOCKED --</p>
                        <p class="flag-content">WebSec{g00k1LLL_#r4j4_SQLi_t3l4h#_d4t4n99999!!!}</p>
                    </div>
                <?php endif; ?>
            
           <div class="course-grid">
                <?php
                $sql = "SELECT title, description, link FROM courses";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                     while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="course-card">';
                        echo '    <div class="card-header">' . htmlspecialchars($row["title"]) . '</div>';
                        echo '    <div class="card-body">' . htmlspecialchars($row["description"]) . '</div>';
                        
                        $courseLink = $row["link"];
                        
                        if (stripos($row["title"], 'SQL Injection') !== false || stripos($row["title"], 'SQLi') !== false) {
                             $courseLink = 'sqli_course.php';
                            }
                        elseif (stripos($row["title"], 'XSS') !== false || stripos($row["title"], 'Cross-Site Scripting') !== false || stripos($row["title"], 'XSS for PENTESTERS') !== false) {
                             $courseLink = 'xss_course.php';
                            }
                        
                        echo '    <div class="card-footer"><a href="' . htmlspecialchars($courseLink) . '" class="btn">View Course</a></div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Belum ada course yang tersedia saat ini.</p>";
                }
                ?>
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
<?php
// Tutup koneksi database
mysqli_close($conn);
?>