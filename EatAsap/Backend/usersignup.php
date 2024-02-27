<?php
//session_start();

// user input values
$firstName = $lastName = $email = $phoneNum = $address = $usrPassword = $retypePassword = "";

// user input errors
$firstNameErr = $lastNameErr = $emailErr = $phoneNumErr = $addressErr = $usrPasswordErr = $retypePasswordErr = "";

// trim data, remove slashes, etc.
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// get next user id
function getNewestUserID()
{
    // connect to database
    include("dbconnect.php");

    // response
    $response;

    // prepare insert statement and bind variables
    $sql = "SELECT user_id
            FROM user
            ORDER BY user_id DESC;";

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

if (isset($_POST["signupButton"])) {
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

    // user email
    $email = validate_input($_POST["email"]);
    if (empty($email)) {
        $emailErr = "Email address is required.";
        $noError = false;
    } else if (!preg_match("/^[\w\.\-_]+@[a-zA-Z]+\.[a-zA-Z]+$/", $email)) {
        $emailErr = "Invalid Email format.";
        $noError = false;
    }

    // user phone number
    $phoneNum = validate_input($_POST["phoneNum"]);
    if (empty($phoneNum)) {
        $phoneNumErr = "Phone number is required.";
        $noError = false;
    } else if (!preg_match("/^\d{10,13}$/", $phoneNum)) {
        $phoneNumErr = "Invalid phone number format. Please make sure to enter between 10 and 13 digits.";
        $noError = false;
    }

    // user address
    $address = validate_input($_POST["address"]);
    if (!empty($address)) {
        if (!preg_match("/^[a-zA-Z0-9\- ]+$/", $address)) {
            $addressErr = "Invalid address format.";
            $noError = false;
        }
    }

    // password
    $usrPassword = validate_input($_POST["usrPassword"]);
    if (empty($usrPassword)) {
        $usrPasswordErr = "Password is required.<br>";
        $noError = false;
    }
    if (strlen($usrPassword) < 8) { // less than 8 characters
        $usrPasswordErr .= "Your password must be at least 8 characters long.<br>";
        $noError = false;
    }
    if (!preg_match("/\d/", $usrPassword)) { // doesn't contain one digit
        $usrPasswordErr .= "Your password must contain a digit.<br>";
        $noError = false;
    }
    if (!preg_match("/\W/", $usrPassword)) { // doesn't contain one special character
        $usrPasswordErr .= "Your password must contain a special character.<br>";
        $noError = false;
    }
    if (!preg_match("/[A-Z]/", $usrPassword)) { // doesn't contain one uppercase letter
        $usrPasswordErr .= "Your password must contain an uppercase letter.<br>";
        $noError = false;
    }

    // retype password
    $retypePassword = validate_input($_POST["retypePassword"]);
    if (empty($retypePassword)) {
        $retypePasswordErr = "Retype Password is required.";
        $noError = false;
    } else if ($retypePassword != $usrPassword) {
        $retypePasswordErr = "Your retyped password doesn't match your password.";
    }

    if ($noError) {
        // add user info to database

        // connect to database
        include("dbconnect.php");

        // prepare insert statement and bind variables
        $sql = "INSERT INTO user (user_id, first_name, last_name, email, user_password, phone_number, user_address, user_role) VALUES (?, ?, ?, ?, ?, ?, ?, 'customer');";

        if ($stmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $param_userID, $param_firstName, $param_lastName, $param_email, $param_password, $param_phoneNum, $param_addr);
        }

        // set parameters
        $param_userID = getNewestUserID();
        $param_firstName = $firstName;
        $param_lastName = $lastName;
        $param_email = $email;

        $options = [
            'cost' => 12,
        ];
        $param_password = password_hash($usrPassword, PASSWORD_BCRYPT, $options);

        $param_phoneNum = $phoneNum;
        $param_addr = $address;

        // execute statement
        if (mysqli_stmt_execute($stmt)) {
            // close statement
            mysqli_stmt_close($stmt);

            // disconnect from database
            mysqli_close($db);

            // redirect to sign in page
            header("Location: signin.php");
            exit();
        } else {
            die(mysqli_error($db));
        }
    }
}
?>