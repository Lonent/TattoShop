<?php
include 'php/db.php';
session_start();

if (isset($_GET['signout'])) {
	// Reset the admin session
	$_SESSION['admin_id'] = null;
	// Redirect to the home page or the desired location
	header('Location: index.php');
	exit;
}
	?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/4710cb486e.js" crossorigin="anonymous"></script>
	<script src="js/script.js" crossorigin="anonymous"></script>


	<!-- jQuery and Bootstrap JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>




	<title>Unknown</title>
</head>

<body>

	<header class="sticky-top bg-white d-flex col-12 col-md-11 mx-auto">
		<span class="admin-name ms-2">TattoShop Admin Panel</span>
		<?php if (isset($_SESSION['admin_id'])) { ?>
			<div class="dropstart ms-auto me-3 me-md-5">
				<button type="button" class="dropdown-toggle-no-arrow border-2 rounded-3" data-bs-toggle="dropdown"
					aria-expanded="false">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</button>

				<ul class="dropdown-menu col-8">
					<li><a class="dropdown-item" href="products.php">Products</a></li>
					<li><a class="dropdown-item" href="orders.php">Orders</a></li>
					<li><a class="dropdown-item" href="add-admin.php">Add Admin</a></li>
					<li><a class="dropdown-item" href="?signout=true">Sign Out</a></li>
				</ul>

			</div>
		<?php } ?>


	</header>