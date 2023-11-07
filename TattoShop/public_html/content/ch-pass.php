<?php

include 'header.php';
?>

<main>
	<div class="row mx-auto pb-5" style = "min-height: 43rem;">
		<div class=" col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto row  p-4 m-5" style="height: 27em;">
			<h3>Change Password</h3>
			<?php
			if (isset($_SESSION['password_change'])) {
				if ($_SESSION['password_change'] === 'invalid') {
					echo "<div class='alert alert-danger'>Invalid previous password.</div>";
				} elseif ($_SESSION['password_change'] === 'mismatch') {
					echo "<div class='alert alert-danger'>New passwords do not match.</div>";
				} elseif ($_SESSION['password_change'] === 'fill') {
					echo "<div class='alert alert-danger'>Please fill in all the fields.</div>";
				} elseif ($_SESSION['password_change'] === 'success') {
					echo "<div class='alert alert-success'>Password changed successfully.</div>";
				} elseif ($_SESSION['password_change'] === 'email_not_found') {
					echo "<div class='alert alert-danger'>Email not found.</div>";
				}
				unset($_SESSION['password_change']);
			}

			if (isset($_SESSION['password_change'])) {
				if ($_SESSION['password_change'] === 'invalid') {
					echo "<div class='alert alert-danger'>Invalid previous password.</div>";
				} elseif ($_SESSION['password_change'] === 'mismatch') {
					echo "<div class='alert alert-danger'>New passwords do not match.</div>";
				}
				unset($_SESSION['password_change']);
			}
			?>
			<form action="php/change-password.php" method="post">
				<?php if (isset($_SESSION['user_id'])): ?>
					<div class="form-group">
						<label for="previous_password">Previous password</label>
						<input type="password" name="previous_password" class="form-control" id="previous_password">
					</div>
				<?php else: ?>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" id="email" required>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="new_password">New Password</label>
					<input type="password" name="new_password" class="form-control" id="new_password" required>
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm password</label>
					<input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
				</div>
				<button type="submit" class="sign-btn w-100 ">Change</button>
			</form>
		</div>
	</div>
</main>

<?php include 'footer.php' ?>