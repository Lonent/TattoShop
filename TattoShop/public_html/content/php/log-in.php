<?php
session_start(); // Start the session

include 'db.php'; // Include the database connection file

// Get the email and password from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email exists in the database
$query = "SELECT * FROM users WHERE email=:email";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Email exists, so check if password matches
    if (password_verify($password, $user['password'])) {
        // Password matches, so create session variables
        $_SESSION['user_id'] = $user['id'];
        // Redirect to the home page
       
        header('Location: ../index.php');
        exit();
    exit();
    } else {
        // Password does not match, so show an error message
        echo "<p>Incorrect password.</p>";
    }
} else {
    // Email does not exist, so show an error message
    echo "<p>That email address does not exist.</p>";
}


?>
