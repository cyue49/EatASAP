<?php
include_once("../../session.php");
require_once "../../DB/config.php";

$user_id = $_SESSION["userID"] = 1; // 1 is for testing purpose

// Prepare a SQL query to retrieve the restaurant information
$sql = "SELECT 
u.first_name,
u.last_name,
u.email,
u.phone_number,
u.user_password,
p.payment_method,
p.card_number,
p.expiration_date,
r.restaurant_name,
r.logo_url,
r.business_type_id,
r.brand_name,
r.address,
r.phone_number AS restaurant_phone_number,
r.website,
r.email AS restaurant_email
FROM 
user u
LEFT JOIN 
restaurant r ON u.user_id = r.user_id
LEFT JOIN 
restaurant_plans rp ON r.restaurant_id = rp.restaurant_id
LEFT JOIN 
payment p ON rp.payment_id = p.payment_id
WHERE 
u.user_id = ?
AND rp.plan_status = 1;
";

$stmt = mysqli_prepare($link, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    $success = mysqli_stmt_execute($stmt) or die("Update query failed." . mysqli_error($link));

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result); // Get the number of rows

        if ($rowCount > 0) {
            $row = mysqli_fetch_assoc($result);
            $response['first_name'] = $row['first_name'];
            $response['last_name'] = $row['last_name'];
            $response['email'] = $row['email']; //for user
            $response['phone_number'] = $row['phone_number']; //for user
            $response['user_password'] = $row['user_password']; //for user
            $response['payment_method'] = $row['payment_method'];
            $response['card_number'] = $row['card_number'];
            $response['expiration_date'] = $row['expiration_date'];//for card
            $response['brand_name'] = $row['brand_name'];
            $response['address'] = $row['address']; // restaurant address
            $response['restaurant_phone_number'] = $row['restaurant_phone_number'];
            $response['restaurant_name'] = $row['restaurant_name'];
            $response['website'] = $row['website'];
            $response['restaurant_email'] = $row['restaurant_email'];
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


// // Prepare a SQL query to retrieve the restaurant information
// $sql = "SELECT restaurant_name, logo_url FROM restaurant WHERE user_id = ?";

// $stmt = mysqli_prepare($link, $sql);
// if ($stmt) {
//     mysqli_stmt_bind_param($stmt, "i", $user_id);
//     $success = mysqli_stmt_execute($stmt) or die("Update query failed." . mysqli_error($link));

//     if ($success) {
//         $result = mysqli_stmt_get_result($stmt);
//         $rowCount = mysqli_num_rows($result); // Get the number of rows

//         if ($rowCount > 0) {
//             $row = mysqli_fetch_assoc($result);
//             $response['restaurant_name'] = $row['restaurant_name'];
//             $response['logo_url'] = $row['logo_url'];


//             //echo json_encode (array("message" => "All correct before prinitng.", "status" =>true));
//             echo json_encode($response, JSON_PRETTY_PRINT);

//         } else {
//             echo json_encode(array("message" => "No records Found."));
//         }
//     } else {
//         echo json_encode(array("message" => "Update query failed."));
//     }
//     mysqli_stmt_close($stmt);
// } else {
//     echo json_encode(array("message" => "Failed to prepare statement."));
// }

?>