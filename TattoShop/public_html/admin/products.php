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

        $stmt = $dbh->prepare("
    SELECT products.*, stocks.adress
    FROM products 
    JOIN stocks ON products.stock_id = stocks.id
    WHERE products.id LIKE :searchTerm OR products.name LIKE :searchTerm OR products.type LIKE :searchTerm  
    LIMIT :start_from, :num_per_page
");
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->bindParam(':num_per_page', $num_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Create a prepared statement to fetch the image
        $img_stmt = $dbh->prepare("SELECT image FROM images WHERE product_id = :productId AND type = 1 LIMIT 1");

        ?>

        <div class="col-12 col-lg-10 row mx-auto mt-1 mt-md-5">
            <div class="d-flex">
                <div class="col-7 col-md-6">
                    <label></label>
                    <div class="input-group">
                        <div class="form-outline col-8">
                            <form class="d-flex" method="get" action="products.php">
                                <input type="search" id="form1" name="search" class="col-12" />
                                <button type="submit" class="search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <form action="add-new-product.php" class="col-md-2 mt-2 ms-auto">
                    <button class="sign-btn  w-100">Add New Product
                    </button>
                </form>
            </div>


            <div class="col-12 border border-dark mt-3 mt-md-5  px-0">
                <?php foreach ($products as $product) {

                    // Execute the statement to fetch the image
                    $img_stmt->bindValue(':productId', $product['id'], PDO::PARAM_INT);
                    $img_stmt->execute();
                    $image = $img_stmt->fetch(PDO::FETCH_ASSOC);

                    $imagePath = $image ? '../images/' . $image['image'] : '/images/example.webp';
                    ?>
                    <div class="admin-card d-flex mx-auto mt-3 mb-2 col-12 col-lg-10 border border-dark"
                        id="product-<?php echo $product['id']; ?>">
                        <div class="h-100 col-3 col-lg-2 d-none d-md-block">
                            <img class="card-img img-fluid img-thumbnail h-100" src="<?php echo $imagePath; ?>">
                        </div>
                        <div class=" col-3 d-block">
                            <div class="card-id col-12 col-md-2 text-center mt-2 d-flex ms-2">
                                <div class="fw-bold">ID:</div>
                                <div class="ms-2 product-id">
                                    <?php echo $product['id']; ?>
                                </div>
                            </div>
                            <div class="h-100 col-12 mt-3 d-sm-none d-flex justify-content-center">
                                <img class="card-img img-fluid img-thumbnail h-25 w-75" src="<?php echo $imagePath; ?>">
                            </div>
                        </div>
                        <div class="d-block col-6 col-md-6 ">
                            <div class="card-title col-12 ms-lg-4 mt-2 d-flex">
                                <div class="fw-bold">Name:</div>
                                <div class="ms-2 product-name">
                                    <?php echo $product['name']; ?>
                                </div>
                            </div>
                            <div class=" col-12 col-md-5 ms-lg-4">
                                <div class="card-price col-6 mt-2 d-flex">
                                    <div class="fw-bold">Price:</div>
                                    <div class="ms-2 product-price">
                                        <?php echo $product['price']; ?>
                                    </div>
                                </div>
                                <div class="card-quantity col-6 mt-2 d-flex">
                                    <div class="fw-bold">Quantity:</div>
                                    <div class="ms-2 product-quantity">
                                        <?php echo $product['quantity']; ?>
                                    </div>
                                </div>
                                <div class="card-typ col-12 mt-2 d-flex">
                                    <div class="fw-bold">Type:</div>
                                    <div class="ms-2 col-12 product-type">
                                        <?php echo $product['type']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-lg-1 col d-flex flex-column ms-auto h-100 ">
                            <button class="modular-card col-12 border-4 flex-grow-1"
                                data-product-id="<?php echo $product['id']; ?>"><i class="fa fa-arrow-right"
                                    aria-hidden="true"></i></button>
                            <button class="admin-del col-12 border-4 flex-grow-1 mt-1"
                                data-product-id="<?php echo $product['id']; ?>"><i class="fa fa-times"
                                    aria-hidden="true"></i></button>

                        </div>
                    </div>
                <?php } ?>

            </div>

            <div class="col-12 d-flex justify-content-center mt-3 mb-5">
                <?php
                $stmt = $dbh->prepare("SELECT * FROM products WHERE id LIKE :searchTerm OR name LIKE :searchTerm");
                $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
                $stmt->execute();
                $total_records = $stmt->rowCount();

                $total_pages = ceil($total_records / $num_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<a class='btn btn-dark m-1' href='products.php?page=" . $i . "&search=" . $searchTerm . "'>" . $i . "</a> ";
                }
                ?>
            </div>
        </div>

    </main>

    <div class="modal" tabindex="-1" id="productModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Details</h5>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" class="form-control" id="productId" placeholder="Product ID">
                        <div class="form-group">
                            <label for="productPrice">Product Name</label>
                            <input type="text" class="form-control" id="productName" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Description</label>
                            <textarea type="text" class="form-control" id="productDescription"
                                placeholder="Product Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Short Description</label>
                            <textarea type="text" class="form-control" id="productDescription_sh"
                                placeholder="Product Short Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Price</label>
                            <input type="text" class="form-control" id="productPrice" placeholder="Product Price">
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Quantity</label>
                            <input type="text" class="form-control" id="productQuantity" placeholder="Product Quantity">
                        </div>
                        <div class="form-group">
                            <label for="productSale">Product On Sale</label>
                            <select class="form-control" id="productSale">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productadress">Product address</label>
                            <select class="form-control" id="productadress">
                                <?php
                                $stockStmt = $dbh->prepare("SELECT * FROM stocks");
                                $stockStmt->execute();
                                $stocks = $stockStmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($stocks as $stock) {
                                    echo '<option value="' . $stock['id'] . '" ">' . $stock['adress'] . '</option>';
                                }
                                ?>
                            </select>
                            <div class="mb-3">
                                <label for="product-category" class="form-label">Product Type</label>
                                <select class="form-select" id="product-category">
                                    <option value="tattoo-machine">Tattoo Machine</option>
                                    <option value="color">Color</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                    </form>
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
    }
    ; ?>
<script>
    $(document).ready(function () {
        $(".modular-card").click(function () {
            var productId = $(this).attr("data-product-id");

            // Make an AJAX request to retrieve product data
            $.get("php/get-product.php", { id: productId })
                .done(function (data) {
                    var product = JSON.parse(data);

                    // Populate the input fields with product data
                    $("#productId").val(product.id);
                    $("#productName").val(product.name);
                    $("#productDescription").val(product.description);
                    $("#productDescription_sh").val(product.description_sh);
                    $("#productPrice").val(product.price);
                    $("#productQuantity").val(product.quantity);
                    $("#productSale option").each(function () {
                        if ($(this).val() == product.sale) {
                            $(this).prop("selected", true);
                            return false; // Exit the loop
                        }
                    });
                    $("#productadress option").each(function () {
                        if ($(this).val() == product.stock_id) {
                            $(this).prop("selected", true);
                            return false; // Exit the loop
                        }
                    });


                    // Set the selected option in the product category select element
                    $("#product-category option").each(function () {
                        if ($(this).val() === product.type) {
                            $(this).prop("selected", true);
                            return false; // Exit the loop
                        }
                    });

                    // Show the modal
                    $('#productModal').modal('show');
                });
        });
    });

    // On save button click
    $("#updateButton").click(function () {
        // Get form data
        var productData = {
            id: $("#productId").val(),
            name: $("#productName").val(),
            description: $("#productDescription").val(),
            description_sh: $("#productDescription_sh").val(),
            price: $("#productPrice").val(),
            quantity: $("#productQuantity").val(),
            sale: $("#productSale").val(),
            stock_id: $("#productadress").val(),
            type: $("#product-category").val()
        };
        console.log(productData);

        // Send an AJAX POST-request with jQuery
        $.post("php/update-product.php", productData)
            .done(function (data) {
                // Log response to the console
                console.log(data);

                // Reload the page
                location.reload();
            })
            .fail(function () {
                alert('Error : Failed to update product');
            });
    });


    $(".admin-del").click(function () {
        var productId = $(this).attr("data-product-id");

        // Confirm if the user really wants to delete the product
        var confirmDelete = confirm('Are you sure you want to delete this product?');

        if (confirmDelete) {
            // Send an AJAX POST-request with jQuery
            $.post("php/delete-product.php", { id: productId })
                .done(function (data) {
                    // Log response to the console
                    console.log(data);

                    // Remove the product card from the DOM
                    $("#product-" + productId).remove();
                })
                .fail(function () {
                    alert('Error : Failed to delete product');
                });
        }
    });




</script>