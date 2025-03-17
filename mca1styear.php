<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "aaro_qr"; 
$password = "jerry"; 
$database = "aaro_qr";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle attendance reset action
if (isset($_GET['reset_attendance'])) {
    $reset_id = $_GET['reset_attendance'];
    $reset_sql = "UPDATE students SET attendance = 0 WHERE id = ? AND attendance = 1";
    $stmt = $conn->prepare($reset_sql);
    $stmt->bind_param("i", $reset_id);
    if ($stmt->execute()) {
        echo "<script>alert('Attendance reset to 0'); window.location.href='mca1styear.php';</script>";
    } else {
        echo "<script>alert('Error resetting attendance');</script>";
    }
}

// Query to fetch students in School of Management 1st Year
$sql = "SELECT * FROM students WHERE school_selected = 'School of MCA' AND year_selected = '1st year'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School of MBA 1st Year Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            margin-bottom: 20px;
            color: #2c3e50;
        }

        /* Search Bar */
        .search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        .search-bar:focus {
            outline: none;
            border-color: #007bff;
            background-color: #fff;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .delete-btn, .reset-btn {
            background-color: transparent;
            color: white;
            border: none;
            cursor: pointer;
            padding: 6px 12px;
            font-size: 16px;
        }

        .delete-btn {
            color: #e74c3c;
        }

        .reset-btn {
            color: #f39c12;
        }

        .delete-btn:hover, .reset-btn:hover {
            opacity: 0.8;
        }

        /* Mobile responsive */
        @media (max-width: 600px) {
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>School of MCA 1st Year Students</h2>

    <!-- Search Bar -->
    <input type="text" id="searchInput" class="search-bar" placeholder="Search by name or phone..." onkeyup="searchTable()" />

    <!-- Table to display the students -->
    <table id="studentsTable">
        <thead>
            <tr>
                <th>Created At</th>
                <th>User ID</th>
                <th>Phone</th>
                <th>School Selected</th>
                <th>Year Selected</th>
                <th>Attendance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through each row in the result set and display the data in table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                        <td>" . htmlspecialchars($row['user_id']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['school_selected']) . "</td>
                        <td>" . htmlspecialchars($row['year_selected']) . "</td>
                        <td>" . htmlspecialchars($row['attendance']) . "</td>
                        <td>
                            <a href='?delete=" . $row['id'] . "'>
                                <button class='delete-btn'><i class='fas fa-trash'></i></button>
                            </a>
                            <a href='?reset_attendance=" . $row['id'] . "'>
                                <button class='reset-btn'><i class='fas fa-sync-alt'></i></button>
                            </a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
// Function to search the table
function searchTable() {
    let input = document.getElementById("searchInput").value.toUpperCase();
    let table = document.getElementById("studentsTable");
    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let found = false;

        // Loop through each cell in the row and check if it contains the search input
        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                let cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toUpperCase().indexOf(input) > -1) {
                    found = true;
                }
            }
        }

        // If a match is found, display the row, else hide it
        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>

<?php
// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Student deleted successfully'); window.location.href='mca1styear.php';</script>";
    } else {
        echo "<script>alert('Error deleting student');</script>";
    }
}

$conn->close();
?>
