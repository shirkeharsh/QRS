<?php
require 'vendor/autoload.php'; // Load QR Code Library

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

// ✅ Set PHP timezone to India (IST)
date_default_timezone_set("Asia/Kolkata");

// Database Connection
$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("<div class='error'>❌ Connection failed: " . $conn->connect_error . "</div>");
}

// Prevent resubmission by using PRG (Post/Redirect/Get)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["submitted"])) {
    session_start(); // Start session

    $full_name = $_POST['full_name'] ?? '';
    $school_selected = $_POST['school'] ?? '';
    $year_selected = $_POST['year'] ?? '';
    $phone = $_POST['phone'] ?? '';

    // Validate all required fields
    if (empty($full_name) || empty($school_selected) || empty($year_selected) || empty($phone)) {
        die("<div class='error'>❌ Error: All fields are required.</div>");
    }

    // Validate phone number (only 10-digit numbers allowed)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        die("<div class='error'>❌ Invalid phone number. Please enter a 10-digit number.</div>");
    }

    // Generate Unique User ID
    $first_name = strtoupper(explode(" ", $full_name)[0]); 
    $school_code = strtoupper(substr($school_selected, -3)); 
    $last_four_digits = substr($phone, -4); 

    $user_id = $first_name . $school_code . $last_four_digits;
    $current_time = date("Y-m-d H:i:s"); // ✅ Get IST time

    // Insert Data into Database with IST timestamp
    $sql = "INSERT INTO students (user_id, full_name, school_selected, year_selected, phone, created_at) 
            VALUES ('$user_id', '$full_name', '$school_selected', '$year_selected', '$phone', '$current_time')";

    if ($conn->query($sql) === TRUE) {
        // Prevent form resubmission
        $_SESSION["submitted"] = true;

        // Create "qrcodes" folder if not exists
        if (!file_exists("qrcodes")) {
            mkdir("qrcodes", 0777, true);
        }

        // Generate QR Code
        $qrPath = "qrcodes/$user_id.png"; 

        $qrCode = QrCode::create($user_id)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->setSize(300)
            ->setMargin(10);

        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode);

        // Save QR Code
        file_put_contents($qrPath, $qrImage->getString());

        // Redirect to prevent form resubmission
        header("Location: success.php?user_id=$user_id");
        exit();
    } else {
        echo "<div class='error'>❌ Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();
?>

<script>
    // Adjust height dynamically to remove black bars
    function adjustHeight() {
        document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
    }

    // Run on load and resize
    window.addEventListener('load', adjustHeight);
    window.addEventListener('resize', adjustHeight);
</script>

<style>
    /* Use dynamic height to prevent black spaces */
    html, body {
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: white;
        margin: 0;
        padding: 0;
        width: 100%;
        height: calc(var(--vh, 1vh) * 100); /* Dynamically set height */
        overflow: hidden; /* No scrolling */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Wrapper ensures full height always */
    .wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: calc(var(--vh, 1vh) * 100); /* Ensures proper height */
    }

    /* The QR container */
    .container {
        background-color: #1e1e1e;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        text-align: center;
        width: 90%;
        max-width: 400px;
    }

    .qr-code {
        width: 100%;
        max-width: 250px;
        margin-top: 10px;
        border-radius: 5px;
    }

    .btn {
        background-color: #ff6f61;
        color: white;
        border: none;
        padding: 12px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        margin: 10px 0;
        width: 100%;
        max-width: 250px;
        transition: 0.3s;
    }

    .btn:hover {
        background-color: #ff3b2e;
    }

    .btn.admin {
        background-color: #4CAF50;
    }

    .btn.admin:hover {
        background-color: #388E3C;
    }

    /* Mobile Optimization */
    @media (max-width: 500px) {
        .container {
            width: 95%;
            padding: 15px;
        }
        .btn {
            font-size: 14px;
            padding: 10px;
        }
        .qr-code {
            max-width: 200px;
        }
    }
</style>
