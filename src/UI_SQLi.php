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
    <title>SQL Injection Mastery - CyberCourse</title>
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
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
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
            <div class="course-title">SQL Injection Mastery: Course Overview</div>
            <div class="course-desc">
                This course offers a practical guide to SQL Injection vulnerabilities, covering how they function, identification methods, and crucially, prevention. 
                Geared towards developers and security professionals, it emphasizes defensive programming and secure coding to protect web applications from this common threat.
            </div>
            <div class="course-selection">
                <!-- Lesson 1 -->
                <div class="lesson-container" data-lesson="1">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 1: SQL Injection Fundamentals</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Learn the basics of SQL Injection attacks, including how they work, common attack vectors, and why they remain one of the most dangerous web vulnerabilities. This lesson covers the fundamental concepts, types of SQL injection, and real-world examples to help you understand the threat landscape.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 2 -->
                <div class="lesson-container" data-lesson="2">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 2: Detecting SQL Injection Vulnerabilities</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Master the techniques for identifying SQL injection vulnerabilities in web applications. This lesson covers manual testing methods, automated scanning tools, code review practices, and how to recognize vulnerable code patterns in different programming languages and frameworks.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 3 -->
                <div class="lesson-container" data-lesson="3">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 3: Defensive Strategies for SQLi</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Explore comprehensive defense mechanisms against SQL injection attacks. This lesson covers parameterized queries, stored procedures, input validation, output encoding, and the principle of least privilege. Learn how to implement multiple layers of security to protect your applications.
                        </div>
                        <button class="learn-button" onclick="return false;">Learn This Topic</button>
                    </div>
                </div>

                <!-- Lesson 4 -->
                <div class="lesson-container" data-lesson="4">
                    <div class="lesson-box">
                        <span class="lesson-title">Lesson 4: Practical Prevention and Advanced Mitigation Techniques</span>
                        <span class="lesson-arrow">&#x25BC;</span>
                    </div>
                    <div class="lesson-content">
                        <div class="lesson-description">
                            Apply advanced prevention techniques and implement enterprise-level security measures. This lesson covers Web Application Firewalls (WAF), database security hardening, monitoring and logging strategies, and how to create a comprehensive security framework for production environments.
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