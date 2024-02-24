<?php
// for testing
$_SESSION["loggedin"] = true;
$_SESSION["userID"] = 1;

// todo: check if logged in, if not redirect

// todo: create function to get user info and payment info, (return info as array?)

// ============================ Get user and payment information ============================
function getUserInfo($userID)
{
    // connect to database
    include("dbconnect.php");

    // response array
    $response = array();

    // prepare insert statement and bind variables
    $sql = "SELECT U.first_name, U.last_name, U.phone_number, U.email, P.payment_method, P.card_number, P.cvv, P.expiration_date
            FROM user U JOIN payment P ON U.user_id = P.user_id
            WHERE U.user_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_userID);
    }

    // set parameters
    $param_userID = $userID;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $firstName, $lastName, $phone, $email, $paymentMethod, $cardNumber, $cvv, $expirationDate);
            if (mysqli_stmt_fetch($stmt)) {
                $response['firstName'] = $firstName;
                $response['lastName'] = $lastName;
                $response['phone'] = $phone;
                $response['email'] = $email;
                $response['paymentMethod'] = $paymentMethod;
                $response['cardNumber'] = $cardNumber;
                $response['cvv'] = $cvv;
                $response['expirationDate'] = explode('-', $expirationDate)[0] . '-' . explode('-', $expirationDate)[1];
            }
        }

        // close statement
        mysqli_stmt_close($stmt);

        // disconnect from database
        mysqli_close($db);

        return $response;
    } else { // error
        die(mysqli_error($db));
    }
}

$userInfo = getUserInfo($_SESSION["userID"]);
$firstName = $userInfo['firstName'];
$lastName = $userInfo['lastName'];
$phoneNumber = $userInfo['phone'];
$emailAddress = $userInfo['email'];
$paymentMethod = $userInfo['paymentMethod'];
$cardNumber = $userInfo['cardNumber']; 
$cvv = $userInfo['cvv'];
$expirationDate = $userInfo['expirationDate'];
