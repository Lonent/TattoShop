<?php

include "db.php";

$id = $_GET['id'];
$stmt = $dbh->prepare('
    SELECT products.*, stocks.adress 
    FROM products 
    JOIN stocks ON products.stock_id = stocks.id
    WHERE products.id = :id
');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($product);

?>
