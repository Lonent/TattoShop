<?php
include 'db.php';

if (isset($_POST['products'])) {
    $products = json_decode($_POST['products'], true);

    foreach ($products as $product) {
        $stmt = $dbh->prepare("UPDATE buy_products SET quantity = :quantity WHERE id = :productId");
        $stmt->bindValue(':productId', $product['id']);
        $stmt->bindValue(':quantity', $product['quantity']);
        $stmt->execute();
        
    }

    // Send a response back to the client
    echo json_encode(['status' => 'success']);
}
?>
