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

// Check if a QR Code is scanned
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch user details
    $sql = "SELECT full_name, school_selected, year_selected, attendance FROM students WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $full_name = $row['full_name'];
        $school_selected = $row['school_selected'];
        $year_selected = $row['year_selected'];
        $attendance = $row['attendance'];

        echo "<h2>Student Details</h2>";
        echo "<p><b>Name:</b> $full_name</p>";
        echo "<p><b>School:</b> $school_selected</p>";
        echo "<p><b>Year:</b> $year_selected</p>";
        echo "<p><b>Attendance:</b> " . ($attendance ? "✅ Present" : "❌ Absent") . "</p>";

        if ($attendance == 0) {
            echo "<form action='update_attendance.php' method='POST'>
                    <input type='hidden' name='user_id' value='$user_id'>
                    <button type='submit'>Mark Present</button>
                  </form>";
        } else {
            echo "<p>✔️ Already marked present.</p>";
        }
    } else {
        echo "<p>❌ User not found!</p>";
    }
} else {
    echo "<h3>Scan a QR Code to see user details.</h3>";
}

$conn->close();
?>
