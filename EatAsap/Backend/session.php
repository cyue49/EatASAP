<?php
function setTrackingCookies() {
    // Set session expiration time to 30 minutes
    $expiration_time = 30 * 60; // 30 minutes in seconds

    // Set session cookie parameters
    session_set_cookie_params($expiration_time, '/', 'localhost', true, true);

    // Start the session
    session_start();
}

// Call the function to set tracking cookies
setTrackingCookies();


 
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
