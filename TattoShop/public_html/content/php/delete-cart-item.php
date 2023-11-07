<?php
include 'db.php'; 
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in.php
    header('Location: sign-in.php');
    exit;
}

// Check if the cart_id is set
if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    // Delete the row from the cart table with the same user_id and product_id
    $stmt = $dbh->prepare("
        DELETE FROM cart
        WHERE id = :cart_id AND user_id = :user_id
    ");
    $stmt->bindParam(':cart_id', $cart_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
}

// Redirect back to the cart page
header('Location: ../cart.php');
exit;
?>
