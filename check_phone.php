<?php
$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];

    // Check if phone number already exists
    $stmt = $conn->prepare("SELECT user_id FROM students WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "exists", "message" => "❌ This phone number is already registered!"]);
    } else {
        echo json_encode(["status" => "ok", "message" => "✅ Phone number is available."]);
    }

    $stmt->close();
}

$conn->close();
?>
