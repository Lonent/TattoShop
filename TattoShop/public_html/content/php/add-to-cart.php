<?php 
include 'db.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"]=="POST") {

    $product_id = $_POST["product_id"];
    $quantity = 1;

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // If the user is not logged in, redirect to the sign-in page
        header('Location: ../sign-in.php');
        exit;
    } else {
        $user_id = $_SESSION['user_id'];
    }

    // Check if the product ID already exists in the cart session variable
    if (!isset($_SESSION['cart'])) {
        // If the cart session variable does not exist, create it and set it to an empty array
        $_SESSION['cart'] = array();
    } else {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                // If the product ID already exists in the cart, increment the quantity and set the $found flag to true
                $item['quantity']++;
                $quantity = $item['quantity'];
                $found = true;
                break;
            }
        }
        unset($item); // Unset the reference to the last item to avoid conflicts with future foreach loops
    }
    
    if (!$found) {
        // If the product ID does not exist in the cart, add it with a quantity of 1
        array_push($_SESSION['cart'], array('product_id' => $product_id, 'quantity' => 1));
    }

    // Check if the product ID already exists in the cart table
    $stmt = $dbh->prepare("SELECT * FROM cart WHERE `user_id` = :user_id AND `product_id` = :product_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // If the product ID already exists in the cart table, update the quantity
        $stmt = $dbh->prepare("UPDATE cart SET quantity = quantity + 1 WHERE `user_id` = :user_id AND `product_id` = :product_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
    } else {
        // If the product ID does not exist in the cart table, insert a new row
        $stmt = $dbh->prepare("INSERT INTO cart (`user_id`, `product_id`, quantity) VALUES (:user_id, :product_id, 1)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);

        $stmt->execute();
    }

} 
?>
