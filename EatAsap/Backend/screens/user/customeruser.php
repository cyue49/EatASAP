<?php

// for testing
/* $_SESSION["logged_in"] = true;
$_SESSION["user_id"] = 5; */

// if not logged in, redirect
if (!isUserLoggedIn()) {
    // redirect to sign in page
    header("Location: ../../../Frontend/signin.php");
    exit();
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
                $_SESSION['user_name'] = $firstName . " " . $lastName;
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

// ============================ Get order information ============================
// get all completed order ids for an user given the user id
function getOrderIds()
{
    // connect to database
    include("dbconnect.php");

    // response array
    $response = array();

    // prepare insert statement and bind variables
    $sql = "SELECT order_id
            FROM orders
            WHERE order_status = 'completed' AND user_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_userID);
    }

    // set parameters
    $param_userID = $_SESSION["user_id"];

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $orderID);
            $x = 0;
            while (mysqli_stmt_fetch($stmt)) {
                $response[$x] = $orderID;
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

// cart id, order date/time, and total given an order id
function getOrderInfo($orderID)
{
    // connect to database
    include("dbconnect.php");

    // response array
    $response = array();

    // prepare insert statement and bind variables
    $sql = "SELECT O.order_id, C.cart_id, O.order_datetime, O.order_total
            FROM orders O JOIN order_cart C ON O.cart_id = C.cart_id
            WHERE O.order_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_orderID);
    }

    // set parameters
    $param_orderID = $orderID;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $orderID, $cartID, $orderDateTime, $orderTotal);
            if (mysqli_stmt_fetch($stmt)) {
                $response['orderDateTime'] = $orderDateTime;
                $response['orderTotal'] = $orderTotal;
                $response['orderID'] = $orderID;
                $response['cartID'] = $cartID;
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

// get restaurant name given order id
function getRestaurantName($orderID)
{
    // connect to database
    include("dbconnect.php");

    // response
    $response = "";

    // prepare insert statement and bind variables
    $sql = "SELECT R.restaurant_name
            FROM orders O JOIN order_cart C ON O.cart_id = C.cart_id JOIN cart_item I ON C.cart_id = I.cart_id JOIN menu_items M ON I.menu_item_id = M.menu_item_id JOIN restaurant R ON M.restaurant_id = R.restaurant_id
            WHERE O.order_id = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_orderID);
    }

    // set parameters
    $param_orderID = $orderID;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $restaurantName);
            if (mysqli_stmt_fetch($stmt)) {
                $response = $restaurantName;
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

// get cart items given a cart id
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

// print an order history header
function printAnOrderHistoryHeader($orderID)
{
    // get order history data
    $orderInfo = getOrderInfo($orderID);
    $orderDateTime = $orderInfo['orderDateTime'];
    $orderTotal = $orderInfo['orderTotal'];

    $restaurantName = getRestaurantName($orderID);

    // print to frontend with data
    echo "<div class='orderHistorySectionInfo'> 
                <h3>" . $restaurantName . "</h3>
                <p>" . $orderDateTime . "</p>
                <h3>" . $orderTotal . "$</h3>
            </div>";
}

// ============================ Calculate taxes and totals ============================
// get subtotal
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

// print an order history order items
function printAnOrderHistoryItems($orderID)
{
    // get order history data
    $orderInfo = getOrderInfo($orderID);
    $orderCartID = $orderInfo['cartID'];
    $subtotal = getSubtotal($orderInfo['cartID']);
    $total = $orderInfo['orderTotal'];

    $orderItems = getCartItems($orderCartID);

    // print to frontend with data
    echo "<table>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price Per Unit</th>
            </tr>";

    foreach ($orderItems as $item) {
        echo "
            <tr>
                <td>" . $item["itemName"] . "</td>
                <td>" . $item["quantity"] . "</td>
                <td>" . $item["itemPrice"] . "$</td>" .
            "</tr>";
    }
    echo '<tr class="subtotal">' .
        '<td>Subtotal</td>' .
        '<td></td>' .
        '<td>' . $subtotal . '$</td>' .
        '</tr>';
    echo '<tr class="tax">' .
        '<td>GST</td>' .
        '<td></td>' .
        '<td>' . calculateGST($subtotal)[1] . '$</td>' .
        '</tr>';
    echo '<tr class="tax">' .
        '<td>QST</td>' .
        '<td></td>' .
        '<td>' . calculateQST($subtotal)[1] . '$</td>' .
        '</tr>';
    echo '<tr class="total">' .
        '<td>Total</td>' .
        '<td></td>' .
        '<td>' . $total . '$</td>' .
        '</tr>';

    echo "</table>";
}

// ============================ Set user information for display on frontend ============================
$userInfo = getUserInfo($_SESSION["user_id"]);
$firstName = $userInfo['firstName'];
$lastName = $userInfo['lastName'];
$phoneNumber = $userInfo['phone'];
$emailAddress = $userInfo['email'];
$paymentMethod = $userInfo['paymentMethod'];
$cardNumber = $userInfo['cardNumber'];
$cvv = $userInfo['cvv'];
$expirationDate = $userInfo['expirationDate'];

// =============================== Profile info form validation ===============================
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// user input errors
$firstNameErr = $lastNameErr = $phoneNumberErr = $emailAddressErr = "";

if (isset($_POST["editProfileInfoDone"])) {
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
    } else if (!preg_match("/^[\w\.\-_]+@[a-zA-Z]+\.[a-zA-Z]+$/", $emailAddress)) {
        $emailAddressErr = "Invalid Eamil format.";
        $noError = false;
    }

    if ($noError) {
        // connect to database
        include("dbconnect.php");

        // prepare update statement and bind variables
        $sql = "UPDATE user 
            SET first_name = ?, last_name = ?, phone_number = ?, email = ?
            WHERE user_id = ?;";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_firstName, $param_lastName, $param_phone, $param_email, $param_userID);
        }

        // set parameters
        $param_firstName = $firstName;
        $param_lastName = $lastName;
        $param_phone = $phoneNumber;
        $param_email = $emailAddress;
        $param_userID = $_SESSION["user_id"];

        // execute statement
        if (mysqli_stmt_execute($stmt)) {
            // close statement
            mysqli_stmt_close($stmt);
            // disconnect from database
            mysqli_close($db);
        } else { // error
            die(mysqli_error($db));
        }

        // redirect to profile page
        header("Location: userprofile.php");
        exit();
    }
}

// =============================== Payment info form validation ===============================
// user input errors
$paymentMethodErr = $cardNumberErr = $cvvErr = $expirationDateErr = "";

if (isset($_POST["editPaymentInfoDone"])) {
    $noError = true;

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

    if ($noError) {
        echo '<script>alert("Here")</script>';
        // connect to database
        include("dbconnect.php");

        // prepare update statement and bind variables
        $sql = "UPDATE payment 
            SET payment_method = ?, card_number = ?, cvv = ?, expiration_date = ?
            WHERE user_id = ?;";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_paymentMethod, $param_cardNumber, $param_cvv, $param_expirationDate, $param_userID);
        }

        // set parameters
        $param_paymentMethod = $paymentMethod;
        $param_cardNumber = $cardNumber;
        $param_cvv = $cvv;
        $param_expirationDate = $expirationDate . "-01";
        $param_userID = $_SESSION["user_id"];

        // execute statement
        if (mysqli_stmt_execute($stmt)) {
            // close statement
            mysqli_stmt_close($stmt);
            // disconnect from database
            mysqli_close($db);
        } else { // error
            die(mysqli_error($db));
        }

        // redirect to profile page
        header("Location: userprofile.php");
        exit();
    }
}
