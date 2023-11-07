<?php include 'header.php' ?>
<main>
	<div class="row mx-auto h-100 pb-5" action="">
		<div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row p-4 m-5" style="height: 27em;">
			<h3>Register</h3>
			<label class="pass-missmatch col-4 text-center ms-2 my-auto rounded" style="display:none">Password missmatch!</label>
			<form method="POST" action="php/mail.php" onsubmit="return checkPasswords()">
				<div class="form-group">
					<label for="exampleFormControlInput1">Email address</label>
					<input type="email" class="form-control" id="exampleFormControlInput1" name="email"
						placeholder="name@example.com">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" name="password"
						placeholder="Password">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Confirm password</label>
					<div class="d-md-flex">
						<input type="password" class="form-control" id="exampleInputPassword2" name="confirm_password" placeholder="Password" oninput="checkPasswords()">
						
					</div>
				</div>
				<button type="submit" class="sign-btn w-100 mt-2">Sign up</button>
			</form>
		</div>
		
	</div>
</main>
<script>
function checkPasswords() {
  var pass1 = document.getElementById("exampleInputPassword1").value;
  var pass2 = document.getElementById("exampleInputPassword2").value;
  var label = document.querySelector(".pass-missmatch");
  if (pass1 != pass2) {
    label.style.display = "block";
    return false;
  } else {
    label.style.display = "none";
    return true;
  }
}
</script>
<?php include 'footer.php' ?>
