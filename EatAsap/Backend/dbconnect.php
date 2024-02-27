<?php
/* // connect to database
$db = mysqli_connect("localhost", "root", "", "id21924858_eatasap");

if (!$db) {
    die("Connection error: " . mysqli_connect_errno());
} */

// production connection
$servername = "localhost";
$username = "id21930259_root";
$password = "Eatasap1@";
$dbname = "id21930259_eatasap";
 
// Create connection
$db = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>