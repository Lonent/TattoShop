<?php
include 'php/db.php';
session_start();

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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


	<title>TattoShop</title>
</head>

<body>

	<header class="sticky-top bg-white d-sm-flex col-11 h-auto">
		<a href="index.php" class="shop-name mb-auto my-sm-0">TattoShop</a>
		<div class="site-nav ms-auto ">
			<div class="d-flex">
				<a href="index.php" class="site-nav-category">shop</a>
				<a href="about.php" class="site-nav-category">about</a>
			</div>
			<?php if (isset($_SESSION['user_id'])) { ?>
				<div class="d-flex">
					<a href="cart.php" class="site-nav-category">cart</a>
					<a href="account.php" class="site-nav-category">account</a>
				</div>
			<?php } else { ?>
				<a href="sign-in.php" class="site-nav-category">sign in</a>
			<?php } ?>
		</div>
	</header>