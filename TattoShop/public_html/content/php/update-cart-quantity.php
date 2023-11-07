<?php
include 'db.php'; 
session_start();
// Get the cart ID and new quantity from the form
$cart_id = $_POST['cart_id'];
$new_quantity = $_POST['new_quantity'];

// Update the quantity in the database
$stmt = $dbh->prepare("UPDATE cart SET quantity = :new_quantity WHERE id = :cart_id");
$stmt->bindParam(':new_quantity', $new_quantity);
$stmt->bindParam(':cart_id', $cart_id);
$stmt->execute();

// Return the new quantity value
echo $new_quantity;
?>
