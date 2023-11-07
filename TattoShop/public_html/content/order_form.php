<?php include 'header.php';
$total_price = $_POST['total_price'];
$user_id = $_POST['user_id'];
?>

<main>
	<div class="row mx-auto h-100 pb-5">
		<div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row p-4 m-5" style="height: 27em;">
			<h3>Submit Order Details</h3>
			<label class="pass-missmatch col-4 text-center ms-2 my-auto rounded" style="display:none">Password
				missmatch!</label>
			<form method="POST" action="php/create_order.php">
				<div class="form-group">
					<label for="exampleFormControlInput1">Delivery Address</label>
					<input type="text" class="form-control" id="exampleFormControlInput1" name="address"
						placeholder="Address">
				</div>
				<div class="form-group">
					<label for="postcode">Postcode</label>
					<input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode"
						required>
				</div>

				<div class="form-group">
					<label for="cardNumber">Card Number</label>
					<input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Card Number"
						required>
				</div>
				<div class="row">
					<div class="form-group col">
						<label for="cvc">CVC</label>
						<input type="password" class="form-control" id="cvc" name="cvc" placeholder="CVC" required>
					</div>

					<div class="form-group col">
						<label for="expiration">Expiration</label>
						<input type="text" class="form-control" id="expiration" name="expiration" placeholder="MM/YY"
							required>
					</div>
				</div>
				<input type="hidden" name="user_id" value='<?= $user_id ?>'>
				<input type="hidden" name="total_price" value='<?= $total_price ?>'>
				<button type="submit" class="sign-btn w-100 mt-2">Submit</button>
			</form>
		</div>

	</div>
</main>

<script src="https://unpkg.com/imask"></script>
<script>
    $(document).ready(function () {
        $('#postcode').mask('000000000000');
        $('#cardNumber').mask('0000 0000 0000 0000');
        $('#cvc').mask('000');
        
        var ExpirationMask = IMask(
            document.getElementById('expiration'), {
            mask: 'MM{/}YY',
            lazy: false,  
            blocks: {
                MM: {
                    mask: IMask.MaskedRange,
                    from: 1,
                    to: 12
                },
                YY: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 99
                }
            }
        });
    });
</script>




<?php include 'footer.php' ?>