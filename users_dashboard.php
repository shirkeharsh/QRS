<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the total students count for each category
function getTotalStudents($school, $year) {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM students WHERE school_selected = ? AND year_selected = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $school, $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #3a3a3a, #121212);
            color: #fff;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 50px auto;
            padding: 30px;
            background: #232323;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
            font-weight: 700;
            color: #ffcc00;
            text-transform: uppercase;
        }

        .cards-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            width: 48%;
            background: linear-gradient(145deg, #00c6ff, #0072ff);
            color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .card:hover {
            background: linear-gradient(145deg, #0072ff, #00c6ff);
            transform: scale(1.05);
        }

        .card h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
        }

        .card p {
            font-size: 20px;
            margin-bottom: 20px;
            color: #ffcc00;
        }

        .card a {
            text-decoration: none;
            color: inherit;
        }

        /* Mobile responsive */
        @media (max-width: 600px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>MCA vs MBA</h2>

    <div class="cards-container">
        <!-- School of MCA 1st Year -->
        <a href="mca1styear.php">
            <div class="card">
                <h3>MCA 1st Year</h3>
                <p>Total Students: <?php echo getTotalStudents('School of MCA', '1st year'); ?></p>
            </div>
        </a>

        <!-- School of MCA 2nd Year -->
        <a href="mca2ndyear.php">
            <div class="card">
                <h3>MCA 2nd Year</h3>
                <p>Total Students: <?php echo getTotalStudents('School of MCA', '2nd year'); ?></p>
            </div>
        </a>

        <!-- School of Management 1st Year -->
        <a href="mba1styear.php">
            <div class="card">
                <h3>MBA 1st Year</h3>
                <p>Total Students: <?php echo getTotalStudents('School of Management', '1st year'); ?></p>
            </div>
        </a>

        <!-- School of Management 2nd Year -->
        <a href="mba2ndyear.php">
            <div class="card">
                <h3>MBA 2nd Year</h3>
                <p>Total Students: <?php echo getTotalStudents('School of Management', '2nd year'); ?></p>
            </div>
        </a>
    </div>
</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
