<?php
// Assuming you're using a PDO connection
include 'db.php';

header('Content-Type: application/json');

// Check if all required parameters are set
if(isset($_POST['id'], $_POST['name'], $_POST['description'], $_POST['description_sh'], $_POST['price'], $_POST['quantity'], $_POST['sale'], $_POST['stock_id'], $_POST['type'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $description_sh = $_POST['description_sh'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $sale = $_POST['sale'];
    $stock_id = $_POST['stock_id'];
    $type = $_POST['type'];

    // Prepare an UPDATE statement
    $stmt = $dbh->prepare("UPDATE products SET name = :name, description = :description, description_sh = :description_sh, price = :price, quantity = :quantity, sale = :sale, stock_id = :stock_id, type = :type WHERE id = :id");

    // Bind the variables to the prepared statement
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':description_sh', $description_sh);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':quantity', $quantity);
    $stmt->bindValue(':sale', $sale);
    $stmt->bindValue(':stock_id', $stock_id);
    $stmt->bindValue(':type', $type);
    // Execute the statement
    $stmt->execute();


    // Send back the updated product data as a JSON response
    echo json_encode($id);
} else {
    // Return an error response if not all parameters are set
    http_response_code(400);
    echo json_encode(['error' => 'All parameters not set.']);
}
?>
