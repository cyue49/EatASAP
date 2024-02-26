<?php
include_once("../../session.php");
require_once "../../DB/config.php";

$user_id = $_SESSION["userID"] = 1;

// Prepare a SQL query to retrieve the restaurant name based on user_id
$sql = "SELECT restaurant_name, logo_url FROM restaurant WHERE user_id = ?";

$stmt = mysqli_prepare($link, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    $success = mysqli_stmt_execute($stmt) or die("Update query failed." . mysqli_error($link));

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result); // Get the number of rows

        if ($rowCount > 0) {
            $row = mysqli_fetch_assoc($result);
            $response['restaurant_name'] = $row['restaurant_name'];
            $response['logo_url'] = $row['logo_url'];


            //echo json_encode (array("message" => "All correct before prinitng.", "status" =>true));
            echo json_encode($response, JSON_PRETTY_PRINT);

        } else {
            echo json_encode(array("message" => "No records Found."));
        }
    } else {
        echo json_encode(array("message" => "Update query failed."));
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(array("message" => "Failed to prepare statement."));
}

?>