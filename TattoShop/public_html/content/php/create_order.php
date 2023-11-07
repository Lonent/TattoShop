<?php
include 'db.php';

$address = $_POST['address'];
$postcode = $_POST['postcode'];
$user_id = $_POST['user_id'];
$currentDate = date('Y-m-d');
$total_price = $_POST['total_price'];
$cardNumber = str_replace(' ', '', $_POST['cardNumber']);
$cvc = $_POST['cvc'];
$expiration = $_POST['expiration'];

$stmt = $dbh->prepare("SELECT * FROM delivery WHERE adress = :adress AND postcode = :postcode AND user_id = :user_id");
$stmt->bindParam(':adress', $address);
$stmt->bindParam(':postcode', $postcode);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// If no data is found, insert the new row
if($stmt->rowCount() == 0) {
    $stmt = $dbh->prepare("INSERT INTO delivery (adress, postcode, user_id) VALUES (:adress, :postcode, :user_id)");
    $stmt->bindParam(':adress', $address);
    $stmt->bindParam(':postcode', $postcode);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

$stmt = $dbh->prepare("SELECT id FROM delivery WHERE adress = ? AND postcode = ? AND user_id = ?");
$stmt->execute([$address, $postcode, $user_id]);
$delivery_id = $stmt->fetchColumn();

// convert expiration to timestamp
$expirationTimestamp = DateTime::createFromFormat('m/y', $expiration);
if ($expirationTimestamp === false) {
    // handle invalid format
    die('Invalid expiration date format.');
}
$expirationTimestamp = $expirationTimestamp->getTimestamp();

// get current timestamp
$currentTimestamp = time();

// compare the two
$status = ($expirationTimestamp < $currentTimestamp) ? 0 : 1; // Check expiration date

// Execute insert statement
$stmt = $dbh->prepare("INSERT INTO payments (user_id, `status`, card_number, cvc, expiration ) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $status, $cardNumber, $cvc, $expiration]);

// Get last inserted id
$payment_id = $dbh->lastInsertId();

$stmt = $dbh->prepare("INSERT INTO orders (`date`, user_id, delivery_id, order_price, `status`, payment_id) VALUE (?,?,?,?,?,?)");
$stmt->execute([$currentDate, $user_id, $delivery_id, $total_price, "processing", $payment_id]);
$order_id = $dbh->lastInsertId(); // Get the id of the newly created order

// Fetch items from cart
$stmt = $dbh->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Insert items into buy_products
$stmt = $dbh->prepare("INSERT INTO buy_products (order_id, product_id, quantity) VALUES (?, ?, ?)");
foreach($cartItems as $item) {
    $stmt->execute([$order_id, $item['product_id'], $item['quantity']]);
}

// Delete rows from cart
$stmt = $dbh->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);

header('Location: ../cart.php');
?>
