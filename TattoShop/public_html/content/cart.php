<?php include 'header.php' ?>

<?php
// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
	// Redirect to sign-in.php
	header('Location: sign-in.php');
	exit;
}
?>

<?php
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];

	$stmt = $dbh->prepare("
    SELECT cart.id, cart.user_id, cart.product_id, cart.quantity, 
    products.name, products.price, 
    GROUP_CONCAT(images.image) as images
    FROM cart
    INNER JOIN products
    ON cart.product_id = products.id
    LEFT JOIN images
    ON cart.product_id = images.product_id
    WHERE cart.user_id = :user_id
    GROUP BY cart.id
");

	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total_price = 0;
foreach ($cart_items as $cart_item) {
	$total_price += $cart_item['price'] * $cart_item['quantity'];
}
?>

<main>
	<div class=" col-10 mx-auto pb-5 sign-in-cont d-xl-flex" style="min-height: 36em;">
		<div class="col-12 col-sm-10 col-md-10 col-lg-10 col-xl-7 mx-auto pt-lg-4   mx-auto row pt-4">
			<h3>Cart</h3>

			<ul class="cart-list list-group mb-2 mt-2 prod-scroll-box pr-5" tabindex="0">
				<?php foreach ($cart_items as $cart_item):
					$images = explode(',', $cart_item['images']);
					$first_image = $images[0];
					?>
					<li id="cart-item-<?php echo $cart_item['id']; ?>"
						class=" cart-list-row border border-dark mb-2 mt-2 col-12 mx-0 d-inline-flex justify-content-betwen ">
						<div class="cart-image h-100 col-lg-2">
							<img class="cart-image img-fluid img-thumbnail h-100" src="../images/<?php echo $first_image; ?>">
						</div>
						<div class=" col-10 col-md-9 d-md-flex">
							<div class="cart-name ms-2 col-11 col-md-7 ">
								<div class="fw-bold">Name</div>
								<?php echo $cart_item['name']; ?>
							</div>
							<div class="d-flex col-12 col-md-5 mt-2 mt-md-0">
								<div class="price ms-2 ms-md-0 col-6 col-md-7 mt-md-2 mt-xl-3">
									<div class="fw-bold">Price</div>
									<?php echo $cart_item['price']; ?>$
								</div>
								<div class="col-2 col-md-5">
									<div class="fw-bold">Count</div>
									<div class="d-flex align-items-center">
										<form>
											<input type="hidden" name="cart_id" value="<?php echo $cart_item['id']; ?>">
											<button type="button" class="btn btn-link p-0"
												onclick="decreaseQuantity(<?php echo $cart_item['id']; ?>)">
												<i class="fa fa-minus text-dark"></i>
											</button>
										</form>
										<div class="mx-2">
											<span id="quantity-<?php echo $cart_item['id']; ?>"
												data-price="<?php echo $cart_item['price']; ?>"><?php echo $cart_item['quantity']; ?></span>
										</div>
										<form>
											<input type="hidden" name="cart_id" value="<?php echo $cart_item['id']; ?>">
											<button type="button" class="btn btn-link p-0"
												onclick="increaseQuantity(<?php echo $cart_item['id']; ?>)">
												<i class="fa fa-plus text-dark"></i>
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
						<form action="php/delete-cart-item.php" method="post" class="h-100 col-2 col-md-1 ms-auto">
							<input type="hidden" name="cart_id" value="<?php echo $cart_item['id']; ?>">
							
							<button type="submit" class="del-btn w-100 h-100 my-0 pt-1">
								<i class="fa fa-times" aria-hidden="true"></i>
							</button>
						</form>


					</li>
				<?php endforeach; ?>
			</ul>

		</div>


		<div class=" col-10 col-sm-10 col-md-10 col-lg-5 col-xl-4 mx-auto pt-lg-4 row float-right" style="height:15em">
			<form action="order_form.php" method="POST" class="pay-btn h-25">
				<h3>Order</h3>
				<h4 id="total-price">Total price:
					<?php echo $total_price; ?>$
				</h4>
					<input type="hidden" name="total_price"	value="<?= $total_price ?>">
					<input type="hidden" name="user_id"	value="<?= $user_id ?>">
				<button type="submit" class="sign-btn w-100 ">Order</button>
			</form>
		</div>
	</div>
</main>
<?php include 'footer.php' ?>

<script>


	function decreaseQuantity(cartId) {
		var quantityElement = document.getElementById('quantity-' + cartId);
		var newQuantity = parseInt(quantityElement.innerText) - 1;

		if (newQuantity >= 1) {
			// Update the label
			quantityElement.innerText = newQuantity;

			// Update the quantity in the database
			updateQuantity(cartId, newQuantity);

			// Update the total price
			updateTotalPrice();
		}
	}

	function increaseQuantity(cartId) {
		var quantityElement = document.getElementById('quantity-' + cartId);
		var newQuantity = parseInt(quantityElement.innerText) + 1;

		// Update the label
		quantityElement.innerText = newQuantity;

		// Update the quantity in the database
		updateQuantity(cartId, newQuantity);

		// Update the total price
		updateTotalPrice();
	}

	function updateQuantity(cartId, newQuantity) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'php/update-cart-quantity.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				// Do something with the response
			}
		};
		xhr.send('cart_id=' + cartId + '&new_quantity=' + newQuantity);
	}

	function updateTotalPrice() {
		var cartItems = document.querySelectorAll("[id^='quantity-']");
		var totalPrice = 0;

		cartItems.forEach(function (item) {
			var quantity = parseInt(item.innerText);
			var price = parseFloat(item.getAttribute('data-price'));
			totalPrice += quantity * price;
		});

		document.getElementById('total-price').innerText = 'Total price: ' + totalPrice.toFixed(2) + '$';
	}

	updateTotalPrice();
</script>