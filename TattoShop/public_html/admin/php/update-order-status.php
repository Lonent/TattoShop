<?php
include 'db.php';

if (isset($_POST['orderId']) && isset($_POST['status'])) {
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    $stmt = $dbh->prepare("UPDATE orders SET status = :status WHERE id = :orderId");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();

    // Send a response back to the client
    echo json_encode(['status' => 'success']);
}
?>
