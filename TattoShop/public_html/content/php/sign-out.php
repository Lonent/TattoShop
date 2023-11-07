<?php
session_start();
// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in.php
    header('Location: sign-in.php');
    exit;
}

// Unset all the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page
header('Location: ../sign-in.php');
    exit();
?>
