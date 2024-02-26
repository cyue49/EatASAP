<?php
// EATASAP.php
$servername = "localhost";
$username = "id21924858_root";
$password = "Eatasap1@";
$dbname = "id21924858_eatasap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
