<?php
session_start();
// Check if confirmation code is set in session
if (!isset($_SESSION['pass_confirmation_code'])) {
    // Redirect back to send-code.php
    header('Location: php/mail-pass.php');
    exit;
}

// Get the confirmation code from session

$confirmation_code = $_SESSION['pass_confirmation_code'];

// Check if form has been submitted
if (isset($_POST['submit'])) {
    // Get the entered confirmation code
    $entered_code = $_POST['confirmation_code'];

    // Compare the entered code with the confirmation code from session
    if ($entered_code == $confirmation_code) {
        // Get email and password from the session
        $email = $_SESSION['email'];
        $password = $_SESSION['new_password'];


        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Add the user to the database
        $stmt = $dbh->prepare('UPDATE users SET password = :hashed_password WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $result = $stmt->execute();

        

    } else {
        // Show "Wrong verification code" label
        $show_label = true;
    }
}
