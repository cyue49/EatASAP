<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'eatasap');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect DB. " .": ".mysqli_connect_error());
}

/// production connection
// $servername = "localhost";
// $username = "id21930259_root";
// $password = "Eatasap1@";
// $dbname = "id21930259_eatasap";

// /* Attempt to connect to MySQL database */
// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// // Check connection
// if($link === false){
//     die("ERROR: Could not connect DB. " .": ".mysqli_connect_error());
// }

?>