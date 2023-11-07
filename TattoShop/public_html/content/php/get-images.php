<?php
header('Content-Type: application/json');

// Get the product_id from POST parameters
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

// Create an empty array to hold the images
$images = [];

if($product_id > 0) {
    // Connect to your database
    include 'db.php';

    // Prepare the query to get images associated with the product_id
    $stmt = $dbh->prepare('SELECT image FROM images WHERE product_id = :product_id');

    // Bind the product_id parameter and execute the query
    $stmt->execute([':product_id' => $product_id]);

    // Fetch all images
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output the images as JSON
echo json_encode($images);
?>
