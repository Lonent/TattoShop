<?php 
include 'header.php';
include 'php/db.php';
// Check if user is not logged in
if (isset($_SESSION['admin_id'])) {
    // Redirect to products.php
    header('Location: products.php');
    exit;
}
?>
<main>
	<div class="row mx-auto h-100 pb-5" action="">
		<div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row p-4 m-5" style="height: 27em;">
			<h3>Admin Panel Enter</h3>
			<form method="POST" action="php/log-in.php">
				<div class="form-group">
					<label for="exampleFormControlInput1">Login</label>
					<input type="text" class="form-control" id="exampleFormControlInput1" name="login"
						placeholder="Login">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" name="password"
						placeholder="Password">
				</div>
				<button type="submit" class="sign-btn w-100 mt-2">Sign in</button>
			</form>
		</div>
	</div>
</main>

