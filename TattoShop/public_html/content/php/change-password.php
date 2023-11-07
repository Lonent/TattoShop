<?php
session_start();
require_once 'db.php';

function redirectToChangePassword($message)
{
    $_SESSION['password_change'] = $message;
    header('Location: ../ch-pass.php');
    exit;
}

if (!isset($_POST['new_password']) || !isset($_POST['confirm_password'])) {
    redirectToChangePassword('Please fill in all the fields.');
}

$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    redirectToChangePassword('mismatch');
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (!isset($_POST['previous_password'])) {
        redirectToChangePassword('Please fill in all the fields.');
    }

    $previous_password = $_POST['previous_password'];

    $stmt = $dbh->prepare('SELECT password FROM users WHERE id = :user_id');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($previous_password, $user['password'])) {
        redirectToChangePassword('invalid');
    }
} else {
    if (!isset($_POST['email'])) {
        redirectToChangePassword('fill');
    }

    $email = $_POST['email'];

    $stmt = $dbh->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        redirectToChangePassword('email_not_found');
    }
    
    $user_id = $user['id'];
    
    // Store email in the session and redirect to mail.php
    $_SESSION['email'] = $email;
    $_SESSION['new_password'] = $new_password;
    header('Location: mail-pass.php');
    exit;
}

$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $dbh->prepare('UPDATE users SET password = :hashed_password WHERE id = :user_id');
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':hashed_password', $hashed_password);
$stmt->execute();
redirectToChangePassword('success');
header('Location: ../ch-pass.php');
exit;
?>
