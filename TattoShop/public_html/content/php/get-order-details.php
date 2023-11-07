<?php
include 'db.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $stmt = $dbh->prepare("
        SELECT products.*, buy_products.quantity AS buy_quantity, images.image
        FROM products
        INNER JOIN buy_products ON products.id = buy_products.product_id
        LEFT JOIN images ON products.id = images.product_id AND images.type = 1
        WHERE buy_products.order_id = :order_id
    ");
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize total price
    $total_price = 0;
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th class="d-none d-sm-table-cell">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product) {
                // Update total price
                $total_price += $product['price'] * $product['buy_quantity'];
                ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($product['name']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($product['description_sh']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($product['price']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($product['buy_quantity']); ?>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" width="100" height="100"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class = "d-flex">
        <div class = "fw-bold">Total Order Price:</div>
        <div class = "ms-2"><?php echo $total_price; ?> $</div>
    </div>
    <?php
}
?>
