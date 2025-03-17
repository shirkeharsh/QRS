<?php
$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Update attendance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $sql = "UPDATE students SET attendance = 1 WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Attendance marked successfully!";
    } else {
        echo "❌ Error updating attendance: " . $conn->error;
    }
} else {
    echo "❌ Invalid request!";
}

$conn->close();
?>
