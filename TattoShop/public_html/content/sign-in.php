
<?php include 'header.php' ?>
<?php

// Check if user is not logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to sign-in.php
    header('Location: index.php');
    exit;
}
?>
<main>
	<div class=" col-10 mx-auto pb-5 sign-in-cont d-lg-flex" style="min-height: 36em;">
		<div class="col-10 col-sm-10 col-md-10 col-lg-5 row mx-auto pt-4" style="height: 27em;">
			<h3>Log in to your account</h3>
			<form method="POST" action="php/log-in.php" class=" row h-75"	>
				<div class="form-group px-0">
					<label for="exampleFormControlInput1">Email address</label>
					<input type="email" class="form-control" id="exampleFormControlInput1" name="email"
						placeholder="name@example.com">
				</div>
				<div class="form-group px-0">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" name="password"
						placeholder="Password">
				</div>
				<a href="ch-pass.php" class="">Forget password?</a>
				<button type="submit" name="submit" class="sign-btn w-100 ">Sign in</button>
			</form>
		</div>
		<div class=" col-10 col-sm-10 col-md-10 col-lg-5 col-xl-4 mx-auto pt-lg-4 row" style="height:15em">
			<h3>Need an account?</h3>
			<form action="sign-up.php" class="h-25">
				<button type="submit" class="sign-btn w-100 ">Sign up</button>
			</form>
		</div>
	</div>
</main>
<?php include 'footer.php' ?>