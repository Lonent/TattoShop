<?php include 'header.php' ?>
<?php
$stmt = $dbh->prepare('SELECT products.*, images.image FROM products 
LEFT JOIN images ON products.id = images.product_id AND images.type=1 
WHERE products.type = "other"');
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main>
	<div class="col-12 col-lg-10 mx-auto h-100">
		<?php include 'index-nav.php' ?>
		<div class="col-12 col-lg-10 mx-auto row border-top border-dark mt-4 justify-content-center p-md-4">
			<?php
			foreach ($data as $item) {
				?>
				<div class="card mx-auto m-md-2 mt-0 row col-6 col-sm-4 col-md-3 ">
					<img class="card-img-top" src="../images/<?php echo $item['image']; ?>">
					<div class="card-body">
						<h5 class="card-title ">
							<?php echo $item['name']; ?>
						</h5>
						<p class="card-text ">
							<?php echo $item['description-sh']; ?>
						</p>
						<div class="">
							<div class=" w-75 pb-2 mt-auto ps-1">
								<span class="fw-bold pe-3">Price:</span><span class="price">
									<?php echo $item['price']; ?> $
								</span>
							</div>
							<div class="row">

								<?php if (isset($_SESSION['user_id'])): ?>
									<form class="w-75 add-to-cart-form" data-product-id="<?php echo $item['id']; ?>"
										action="php/add-to-cart.php" method="post">
										<input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
										<button class="add-cart-button w-100" type="submit">Add to cart</button>
									</form>
								<?php else: ?>
									<div class="w-75 text-center text-danger">
										Login to add to cart
									</div>
								<?php endif; ?>

								<button class="info-button float-end rounded-circle" style="height: 35px; width: 35px"data-bs-toggle="modal"
									data-bs-target="#infoModal" data-description="<?php echo $item['description']; ?>"
									data-image="image/<?php echo $item['image']; ?>"
									data-product-id="<?php echo $item['id']; ?>">i</button>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>
</main>

<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="infoModalLabel">Product Info</h5>
			</div>
			<div class="modal-body" id="infoModalBody">
				<!-- Product info will be inserted here -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php' ?>

<script>
	document.querySelectorAll('.add-to-cart-form').forEach(form => {
		form.addEventListener('submit', function (event) {
			event.preventDefault();
			const formData = new FormData(form);
			const productId = form.getAttribute('data-product-id');
			formData.append('product_id', productId);
			fetch(form.action, {
				method: 'POST',
				body: formData
			}).then(response => {
				// Handle response as needed
			});
		});
	});

	document.querySelectorAll('.info-button').forEach(button => {
    button.addEventListener('click', function (event) {
        event.preventDefault();

        const productId = button.getAttribute('data-product-id');

        fetch(`php/get-images.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(images => {
            const title = button.closest('.card').querySelector('.card-title').textContent;
            const price = button.closest('.card').querySelector('.price').textContent;
            const description = button.getAttribute('data-description');

            let imageHtml = '';
            images.forEach((img, index) => {
                imageHtml += `
                <div class="mb-2 col-1">
                    <img class="img-thumbnail ${index === 0 ? 'img-selected' : ''} " src="../images/${img.image}" onclick="showSelectedImage(this)">
                </div>
            `;
            });

            document.getElementById('infoModalBody').innerHTML = `
            <h5>${title}</h5>
            <div id="selectedImageContainer">
                <img id="selectedImage" class="img-fluid" src="image/${images[0].image} col-6">
            </div>
            <div class="d-flex justify-content-start">
                ${imageHtml}
            </div>
            <p class="fw-bold">Description:</p>
            <p>${description}</p>
            <p class="fw-bold">Price:</p><p>${price}</p>
        `;

            const infoModal = new bootstrap.Modal(document.getElementById('infoModal'), {});
            infoModal.show();
        });
    });
});

function showSelectedImage(imgElement) {
    const selectedImage = document.querySelector('#selectedImage');
    if (imgElement) {
        selectedImage.src = imgElement.src;
        selectedImage.style.display = "block";
        document.querySelectorAll('.img-thumbnail').forEach(img => img.classList.remove('img-selected'));
        imgElement.classList.add('img-selected');
    } else {
        selectedImage.style.display = "none";
    }
}











</script>