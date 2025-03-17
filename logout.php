<?php
session_start();
session_destroy(); // Destroy session to logout
header("Location: login.php"); // Redirect to login page
exit();
