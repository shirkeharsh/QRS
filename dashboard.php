<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

echo "<h2>Welcome to the Dashboard, " . $_SESSION['username'] . "!</h2>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            width: 45%;
            padding: 15px;
            text-align: center;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-scanner {
            background-color: #f44336; /* Red color */
        }

        .btn-user {
            background-color: #4CAF50; /* Green color */
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Mobile responsive design */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            .button-container {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <div class="button-container">
        <a href="scanner.php">
            <button class="btn btn-scanner">Scan QR Code</button>
        </a>

        <a href="users_dashboard.php">
            <button class="btn btn-user">Students</button>
        </a>
        <a href="user.php">
            <button class="btn btn-user">User's Details</button>
        </a>
    </div>
</div>

</body>
</html>
