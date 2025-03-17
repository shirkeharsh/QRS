<?php
session_start();

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

if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to check if user exists
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);  // Binding parameters (username, password)
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any user found
    if ($result->num_rows > 0) {
        // Store session data
        $_SESSION['username'] = $user;
        header("Location: dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>

    <input type="submit" name="submit" value="Login">
</form>

<?php
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>

</body>
</html>
