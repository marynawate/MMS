<?php
// logout.php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: home.html"); // Redirect to the login page
exit(); // Terminate the script
?>