<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Course Shop - Support</title>
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
        <a href="#">My Profile</a>
        <a href="settings.php">Settings</a>
        <a href="support.php" class="active">Support</a>
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
        <h1>Support Center</h1>
        <p>We're here to help you with any questions or issues you might have.</p>

        <?php
        $receivedMessage = isset($_GET['message']) ? $_GET['message'] : '';

        if (!empty($receivedMessage)): ?>
            <div class="success-message">Thank you! Your feedback has been received.</div>
            <div class="feedback-submitted-box" style="background-color: #2c2c38; padding: 1rem; border-radius: 5px; margin: 2rem 0;">
                <h3>Your submitted message:</h3>
                <p><?php echo $receivedMessage; ?></p>
            </div>
        <?php endif; ?>

        <div class="support-section">
            <h2>Frequently Asked Questions (FAQ)</h2>
            <div class="faq-item">
                <h3>How do I enroll in a course?</h3>
                <p>To enroll in a course, simply browse our available courses on the dashboard, click on the course you're interested in, and follow the enrollment instructions.</p>
            </div>
            <div class="faq-item">
                <h3>What payment methods are accepted?</h3>
                <p>We accept various payment methods including credit cards (Visa, MasterCard, American Express) and PayPal.</p>
            </div>
            <div class="faq-item">
                <h3>Can I get a refund?</h3>
                <p>Our refund policy allows for full refunds within 7 days of purchase, provided you have not completed more than 10% of the course content.</p>
            </div>
        </div>

        <div class="support-section">
            <h2>Need Further Assistance?</h2>
            <p>If you couldn't find your answer in the FAQ, please feel free to reach out to us. Our support team is ready to help!</p>
            <ul class="support-contact-info">
                <li><strong>Email:</strong> ksmcyberupnvj@cyber.com</li>
                <li><strong>Phone:</strong> +62 123 4567 890</li>
            </ul>
            <button id="openGiveFeedbackModal" class="contact-button">Berikan Kami Masukan or Report</button>
        </div>
    </div>
</main>

<div id="giveFeedbackModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-button" id="closeGiveFeedbackModal">&times;</span>
        <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! Give us feedback or report</h2>
        <form id="feedbackForm" action="support.php" method="GET">
            <textarea id="feedback_message" name="message" rows="5" required placeholder="Tulis pesan di sini..."></textarea>
            <button type="submit" class="send-button">Send!</button>
        </form>
    </div>
</div>

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

    const openModalBtn = document.getElementById('openGiveFeedbackModal');
    const closeModalBtn = document.getElementById('closeGiveFeedbackModal');
    const feedbackModal = document.getElementById('giveFeedbackModal');
    if (openModalBtn && closeModalBtn && feedbackModal) {
        openModalBtn.onclick = function() {
            feedbackModal.style.display = "flex";
        }
        closeModalBtn.onclick = function() {
            feedbackModal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == feedbackModal) {
                feedbackModal.style.display = "none";
            }
        }
    }
});
</script>

<?php
if (isset($_GET['message'])) {
    $xssTestMessage = $_GET['message']; 

    if (strpos($xssTestMessage, "<script>window.location.href='flag.php'</script>") !== false) {
        $_SESSION['can_see_flag'] = true; 

        echo "<script>window.location.href='flag.php'</script>";
        exit();
    }

    else if (preg_match('/<script.*?>.*<\/script>/i', $xssTestMessage)) {
        echo "<script>alert('Selamat nemu part 2: _In1_Ud4H_K3t3mU_fl@gny4}');</script>";
    }
}
?>

</body>
</html>