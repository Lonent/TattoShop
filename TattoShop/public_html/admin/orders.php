<?php
include 'header.php';
include 'php/db.php';
?>

<main>
    <?php if (isset($_SESSION['admin_id'])) { ?>

    <?php
    $searchTerm = "";

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
    }

    $num_per_page = 10;
    $start_from = ($page - 1) * $num_per_page;

    $stmt = $dbh->prepare("SELECT orders.id, orders.user_id, delivery.adress, delivery.postcode, orders.status 
                       FROM orders 
                       INNER JOIN delivery 
                       ON orders.delivery_id=delivery.id 
                       WHERE orders.id LIKE :searchTerm OR orders.user_id LIKE :searchTerm OR orders.status LIKE :searchTerm
                       LIMIT :start_from, :num_per_page");
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':num_per_page', $num_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="col-12 col-lg-10 row mx-auto mt-1 mt-md-5">
        <div class="d-flex">
            <div class="col-7 col-md-6">
                <label></label>
                <div class="input-group">
                    <div class="form-outline col-8">
                        <form class="d-flex" method="get" action="orders.php">
                            <input type="search" id="form1" name="search" class="col-12" />
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 border border-dark mt-3 mt-md-5 px-0 w-100">
            <?php foreach ($orders as $order) { ?>
                <div class="admin-card d-flex mx-auto mt-3 mb-2 col-12 col-lg-10 border border-dark"
                    id="order-<?php echo $order['id']; ?>">
                    <div class="col-2">
                        <div class="card-id col-12  mt-2 d-block d-md-flex ms-2">
                            <div class="fw-bold">Order ID:</div>
                            <div class="ms-2 order-id">
                                <?php echo $order['id']; ?>
                            </div>
                        </div>
                        <div class="card-id col-12  mt-2 d-block d-md-flex ms-2">
                            <div class="fw-bold">User ID:</div>
                            <div class="ms-2 user-id">
                                <?php echo $order['user_id']; ?>
                            </div>
                        </div>
                    </div>


                    <div class=" col-8">
                        <div class="card-address col-12 mt-2 d-flex">
                            <div class="fw-bold col-4 col-lg-3">Delivery Address:</div>
                            <div class="ms-2 address">
                                <?php echo $order['adress']; ?>
                            </div>
                        </div>
                        <div class="card-postcode col-12 mt-2 d-flex">
                            <div class="fw-bold col-4 col-lg-3">Delivery Postcode:</div>
                            <div class="ms-2 postcode">
                                <?php echo $order['postcode']; ?>
                            </div>
                        </div>
                        <div class="card-status col-12 mt-2 d-md-flex">
                            <div class="fw-bold col-4 col-lg-3">Status:</div>
                            <div class="d-flex">
                                <div class="ms-2 status">
                                    <select class="form-select form form-select-sm status-select">
                                        <option value="processing" <?php echo ($order['status'] === 'processing') ? 'selected' : ''; ?>>Processing</option>
                                        <option value="completed" <?php echo ($order['status'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="paid" <?php echo ($order['status'] === 'paid') ? 'selected' : ''; ?>>
                                            Paid</option>
                                        <option value="canceled" <?php echo ($order['status'] === 'canceled') ? 'selected' : ''; ?>>Canceled</option>
                                        <!-- Add more status options as needed -->
                                    </select>
                                </div>
                                <div class="ms-2">
                                    <button class="btn btn-dark status-update-btn btn-sm"
                                        data-order-id="<?php echo $order['id']; ?>"><i class="fa fa-check"
                                            aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-2 col-md-1 col d-flex flex-column ms-auto h-100 ">
                        <button class="modular-card col-12 border-4 flex-grow-1"
                            data-order-id="<?php echo $order['id']; ?>"><i class="fa fa-arrow-right"
                                aria-hidden="true"></i></button>


                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-12 d-flex justify-content-center mt-3 mb-5">
            <?php
            $stmt = $dbh->prepare("SELECT * FROM orders WHERE id LIKE :searchTerm OR user_id LIKE :searchTerm OR status LIKE :searchTerm");
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->execute();
            $total_records = $stmt->rowCount();

            $total_pages = ceil($total_records / $num_per_page);

            if ($total_pages > 1) {
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a class='btn btn-dark m-1' href='orders.php?page=" . $i . "&search=" . $searchTerm . "'>" . $i . "</a> ";
                }
            }
            ?>
        </div>

    </div>

</main>

<div class="modal fade" tabindex="-1" id="productModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
            </div>
            <div class="modal-body">
                <table id="productTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock Address</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-dark" id="updateButton">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php } else {
header('Location: index.php');
};?>
<script>

    $(".status-update-btn").click(function () {
        var orderId = $(this).data("order-id");
        var status = $(this).parent().prev().find('.status-select').val();

        // Send the data to the server
        $.post("php/update-order-status.php", { orderId: orderId, status: status })
            .done(function (data) {
                // Handle response here. For example, show a success message.
                alert('Order status updated successfully');
            });
    });


    $(document).ready(function () {
        $(".modular-card").click(function () {
            var orderId = $(this).attr("data-order-id"); // Make sure to use order id, not product id

            // Make an AJAX request to retrieve order data
            $.get("php/get-order-products.php", { id: orderId })
                .done(function (data) {
                    var orderProducts = JSON.parse(data);
                    // clear old data
                    $("#productTable tbody").empty();
                    // iterate through each item in the orderProducts array
                   orderProducts.forEach(function (product) {
                        // Create a new row
                        var row = $("<tr></tr>");
                        row.append($("<td></td>").text(product.buy_product_id));  // added buy_product_id column
                        row.append($("<td></td>").text(product.id));
                        row.append($("<td></td>").text(product.name));
                        row.append($("<td></td>").text(product.adress)); // added address column
                        row.append($("<td><input type='number' class='form-control product-quantity' value='" + product.quantity + "'></td>"));
                        // Add the row to the table
                        $("#productTable tbody").append(row);
                    });


                    $('#productModal').modal('show');
                });
        });


        // Handle the save button click
        $("#updateButton").click(function () {
            var products = [];
            // Gather all product data
            $("#productTable tbody tr").each(function () {
                var row = $(this);
                var product = {
                    id: row.find('td:eq(0)').text(),
                    quantity: row.find('.product-quantity').val()
                };
                products.push(product);
            });

            // Send the data to the server
            $.post("php/update-order-products.php", { products: JSON.stringify(products) })
                .done(function (data) {
                    // Handle response here. For example, close the modal and refresh the page.
                    $('#productModal').modal('hide');
                    //location.reload();
                });
        });
    });




</script>