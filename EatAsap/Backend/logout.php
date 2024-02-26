<?php
// Function to log out user
function logoutUser()
{
    session_start();
    $_SESSION = array();
    session_destroy();

    if (isset($_GET["redirect"])) {
        // redirect to specific page
        header("Location: " . $_GET["redirect"]);
        exit();
    } else { // redirect to index
        header("Location: ../Frontend/index.html");
        exit();
    }
}

logoutUser();