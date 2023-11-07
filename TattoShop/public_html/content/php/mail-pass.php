<?php
// Start session to store confirmation code
session_start();

// Get the email address from the form submission
$email =  $_SESSION['email'];
// Generate a random confirmation code
$confirmation_code = rand(100000, 999999);

$to = $email;
$from = "tattoshop@tattoshop.ru";
$subject = 'Confirm your registration';
$message = "Thank you for registering on our website. Your confirmation code is: $confirmation_code";
$headers = 'From: noreply@example.com' . "\r\n" .
    'Reply-To: noreply@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)) {
    // Store the confirmation code in the session
    $_SESSION['pass_confirmation_code'] = $confirmation_code;
    $_SESSION['email'] = $email;
    // Redirect to sign-up-confirm.php
    header('Location: ../ch-pass-confrime.php');
    exit;
} else {
    // There was an error sending the email
    echo "Error sending confirmation email to $email.";
}
?>
