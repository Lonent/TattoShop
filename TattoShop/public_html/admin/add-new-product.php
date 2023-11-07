<?php
include "header.php";
include "php/db.php"; // Include database connection

// Fetch all stock IDs and names from the database
$stmt = $dbh->prepare("SELECT id, adress FROM stocks");
$stmt->execute();
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['admin_id'])) {
?>
<main>
    <div class="col-12 col-md-8 col-sm-9 col-lg-7 col-xl-6 mx-auto mt-3 mt-lg-5">
        <h3>Admin Panel Enter</h3>
        <form id="productForm" method="post" action="php/add-product.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Product Name">
            </div>
            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Product Description"></textarea>
            </div>
            <div class="form-group">
                <label for="description_sh">Product Short Description</label>
                <textarea class="form-control" id="description_sh" name="description_sh" rows="3"
                    placeholder="Product Short Description"></textarea>
            </div>
            <div class="row">
                <div class="col">
                    <label for="productPrice">Product Price</label>
                    <input type="text" class="form-control" id="productPrice" name="productPrice" placeholder="Product Price">
                </div>
                <div class="col">
                    <label for="productQuantity">Product Quantity</label>
                    <input type="text" class="form-control" id="productQuantity" name="productQuantity" placeholder="Product Quantity">
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label for="productSale">Product On Sale</label>
                    <select class="form-control" id="productSale" name="productSale">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="col">
                    <label for="productStock_id">Product Stock</label>
                    <select class="form-control" id="productStock_id" name="productStock_id">
                        <?php foreach ($stocks as $stock): ?>
                            <option value="<?= $stock['id'] ?>"><?= $stock['adress'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="product-category" class="">Product Type</label>
                <select class="form-select" id="product-category" name="product-category">
                    <option value="tattoo-machine">Tattoo Machine</option>
                    <option value="color">Color</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="custom-file">
                <label class="" for="customFile">Image</label>
                <input type="file" class="form-control" id="customFile" name="upload[]" accept="image/png, image/gif, image/jpeg"
                    multiple>
            </div>
            <button type="submit" class="sign-btn w-100 mt-3">Submit</button>
        </form>
    </div>
</main>

<?php } else {
    header('Location: index.php');
}
?>
