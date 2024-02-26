<?php
session_start();

// Function to check if user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Function to set user login
function setUserLogin($user_id, $user_name) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $user_name;
}

// Function to log out user
function logoutUser() {
    session_unset();
    session_destroy();
}

// Function to get cart items
function getCartItems() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}
?>
