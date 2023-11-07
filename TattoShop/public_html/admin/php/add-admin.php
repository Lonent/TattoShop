<?php
include 'db.php'; // Include the database connection file

// Retrieve the submitted form data
$login = $_POST['login'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if an admin with the same login already exists
$stmt = $dbh->prepare("SELECT * FROM admins WHERE login = ?");
$stmt->execute([$login]);

if ($stmt->rowCount() > 0) {
    // An admin with the same login already exists
    header('Location: ../add-admin.php?error=1');
    exit();
}

// Insert the new admin into the database
$stmt = $dbh->prepare("INSERT INTO admins (login, password) VALUES (?, ?)");
$stmt->execute([$login, $hashedPassword]);

// Check if the admin was successfully added
if ($stmt->rowCount() > 0) {
    header('Location: ../products.php');
} else {
    echo "Failed to add admin.";
}
?>
