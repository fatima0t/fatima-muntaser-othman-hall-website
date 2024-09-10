<?php
// Start the session
session_start();

// Destroy the session and all its data
session_destroy();

// Set a session variable to display a success message on the login page
$_SESSION['logout_success'] = true;

// Redirect the user to the login page
header("Location: login.php");
exit;
?>


