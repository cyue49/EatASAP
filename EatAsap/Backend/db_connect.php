<?php
$servername = "localhost";
$username = ""; // Update with your database username
$password = ""; // Update with your database password
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
