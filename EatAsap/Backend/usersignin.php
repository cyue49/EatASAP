<?php
session_start();

// user input values
$email = $pswd = $role = "";

// user input errors 
$emailErr = $pswdErr = $roleErr = $loginErr = "";

// trim data, remove slashes, etc.
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// verify password, set user id session variable upon success
function checkPassword($email, $password, $role)
{
    // connect to database
    include("dbconnect.php");

    // valid user
    $validUser = false;

    // prepare statement and bind variables
    $sql = "SELECT user_password, user_role, user_id
            FROM user
            WHERE email = ?;";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
    }

    // set parameters
    $param_email = $email;

    // execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // if has result in database
        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $hashed_password, $roleDB, $userID);
            if (mysqli_stmt_fetch($stmt)) {
                // role match and correct password
                /* if ($role == $roleDB && password_verify($password, $hashed_password)) {
                    $_SESSION["userID"] = $userID;
                } */

                if ($role == $roleDB && $password == $hashed_password) {
                    $_SESSION["userID"] = $userID;
                    $validUser = true;
                }
            }
        }

        // close statement
        mysqli_stmt_close($stmt);

        // disconnect from database
        mysqli_close($db);

        return $validUser;
    } else { // error
        die(mysqli_error($db));
    }
}

if (isset($_POST["signinButton"])) {
    $noError = true;

    // role
    if ($_POST['role'] == "") {
        $roleErr = "This field is required.";
        $noError = false;
    } else {
        $role = validate_input($_POST['role']);
    }

    // email
    $email = validate_input($_POST["email"]);
    if (empty($email)) {
        $emailErr = "Email address is required.";
        $noError = false;
    } else if (!preg_match("/^[\w\.\-_]+@[a-zA-Z]+\.[a-zA-Z]+$/", $email)) {
        $emailErr = "Invalid Eamil format.";
        $noError = false;
    }

    // password
    $pswd = validate_input($_POST["pswd"]);
    if (empty($pswd)) {
        $pswdErr = "Please enter your password.";
        $noError = false;
    }

    if ($noError) {
        $validUser = checkPassword($email, $pswd, $role);
        if ($validUser) {
            $_SESSION["loggedin"] = true;

            // if redirect to another page other than user profile
            if (isset($_GET["redirect"])) {
                // redirect to user profile
                header("Location: " . $_GET["redirect"]);
                exit();
            } else {
                if ($role == "owner") { // redirect to restaurant profile 
                    header("Location: screens/user/RestaurantProfile.html");
                    exit();
                } else if ($role == "customer") { // redirect to user profile
                    header("Location: screens/user/userprofile.php");
                    exit();
                }
            }
        } else {
            $loginErr = "Invalid user information.";
        }
    }
}
