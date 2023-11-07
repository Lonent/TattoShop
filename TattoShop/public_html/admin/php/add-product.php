<?php
include "db.php"; // Include database connection

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['productName'];
    $description = $_POST['description'];
    $description_sh = $_POST['description_sh'];
    $price = $_POST['productPrice'];
    $quantity = $_POST['productQuantity'];
    $sale = $_POST['productSale'];
    $stock_id = $_POST['productStock_id'];
    $type = $_POST['product-category'];

    // Insert data into database
    $stmt = $dbh->prepare("INSERT INTO products (name, description, description_sh, price, quantity, sale, stock_id, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $description_sh, $price, $quantity, $sale, $stock_id, $type]);
    
    // Get the last inserted product id
    $last_id = $dbh->lastInsertId();

    // File upload handling
    $total = count($_FILES['upload']['name']);
    
    // Loop through each file
    for( $i=0 ; $i < $total ; $i++ ) {
        //Get the temp file path
        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

        //Make sure we have a file path
        if ($tmpFilePath != ""){
            //Setup our new file path
            $newFilePath = __DIR__ . '/../../images/' . $_FILES['upload']['name'][$i];

            
            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                // File moved, insert the data to images table
                $image_type = $i == 0 ? 1 : 0; // set the type to 1 for the first image, 0 for the rest
                $stmt = $dbh->prepare("INSERT INTO images (product_id, image, type) VALUES (?, ?, ?)");
                $stmt->execute([$last_id, $_FILES['upload']['name'][$i], $image_type]);
                var_dump($image_type);
            }
        }
    }
    
    // Redirect back to the form or to another page
    //header('Location: ../products.php');
} else {
    // Redirect to form page in case of direct access to this script
    header('Location: add-product.php');
}
?>
