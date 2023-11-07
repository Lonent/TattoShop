<?php include 'header.php' ;
$user_id = $_SESSION['user_id'];

?>
<main>
	<div class=" col-11 mx-auto pb-5 sign-in-cont d-xl-flex">
		<div class="col-11 col-xl-5 mx-auto pt-lg-4 mx-auto row pt-4">
			<h3>Active Orders</h3>
			<ul class=" order-list list-group mb-2 mt-2 prod-scroll-box pr-5" tabindex="0">
				<?php
				$stmt = $dbh->prepare("
						SELECT id, date, status
						FROM orders
						WHERE status NOT IN ('completed', 'canceled') AND user_id = ?;
					");
					$stmt->execute([$user_id]);
				$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($orders as $order):
					?>
					<li
						class="order-list-row border border-dark mb-2 mt-2 col-12 mx-0 d-inline-flex justify-content-betwen">
						<div class=" col-10 col-md-9 d-md-flex">
							<div class="order-date ms-2 col-11 col-md-7 ">
								<div class="fw-bold">Order Date</div>
								<div class="">
									<?php echo $order['date']; ?>
								</div>
							</div>
							<div class="d-flex col-12 col-md-5 mt-2 mt-md-0">
								<div class=" ms-2 ms-md-0 col-6 col-md-7 ">
									<div class="fw-bold">Order ID</div>
									<div class="order-id">
										<?php echo $order['id']; ?>
									</div>
								</div>
								<div class="col-2 col-md-5">
									<div class="fw-bold">Status</div>
									<div class="status">
										<?php echo $order['status']; ?>
									</div>
								</div>
							</div>
						</div>
						<form action="" method="post" class="h-100 col-2 col-md-1 ms-auto">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
							<button type="button" class="show-btn w-100 h-100 my-0 pt-1" data-toggle="modal"
								data-target="#orderDetailsModal" data-order-id="<?php echo $order['id']; ?>">
								<i class="fa fa-arrow-right" aria-hidden="true"></i>
							</button>

						</form>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="col-11 col-xl-5 mx-auto pt-lg-4 mx-auto row pt-4">
			<h3>Inactive Orders</h3>
			<ul class="order-list list-group mb-2 mt-2 prod-scroll-box pr-5" tabindex="0">
				<?php
				$stmt = $dbh->prepare("
				SELECT id, date, status
				FROM orders
				WHERE status IN ('completed', 'canceled') AND user_id = ?
				ORDER BY FIELD(status, 'completed', 'canceled')
			");

				$stmt->execute([$user_id]);
				$orders = $stmt->fetchAll(PDO::FETCH_ASSOC); foreach ($orders as $order):
					?>
					<li
						class=" order-list-row border border-dark mb-2 mt-2 col-12 mx-0 d-inline-flex justify-content-betwen ">
						<div class=" col-10 col-md-9 d-md-flex">
							<div class="order-date ms-2 col-11 col-md-7 ">
								<div class="fw-bold">Order Date</div>
								<div class="">
									<?php echo $order['date']; ?>
								</div>
							</div>
							<div class="d-flex col-12 col-md-5 mt-2 mt-md-0">
								<div class=" ms-2 ms-md-0 col-6 col-md-7 ">
									<div class="fw-bold">Order ID</div>
									<div class="order-id">
										<?php echo $order['id']; ?>
									</div>
								</div>
								<div class="col-2 col-md-5">
									<div class="fw-bold">Status</div>
									<div class="status">
										<?php echo $order['status']; ?>
									</div>
								</div>
							</div>
						</div>
						<form action="" method="post" class="h-100 col-2 col-md-1 ms-auto">
							<input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
							<button type="button" class="show-btn w-100 h-100 my-0 pt-1" data-toggle="modal"
								data-target="#orderDetailsModal" data-order-id="<?php echo $order['id']; ?>">
								<i class="fa fa-arrow-right" aria-hidden="true"></i>
							</button>
						</form>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</main>
<?php include 'footer.php' ?>
<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document"	>
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
				
			</div>
			<div class="modal-body">
				<!-- Order details will be loaded here -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#orderDetailsModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var orderId = button.data('order-id');
			var modal = $(this);

			// Fetch order details
			$.ajax({
				url: 'php/get-order-details.php',
				method: 'POST',
				data: { order_id: orderId },
				success: function (response) {
					// Add the order details to the modal body
					modal.find('.modal-body').html(response);
				},
				error: function () {
					alert('Error fetching order details');
				}
			});
		});
	});
</script>