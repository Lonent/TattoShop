<?php
include 'db.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    $stmt = $dbh->prepare("SELECT buy_products.id AS buy_product_id, buy_products.quantity, products.id, products.name, stocks.adress
                           FROM buy_products
                           INNER JOIN products
                           ON buy_products.product_id=products.id
                           INNER JOIN stocks
                           ON products.stock_id=stocks.id
                           WHERE buy_products.order_id = :orderId");
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $orderProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($orderProducts);
}
?>
