<?php

include_once '../../session.php';
include_once '../../DB/config.php';

// Receive JSON data from the request body
$jsonData = file_get_contents('php://input');

// Convert JSON data to associative array
$data = json_decode($jsonData, true);
$category_id = 1; //testing purpose
$item_status = 1; //testing purpose
$restaurant_id = 1 ;// $_SESSION['userID']; //testing purpose
// Insert data into the database
$sql = "INSERT INTO  menu_items (restaurant_id, category_id, item_name, price, item_status) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($link, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt,"iisii", $restaurant_id, $category_id,$data['title'],$data['price'],$item_status);
    $success = mysqli_stmt_execute($stmt) or die(" Query failed.".mysqli_error($link));
    if ($success) {
        //return key of the last element
        $menu_item_id = mysqli_insert_id($link);

        echo json_encode(array($menu_item_id));
    } else {
        echo json_encode(array("message" => "Update query failed."));
    }
} 
else {
    echo json_encode(array("message" => "Failed to prepare statement."));
}


?>  