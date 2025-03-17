<?php
$user_id = $_GET['user_id'] ?? 'Unknown';
$qrPath = "qrcodes/$user_id.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 400px;
        }
        .qr-code {
            width: 100%;
            max-width: 250px;
        }
        .btn {
            background-color: #ff6f61;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            max-width: 250px;
            margin: 10px 0;
        }
        .btn.admin {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>✅ Registration Successful!</h2>
        <p><b>User ID:</b> <?= htmlspecialchars($user_id) ?></p>
        <img src="<?= htmlspecialchars($qrPath) ?>" alt="QR Code" class="qr-code">
        <br>
        <a href="<?= htmlspecialchars($qrPath) ?>" download="QR_<?= htmlspecialchars($user_id) ?>.png"><button class="btn">Download QR Code</button></a>
        <a href="tel:+919850477210"><button class="btn admin">Contact Admin</button></a>
    </div>
</body>
</html>
