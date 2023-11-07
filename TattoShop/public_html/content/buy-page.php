<?php include 'header.php' ?>
<?php

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in.php
    header('Location: sign-in.php');
    exit;
}
?>
<main>
	<div class="row mx-auto h-100 pb-5">
		<div class=" col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row  p-4 m-5" style="height: 27em;">
			<h3>Change Password</h3>
			<div class="form-group">
				<label for="exampleInputPassword1">Full Name</label>
				<input type="text" class="form-control" id="">
			</div>
			<div class="form-group ">
				<label for="exampleInputPassword1">ID</label>
				<div class="d-flex">
					<input type="text" class="form-control" id="">
				</div>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Country</label>
				<input type="text" class="form-control" id="">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Index</label>
				<input type="text" class="form-control" id="">
			</div>
			<div class="form-group pb-3">
				<label for="exampleInputPassword1">Adress</label>
				<input type="text" class="form-control" id="">
			</div>
			<form class="h-25">
				<button type="submit" class="sign-btn w-100 ">Change</button>
			</form>
		</div>
	</div>
</main>
<?php include 'footer.php' ?>