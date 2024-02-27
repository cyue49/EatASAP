<?php

// user input values
$firstName = $lastName = $email = $phoneNum = $address = $restaurantEmail = $restaurantPhoneNum = $restaurantAddress = $password = $retypePassword = $restaurantName = $brandName = $businessType = $website = "";

// user input errors
$firstNameErr = $lastNameErr = $emailErr = $phoneNumErr = $addressErr = $restaurantEmailErr = $restaurantPhoneNumErr = $restaurantAddressErr = $passwordErr = $retypePasswordErr = $restaurantNameErr = $brandNameErr = $businessTypeErr = $websiteErr = "";

// trim data, remove slashes, etc.
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

    // restaurant email
    $restaurantEmail = validate_input($_POST["restaurantEmail"]);
    if (empty($restaurantEmail)) {
        $restaurantEmailErr = "Restaurant Email address is required.";
        $noError = false;
    } else if (!preg_match("/^[\w\.\-_]+@[a-zA-Z]+\.[a-zA-Z]+$/", $restaurantEmail)) {
        $restaurantEmailErr = "Invalid Email format.";
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

    // restaurant phone number
    $restaurantPhoneNum = validate_input($_POST["restaurantPhoneNum"]);
    if (empty($restaurantPhoneNum)) {
        $restaurantPhoneNumErr = "Restaurant Phone number is required.";
        $noError = false;
    } else if (!preg_match("/^\d{10,13}$/", $restaurantPhoneNum)) {
        $restaurantPhoneNumErr = "Invalid phone number format. Please make sure to enter between 10 and 13 digits.";
        $noError = false;
    }

    // user address
    $address = validate_input($_POST["address"]);
    if (!empty($address)) {
        if (!preg_match("/^[a-zA-Z0-9\-]+$/", $address)) {
            $addressErr = "Invalid address format.";
            $noError = false;
        }
    }

    // restaurant address
    $restaurantAddress = validate_input($_POST["restaurantAddress"]);
    if (empty($restaurantAddress)) {
        $restaurantAddressErr = "Restaurant Address is required.";
        $noError = false;
    } else if (!preg_match("/^[a-zA-Z0-9\-]+$/", $restaurantAddress)) {
        $restaurantAddressErr = "Invalid last name format.";
        $noError = false;
    }

    // password
    $password = validate_input($_POST["password"]);
    if (empty($password)) {
        $passwordErr = "Please enter your password.";
        $noError = false;
    }

    // retype password
    $retypePassword = validate_input($_POST["retypePassword"]);
    if (empty($retypePassword)) {
        $retypePasswordErr = "Retype Password is required.";
        $noError = false;
    } else if ($retypePassword != $password) {
        $retypePasswordErr = "Your retyped password doesn't match your password.";
    }

    // restaurant name
    $restaurantName = validate_input($_POST["restaurantName"]);
    if (empty($restaurantName)) {
        $restaurantNameErr = "Restaurant Name is required.";
        $noError = false;
    } else if (!preg_match("/^[a-zA-Z0-9\-]+$/", $restaurantName)) {
        $restaurantNameErr = "Invalid restaurant name format.";
        $noError = false;
    }

    // brand name
    $brandName = validate_input($_POST["brandName"]);
    if (empty($brandName)) {
        $brandNameErr = "Brand Name is required.";
        $noError = false;
    } else if (!preg_match("/^[a-zA-Z0-9\-]+$/", $brandName)) {
        $brandNameErr = "Invalid brand name format.";
        $noError = false;
    }

    // business type
    if ($_POST['businessType'] == "") {
        $businessTypeErr = "This field is required.";
        $noError = false;
    } else {
        $businessType = validate_input($_POST['businessType']);
    }

    // website
    $website = validate_input($_POST["website"]);
    if (!empty($website)) {
        if (!preg_match("/^[a-zA-Z\-]+$/", $website)) {
            $websiteErr = "Invalid website format.";
            $noError = false;
        }
    }

    if ($noError) {
        echo "ok";
    }
}
