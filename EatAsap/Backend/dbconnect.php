<?php
// connect to database
$db = mysqli_connect("localhost", "root", "", "eatasap");

if (!$db) {
    die("Connection error: " . mysqli_connect_errno());
}
?>