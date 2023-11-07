<?php
session_start(); // Start the session

include 'db.php'; // Include the database connection file

// Get the login and password from the form
$login = $_POST['login'];
$password = $_POST['password'];

// Check if the login exists in the database
$query = "SELECT * FROM admins WHERE login=:login";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':login', $login);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {

    // Login exists, so check if password matches
    if (password_verify($password, $admin['password'])) {
        // Password matches, so create session variables
        $_SESSION['admin_id'] = $admin['id'];
        // Redirect to the products page
        header('Location: ../products.php');
        exit();
    } else {
        // Password does not match, so show an error message

        header('Location: ../index.php?error=1');
        exit();
    }
} else {
    // Login does not exist, so show an error message
    header('Location: ../index.php?error=1');
    exit();
}
?>
