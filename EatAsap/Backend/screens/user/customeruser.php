<?php
// for testing
$_SESSION["loggedin"] = true;
$_SESSION["userID"] = 5;

// if not logged in, redirect
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    // redirect to sign in page
    header("Location: ../../../Frontend/signin.html");
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
    $param_userID = $_SESSION["userID"];

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

// print an order history order items
function printAnOrderHistoryItems($orderID)
{
    // get order history data
    $orderInfo = getOrderInfo($orderID);
    $orderCartID = $orderInfo['cartID'];

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
        '<td>' . "temp" . '$</td>' .
        '</tr>';
    echo '<tr class="tax">' .
        '<td>GST</td>' .
        '<td></td>' .
        '<td>' . "temp" . '$</td>' .
        '</tr>';
    echo '<tr class="tax">' .
        '<td>QST</td>' .
        '<td></td>' .
        '<td>' . "temp" . '$</td>' .
        '</tr>';
    echo '<tr class="total">' .
        '<td>Total</td>' .
        '<td></td>' .
        '<td>' . "temp" . '$</td>' .
        '</tr>';

    echo "</table>";
}

// ============================ Set user information for display on frontend ============================
$userInfo = getUserInfo($_SESSION["userID"]);
$firstName = $userInfo['firstName'];
$lastName = $userInfo['lastName'];
$phoneNumber = $userInfo['phone'];
$emailAddress = $userInfo['email'];
$paymentMethod = $userInfo['paymentMethod'];
$cardNumber = $userInfo['cardNumber'];
$cvv = $userInfo['cvv'];
$expirationDate = $userInfo['expirationDate'];

// =============================== Profile info form validation ===============================
// user input errors
$firstNameErr = $lastNameErr = $phoneNumberErr = $emailAddressErr = "";

if (isset($_POST["editProfileInfoDone"])) {}

// =============================== Payment info form validation ===============================
// user input errors
$paymentMethodErr = $cardNumberErr = $cvvErr = $expirationDateErr = "";

if (isset($_POST["editPaymentInfoDone"])) {}