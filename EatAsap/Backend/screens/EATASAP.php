<?php
// production connection
$servername = "localhost";
$username = "id21930259_root";
$password = "Eatasap1@";
$dbname = "id21930259_eatasap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
