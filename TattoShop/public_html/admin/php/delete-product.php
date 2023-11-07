<?php
    include 'db.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $dbh->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo 'Product deleted successfully.';
    }
?>
