<?php
session_start(); // Start the session

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to sign-in.php
    header('Location: sign-in.php');
    exit;
}
?>

<?php include 'header.php' ?>

<main style="height:33em">
	<div class="container-fluid ">
		<div class="row mx-auto d-block mt-5 col-8 col-sm-7 col-md-5 col-lg-5 col-xl-3">
			<h3 class="text-center">Account</h3>
			<form action="orders.php" class=" mt-4 col-12">
				<button type="submit" class="sign-btn w-100">Check Order's</button>
			</form>
			<form action="ch-pass.php" class="">
				<button type="submit" class="sign-btn w-100 font-weight-bold">Change Password</button>
			</form>
			<form action="php/sign-out.php" class="">
				<button type="submit" class="sign-btn w-100 font-weight-bold">Sign out</button>
			</form>
		</div>
	</div>

</main>
<?php include 'footer.php' ?>