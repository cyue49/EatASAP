<?php
session_start();

// for testing
$_SESSION["loggedin"] = false;
$_SESSION["cartID"] = 3;
$_SESSION["userID"] = 1;

// ============================ Get cart items ============================
function getCartItems($cartID)
{
    // connect to database
    include("dbconnect.php");

    // response array
    $response = array();

    // prepare insert statement and bind variables
    $sql = "SELECT C.cart_id, M.item_name, M.price, I.quantity  
            FROM order_cart C JOIN cart_item I ON C.cart_id = I.cart_id JOIN menu_items M ON I.menu_item_id = M.menu_item_id
            WHERE C.cart_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_cartID);
    }

    // set parameters
    $param_cartID = $cartID;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $orderCartID, $itemName, $itemPrice, $quantity);
            $x = 0;
            while (mysqli_stmt_fetch($stmt)) {
                $response[$x]['cartID'] = $orderCartID;
                $response[$x]['itemName'] = $itemName;
                $response[$x]['itemPrice'] = $itemPrice;
                $response[$x]['quantity'] = $quantity;
                $x++;
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

// ============================ Update / Calculate taxes and totals ============================
function updateSubtotal($cartItems)
{
    // recalculate subtotal
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += $item['itemPrice'];
    }
    $subtotal = number_format((float)$subtotal, 2, '.', '');

    // connect to database
    include("dbconnect.php");

    // prepare update statement and bind variables
    $sql = "UPDATE order_cart 
            SET cart_subtotal = ?
            WHERE cart_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_newSubtotal, $param_cartID);
    }

    // set parameters
    $param_newSubtotal = $subtotal;
    $param_cartID = $cartItems[0]["cartID"];

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // disconnect from database
        mysqli_close($db);
        return $subtotal;
    } else { // error
        die(mysqli_error($db));
    }
}

function getSubtotal($cartID)
{
    // connect to database
    include("dbconnect.php");

    // result 
    $subtotal = 0;

    // prepare insert statement and bind variables
    $sql = "SELECT cart_subtotal 
            FROM order_cart 
            WHERE cart_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_cartID);
    }

    // set parameters
    $param_cartID = $cartID;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $result);
            if (mysqli_stmt_fetch($stmt)) {
                $subtotal = (float) $result;
            }
        }

        // close statement
        mysqli_stmt_close($stmt);

        // disconnect from database
        mysqli_close($db);

        return $subtotal;
    } else { // error
        die(mysqli_error($db));
    }
}

function calculateGST($subtotal)
{
    $realVal = 0.05 * $subtotal;
    $displayVal = number_format((float)$realVal, 2, '.', '');
    return array($realVal, $displayVal);
}

function calculateQST($subtotal)
{
    $realVal = 0.09975 * $subtotal;
    $displayVal = number_format((float)$realVal, 2, '.', '');
    return array($realVal, $displayVal);
}

function calculateTotal($subtotal)
{
    return number_format((float)($subtotal + calculateGST($subtotal)[0] + calculateQST($subtotal)[0]), 2, '.', '');
}

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

// ============================ Get next IDs/numbers for inserting into tables ============================
function getNextOrderID()
{
    // connect to database
    include("dbconnect.php");

    // response
    $response;

    // prepare insert statement and bind variables
    $sql = "SELECT order_id
            FROM orders
            ORDER BY order_id DESC;";

    $stmt = mysqli_prepare($db, $sql);

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $orderID);
            if (mysqli_stmt_fetch($stmt)) {
                $response = $orderID + 1;
            }
        } else {
            $response = 1;
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

function getNextOrderNumber()
{
    // connect to database
    include("dbconnect.php");

    // response
    $response;

    // prepare insert statement and bind variables
    $sql = "SELECT order_number
            FROM orders
            ORDER BY order_number DESC;";

    $stmt = mysqli_prepare($db, $sql);

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $orderNum);
            if (mysqli_stmt_fetch($stmt)) {
                $response = $orderNum + 1;
                if ($response > 1000) { // likely won't have 1000 people ordering together at the same restaurant, so can reuse numbers once reach 1000
                    $response = 1;
                }
            }
        } else {
            $response = 1;
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

function getNextTempUserID()
{
    // connect to database
    include("dbconnect.php");

    // response
    $response;

    // prepare insert statement and bind variables
    $sql = "SELECT temp_user_id
            FROM temporary_order_user
            ORDER BY temp_user_id DESC;";

    $stmt = mysqli_prepare($db, $sql);

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $userID);
            if (mysqli_stmt_fetch($stmt)) {
                $response = $userID + 1;
            }
        } else {
            $response = 1;
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

// ============================ Get cartItems and calculate totals ============================
// get cart items
$cartItems = getCartItems($_SESSION["cartID"]);

// get and update totals and taxes 
$subtotal = updateSubtotal($cartItems);
$gst = calculateGST($subtotal)[1];
$qst = calculateQST($subtotal)[1];
$total = calculateTotal($subtotal);

// ============================ Form validation for checkout ============================
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// user input values
$paymentMethod = $firstName = $lastName = $phoneNumber = $emailAddress = $paymentMethod = $cardNumber = $cvv = $expirationDate = "";

// user input errors
$paymentMethodErr = $firstNameErr = $lastNameErr = $phoneNumberErr = $emailAddressErr = $paymentMethodErr = $cardNumberErr = $cvvErr = $expirationDateErr = "";

// general error message
$generalError = "";

// next order ids / numbers
$_SESSION["orderID"] = getNextOrderID();
$_SESSION["orderNumber"] = getNextOrderNumber();
$_SESSION["tempUserID"] = getNextTempUserID();

// if is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $userInfo = getUserInfo($_SESSION["userID"]);
    $firstName = $userInfo['firstName'];
    $lastName = $userInfo['lastName'];
    $phoneNumber = $userInfo['phone'];
    $emailAddress = $userInfo['email'];
    $paymentMethod = $userInfo['paymentMethod'];
    $cardNumber = $userInfo['cardNumber'];
    $cvv = $userInfo['cvv'];
    $expirationDate = $userInfo['expirationDate'];
}

// payment method form validation // todo: put payment info and payment method together, change order of user info and payment info in accordion
echo "<script> var validCustomerForm = false;</script>";

if (isset($_POST["formSubmit"])) {
    $noError = true;

    // first name
    $firstName = validate_input($_POST["firstName"]);
    if (empty($firstName)) {
        $firstNameErr = "First Name is required.";
        $noError = false;
    } else if (!preg_match("/^[a-zA-Z\-]+$/", $firstName)) {
        $firstNameErr = "Invalid first name format.";
        $noError = false;
    }

    // last name
    $lastName = validate_input($_POST["lastName"]);
    if (empty($lastName)) {
        $lastNameErr = "Last Name is required.";
        $noError = false;
    } else if (!preg_match("/^[a-zA-Z\-]+$/", $lastName)) {
        $lastNameErr = "Invalid last name format.";
        $noError = false;
    }

    // phone number
    $phoneNumber = validate_input($_POST["phoneNumber"]);
    if (empty($phoneNumber)) {
        $phoneNumberErr = "Phone number is required.";
        $noError = false;
    } else if (!preg_match("/^\d{10}$/", $phoneNumber)) {
        $phoneNumberErr = "Invalid phone number format. Please make sure to enter exactly 10 digits.";
        $noError = false;
    }

    // email
    $emailAddress = validate_input($_POST["emailAddress"]);
    if (empty($emailAddress)) {
        $emailAddressErr = "Email address is required.";
        $noError = false;
    } else if (!preg_match("/^[\w\.\-_]+@[a-zA-Z]+.[a-zA-Z]+$/", $emailAddress)) {
        $emailAddressErr = "Invalid Eamil format.";
        $noError = false;
    }

    // payment method
    if (!isset($_POST['paymentMethod'])) {
        $paymentMethodErr = "Payment method is required.";
        $noError = false;
    } else {
        $paymentMethod = validate_input($_POST['paymentMethod']);
    }

    // card number
    $cardNumber = validate_input($_POST["cardNumber"]);
    if (empty($cardNumber)) {
        $cardNumberErr = "Card number is required.";
        $noError = false;
    } else if (!preg_match("/^\d{16}$/", $cardNumber)) {
        $cardNumberErr = "Invalid card number format. Please make sure to enter exactly 16 digits with no spaces in between.";
        $noError = false;
    }

    // cvv
    $cvv = validate_input($_POST["cvv"]);
    if (empty($cvv)) {
        $cvvErr = "CVV/CVC is required.";
        $noError = false;
    } else if (!preg_match("/^\d{3}$/", $cvv)) {
        $cvvErr = "Invalid CVV/CVC format. Please make sure to enter exactly 3 digits.";
        $noError = false;
    }

    // expiration date
    if ($_POST['expirationDate'] == "") {
        $expirationDateErr = "Expiration date is required.";
        $noError = false;
    } else if (strtotime($_POST['expirationDate']) < strtotime('now')) {
        $expirationDateErr = "Your card is already expired.";
        $expirationDate = validate_input($_POST['expirationDate']);
        $noError = false;
    } else {
        $expirationDate = validate_input($_POST['expirationDate']);
    }

    // if no error
    if ($noError) {
        echo "<script>validCustomerForm = true;</script>";

        // customer info to put on receipt
        $_SESSION["orderItems"] = $cartItems;
        $_SESSION["customerFullName"] = $firstName . " " . $lastName;
        $_SESSION["customerEmail"] = $emailAddress;
        $_SESSION["customerPhone"] = $phoneNumber;
        $_SESSION["subtotal"] = $subtotal;
        $_SESSION["gst"] = $gst;
        $_SESSION["qst"] = $qst;
        $_SESSION["total"] = $total;
        $_SESSION["paymentMethod"] = $paymentMethod;
        $_SESSION["cardNum"] = "************" . substr($cardNumber, 12);

        // create order

        // connect to database
        include("dbconnect.php");

        // prepare insert statement and bind variables
        $sql = "INSERT INTO orders (order_id, cart_id, user_id, order_total, order_datetime, order_number, order_status) VALUES (?, ?, ?, ?, ?, ?, ?);";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $param_orderID, $param_cartID, $param_userID, $param_orderTotal, $param_orderDateTime, $param_orderNumber, $param_orderStatus);
        }

        // set parameters
        $param_orderID = $_SESSION["orderID"];
        $param_cartID = $_SESSION["cartID"];
        $param_userID = NULL;
        $param_orderTotal = $total;
        $param_orderDateTime = NULL;
        $param_orderNumber = NULL;
        $param_orderStatus = "incomplete";

        // execute statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
        } else {
            die(mysqli_error($db));
        }

        // if not logged in create temp user for order
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
            // prepare insert statement and bind variables
            $sql = "INSERT INTO temporary_order_user (temp_user_id, order_id, first_name, last_name, phone, email, payment_method, card_number, cvv, expiration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssssss", $param_userID, $param_orderID, $param_firstName, $param_lastName, $param_Phone, $param_email, $param_paymentMethod, $param_cardNumber, $param_cvv, $param_expirationDate);
            }

            // set parameters
            $param_userID = $_SESSION["tempUserID"];
            $param_orderID = $_SESSION["orderID"];
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_Phone = $phoneNumber;
            $param_email = $emailAddress;
            $param_paymentMethod = $paymentMethod;
            $param_cardNumber = $cardNumber;
            $param_cvv = $cvv;
            $param_expirationDate = $expirationDate . "-01";

            // execute statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
            } else {
                die(mysqli_error($db));
            }
        } else {
            // add user id to order table
            // prepare update statement and bind variables
            $sql = "UPDATE orders 
                    SET user_id = ?
                    WHERE order_id = ?;";

            if ($stmt = mysqli_prepare($db, $sql)) {
                mysqli_stmt_bind_param($stmt, "ss", $param_userID, $param_orderID);
            }

            // set parameters
            $param_userID = $_SESSION["userID"];
            $param_orderID = $_SESSION["orderID"];

            // execute statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
            } else {
                die(mysqli_error($db));
            }
        }

        // disconnect from database
        mysqli_close($db);
    } else {
        $generalError = "*Please check that you have filled the form correctly.";
    }
}

// ============================ Order Confirmation ============================
if (isset($_POST["confirmOrder"])) {
    // update order date time, status & number

    // connect to database
    include("dbconnect.php");

    // prepare statement and bind variables
    $sql = "UPDATE orders 
            SET order_datetime = ?, order_number = ?, order_status = 'completed'
            WHERE order_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $param_orderDateTime, $param_orderNumber, $param_orderID);
    }

    // set parameters
    date_default_timezone_set("America/New_York");
    $orderTime = date('Y-m-d') . " " . date('H:i:s');
    $param_orderDateTime = $orderTime;
    $param_orderNumber = $_SESSION["orderNumber"];
    $param_orderID = $_SESSION["orderID"] - 1; // - 1 because page reloaded after form submit, so new order, so -1 to get current order

    // add order time to session variables 
    $_SESSION["orderTime"] = $orderTime;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($db);

        // redirect to sign in page
        header("Location: ordercomplete.php");
        exit();
    } else {
        die(mysqli_error($db));
    }
}
