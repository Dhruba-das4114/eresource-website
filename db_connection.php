<?php
$host = "localhost";  // Use IP instead of "localhost"
$username = "root";    // Default XAMPP MySQL user
$password = "";        // Default password is empty
$database = "subject_management"; // Your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
