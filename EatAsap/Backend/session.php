<?php
function setTrackingCookies() {
    // Set session expiration time to 30 minutes
    $expiration_time = 30 * 60; // 30 minutes in seconds

    // Set session cookie parameters
    // Set cookies for tracking or analytics for 1 hour,transmitted over a secure HTTPS,
    // and will be accessible only through the HTTP protocol not scripting languages 
  
  // for production environment
   session_set_cookie_params($expiration_time, '/', 'eatasap1.000webhostapp.com', true, true);


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
function setUserLogin($user_id, $user_name, $user_role) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_role'] = $user_role;
}
?>