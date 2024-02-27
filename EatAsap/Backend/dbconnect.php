<?php
// connect to database
$db = mysqli_connect("localhost", "root", "", "id21924858_eatasap");

if (!$db) {
    die("Connection error: " . mysqli_connect_errno());
}
?>