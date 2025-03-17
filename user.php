<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";         // your DB name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch student data based on the school and year selected
$sql = "SELECT * FROM students ORDER BY school_selected, year_selected, created_at";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .student-table th, .student-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .student-table th {
            background-color: #f2f2f2;
        }

        .student-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .student-table tr:hover {
            background-color: #ddd;
        }

        /* Mobile responsive */
        @media (max-width: 600px) {
            .student-table th, .student-table td {
                padding: 8px;
            }

            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Data</h2>

    <table class="student-table">
        <thead>
            <tr>
                <th>Created At</th>
                <th>User ID</th>
                <th>Phone</th>
                <th>School Selected</th>
                <th>Year Selected</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display the student data
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                        <td>" . htmlspecialchars($row['user_id']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['school_selected']) . "</td>
                        <td>" . htmlspecialchars($row['year_selected']) . "</td>
                        <td>" . htmlspecialchars($row['attendance']) . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
