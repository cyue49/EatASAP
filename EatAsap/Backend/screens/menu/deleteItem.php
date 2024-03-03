<?php

include_once '../../session.php';
include_once '../../DB/config.php';

// Receive JSON data from the request body
$jsonData = file_get_contents('php://input');

// Convert JSON data to associative array
$data = json_decode($jsonData, true);
$item_id = $data['item_id'];

// delet data into the database
$sql = "DELETE FROM menu_items WHERE menu_item_id = ?";

$stmt = mysqli_prepare($link, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt,"i", $item_id);
    $success = mysqli_stmt_execute($stmt) or die(" Query failed.".mysqli_error($link));
    if ($success) {

        echo json_encode(array("message" => "Delete query success."));
    } else {
        echo json_encode(array("message" => "Delete query failed."));
    }
} 
else {
    echo json_encode(array("message" => "Failed to prepare statement."));
}


?>  