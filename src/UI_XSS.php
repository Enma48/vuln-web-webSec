<?php
session_start();
// Proteksi login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS for Pentesters - CyberCourse</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        .lesson-container {
            margin-bottom: 15px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #334155;
            transition: all 0.3s ease;
        }
        
        .lesson-box {
            background-color: #1e293b;
            color: #f8fafc;
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .lesson-box:hover {
            background-color: #334155;
        }
        
        .lesson-container.active .lesson-box {
            background-color: #334155;
        }
        
        .lesson-title {
            font-size: 1.1rem;
        }
        
        .lesson-arrow {
            font-size: 1.2rem;
            color: #38f2af;
            transition: transform 0.3s ease;
        }
        
        .lesson-container.active .lesson-arrow {
            transform: rotate(180deg);
        }
        
        .lesson-content {
            background-color: #0f172a;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            border-top: 1px solid #334155;
        }
        
        .lesson-container.active .lesson-content {
            max-height: 300px;
            padding: 25px;
        }
        
        .lesson-description {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .learn-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 12px 24px;
            background: #64FFDA;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .learn-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(100, 255, 218, 0.4);
            background: #4FDFBA;
        }
        
        .course-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .course-title {
            font-size: 2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .course-desc {
            font-size: 1.1rem;
            color: #cbd5e1;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .course-selection {
            display: grid;
            gap: 15px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-btn" id="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="#">My Courses</a>
            <a href="profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>">My Profile</a>
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
            <a href="#" class="logo">CyberCourse</a>
        </div>
        <div class="header-right">
            <div class="profile">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <div class="profile-icon">
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="course-container">
            <div style="margin-bottom: 20px;">
                <a href="dashboard.php" style="color: #38f2af; text-decoration: none; font-size: 0.9rem;">
                    ← Back to Dashboard
                </a>
            </div>
            <div class="course-title">XSS for Pentesters: Course Overview</div>
            <div class="course-desc">
                This course offers a deep dive into Cross-Site Scripting (XSS) for penetration testers. You'll gain practical skills to identify, exploit, and report XSS flaws, learning attacker techniques 
                and providing actionable remediation advice for real-world scenarios.
            </div>
            <div class="course-selection">
                <!-- Lesson 1 -->
                <div class="lesson-container" data-lesson="1">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 1: XSS Fundamentals and Attack Vectors</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Master the fundamentals of Cross-Site Scripting vulnerabilities. Learn about different types of XSS (Reflected, Stored, DOM-based), understand how they work, and explore common attack vectors used by penetration testers to identify and exploit these vulnerabilities in web applications.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 2 -->
                <div class="lesson-container" data-lesson="2">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 2: Manual and Automated Techniques of XSS</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Develop comprehensive testing methodologies for XSS discovery. Learn manual testing techniques, browser developer tools usage, and automated scanning approaches. Understand how to combine tools like Burp Suite, OWASP ZAP, and custom scripts for effective XSS testing.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 3 -->
                <div class="lesson-container" data-lesson="3">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 3: Crafting and Bypassing XSS Payloads</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Learn advanced payload crafting techniques and filter evasion methods. Master encoding schemes, obfuscation techniques, and WAF bypass strategies. Understand how to create custom payloads for different contexts and bypass common security controls and input validation.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 4 -->
                <div class="lesson-container" data-lesson="4">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 4: Advanced Techniques to Exploiting XSS</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Explore advanced exploitation techniques and post-exploitation scenarios. Learn about session hijacking, CSRF token extraction, keylogging, phishing attacks, and browser exploitation through XSS. Understand how to chain XSS with other vulnerabilities for maximum impact.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
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

        // Expandable lesson panels
        const lessonContainers = document.querySelectorAll('.lesson-container');
        
        lessonContainers.forEach(container => {
            const lessonBox = container.querySelector('.lesson-box');
            
            lessonBox.addEventListener('click', function() {
                // Close all other panels
                lessonContainers.forEach(otherContainer => {
                    if (otherContainer !== container) {
                        otherContainer.classList.remove('active');
                    }
                });
                
                // Toggle current panel
                container.classList.toggle('active');
            });
        });
    });
    </script>
</body>
</html>