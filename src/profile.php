<?php
session_start();
require_once "db.php";

//Otorisasi dilakukan di awal
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$profile_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($profile_id === 0) {
    die("User ID not specified.");
}

//Menambahkan agar hanya user dan admin yang bisa mengakses profil. Menghindari dan menyelesaikan Vulnerability IDOR
if ($_SESSION['user_id'] != $profile_id && $_SESSION['username'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    die("Anda tidak memiliki izin untuk mengakses profil ini");
}

if (isset($_GET['update_bio'])) {
    $profile_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    $new_bio = mysqli_real_escape_string($conn, $_GET['bio']);
    
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $current_host = $_SERVER['HTTP_HOST'];
    
    if (empty($referer) || strpos($referer, $current_host) === false) {
        $is_csrf_detected = true;
        $new_bio = "WebSec{🐐🐐🐐🐐🐐🐐🐐🐐🐐🐐🐐🐐}";
        
        $sql = "UPDATE users SET bio = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $new_bio, $profile_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        
        echo "<h1>CSRF Attack Detected!</h1>";
        echo "<p>Flag has been set in user bio.</p>";
        echo "<p><a href='profile.php?user_id={$profile_id}'>View Profile</a></p>";
        exit;
    }
}

$message = "";
$is_csrf_detected = false;

// Check if we're in edit mode
$edit_mode = isset($_GET['edit']);

// Handle GET request untuk update bio (NORMAL LOGGED IN USER)
if (isset($_GET['update_bio']) && isset($_SESSION["loggedin"])) {
    $new_bio = mysqli_real_escape_string($conn, $_GET['bio']);
    
    // Update bio in database
    $sql = "UPDATE users SET bio = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $new_bio, $profile_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Normal update, redirect without timestamp
            header("Location: profile.php?user_id={$profile_id}&bio_updated=success&new_bio=" . urlencode($new_bio));
            exit;
        } else {
            $message = "Error updating bio: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

$sql = "SELECT username, bio FROM users WHERE id = ?";
$user_data = [];

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $profile_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        die("User not found.");
    }
    mysqli_stmt_close($stmt);
}

$can_edit = ($_SESSION['user_id'] == $profile_id) || ($_SESSION['username'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - <?= htmlspecialchars($user_data['username']); ?></title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main-content">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-icon-large">
                        <?= strtoupper(substr(htmlspecialchars($user_data['username']), 0, 1)); ?>
                    </div>
                    <h2><?= htmlspecialchars($user_data['username']); ?></h2>
                </div>

                <!-- Display messages -->
                <?php if (!empty($message)): ?>
                    <div class="alert <?= $is_csrf_detected ? 'alert-flag' : 'alert-success'; ?>">
                        <?= htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

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

                    <!-- Edit Bio Section (Only show if in edit mode and user can edit) -->
                    <?php if ($edit_mode && $can_edit): ?>
                        <div class="course-card">
                            <div class="card-body">
                                <form method="GET" action="">
                                    <input type="hidden" name="user_id" value="<?= $profile_id; ?>">
                                    <div style="margin-bottom: 1rem;">
                                        <label for="bio" style="display: block; margin-bottom: 0.5rem;">Update Bio:</label>
                                        <textarea id="bio" name="bio" style="width: 100%; padding: 0.5rem; border-radius: 5px; border: 1px solid #ccc; min-height: 100px;"><?= htmlspecialchars($user_data['bio'] ?? ''); ?></textarea>
                                    </div>
                                    <button type="submit" name="update_bio" value="1" class="btn">Update</button>
                                    <a href="?user_id=<?= $profile_id; ?>" class="btn">Exit</a>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-footer">
                    <?php if (!$edit_mode && $can_edit): ?>
                        <a href="?user_id=<?= $profile_id; ?>&edit=1" class="btn">Edit Bio</a>
                    <?php endif; ?>
                    <a href="dashboard.php" class="btn">&larr; Back to Dashboard</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<?php
mysqli_close($conn);
?>
