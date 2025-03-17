<?php
header("Content-Type: application/json");

// Enable error reporting (for debugging only, remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$mysqli = new mysqli("13.200.73.247", "jerry", "admin", "qr");

// Check for connection error
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

// Check if user_id is received
if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
    echo json_encode(["success" => false, "error" => "Missing user_id"]);
    exit;
}

$user_id = $_POST['user_id'];

// Check if user exists and get details
$query = $mysqli->prepare("SELECT full_name, school_selected, year_selected, attendance FROM students WHERE user_id = ?");
$query->bind_param("s", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if ($row['attendance'] == 1) {
        echo json_encode(["success" => false, "error" => "User already marked as attended"]);
    } else {
        // Update attendance column to 1
        $stmt = $mysqli->prepare("UPDATE students SET attendance = 1 WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true, 
                "user_id" => $user_id,
                "full_name" => $row['full_name'],
                "school_selected" => $row['school_selected'],
                "year_selected" => $row['year_selected']
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to update attendance"]);
        }
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid user ID"]);
}

$mysqli->close();
?>
