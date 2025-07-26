<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$actual_flag = "BOOTCAMP{D4y_1_C0b4_CtF}";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations! Flag Unlocked!</title>
    <link rel="stylesheet" href="../public/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto Mono', monospace;
        }
        .flag-container {
            background-color: #2c2c38;
            border: 2px solid #0f4c75;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            width: 90%;
        }
        .flag-container h1 {
            color: #00ff00;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.7);
        }
        .flag-container p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .flag-display {
            background-color: #1f1f2e;
            border: 1px dashed #00ff00;
            padding: 20px;
            border-radius: 5px;
            font-size: 1.5em;
            font-weight: bold;
            color: #00ff00;
            word-break: break-all;
        }
        .back-button {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #0f4c75;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #3282b8;
        }
    </style>
</head>
<body>
    <div class="flag-container">
        <h1>🎉🎉Selamat🎉🎉 </h1>
        <h1>Anda Berhasil Mendapatkan flagnya ! 😹😹</h1>
        <p>Ini dia Flag-nya 😈😈</p>
        <div class="flag-display">
            <?php echo htmlspecialchars($actual_flag); ?>
        </div>
        <a href="dashboard.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>