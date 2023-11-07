<?php

// Check if confirmation code is set in session
if (!isset($_SESSION['confirmation_code'])) {
    // Redirect back to send-code.php
    header('Location: php/mail.php');
    exit;
}

// Get the confirmation code from session
$confirmation_code = $_SESSION['confirmation_code'];

// Check if form has been submitted
if (isset($_POST['submit'])) {
    // Get the entered confirmation code
    $entered_code = $_POST['confirmation_code'];

    // Compare the entered code with the confirmation code from session
    if ($entered_code == $confirmation_code) {
        // Get email and password from the session
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];

        // Check if user with this email already exists in the database
        $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // User with this email already exists
            $user_exist = true;

        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Add the user to the database
            $stmt = $dbh->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $result = $stmt->execute();
        }
    } else {
        // Show "Wrong verification code" label
        $show_label = true;
    }
}
?>
