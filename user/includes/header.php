<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Sanjeevika</title>
	<link rel="icon" href="assets/img/logo.webp" type="image/png">

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		name='viewport' />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="assets/css/ready.css">
	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome CSS (optional) -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<!-- Popper.js -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		.btn-primary-search {
			background-color: #77c712;
			color: white;
		}

		.dashbaord-images-logo {

			height: 64px;
			max-width: 100%;
			margin: 0 auto;

		}



		.nav-item.active {
			background-color: #77c712;
			color: #fff;
		}

		.nav-item.active a,
		.nav-item.active i {
			color: #fff;
		}


		.main-panel {
			background-color: white;
		}
	</style>

	<style>
		#buySelectedBtn {
			/* position: fixed; */
			top: 10px;
			right: 10px;
			z-index: 1000;
		}

		.button-and-search {
			display: flex !important;
			justify-content: flex-end;
			flex-wrap: nowrap;
		}





		/* Notification Style */
		.notification {
			position: fixed;
			top: 60px;
			right: 20px;
			background-color: #77c712;
			/* Red */
			color: white;
			padding: 10px;
			border-radius: 5px;
			font-size: 16px;
			z-index: 9999;
			opacity: 0;
			transition: opacity 0.5s ease;
		}

		/* Visible state */
		.notification.show {
			opacity: 1;
		}
	</style>

	<style>
		/* Dropdown Styling */
		.filter-dropdown {
			transition: all 0.3s ease-in-out;
			border: 2px solid #ddd;
			border-radius: 5px;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
		}

		.filter-dropdown:focus {
			outline: none;
			border-color: #007bff;
			box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
		}

		.filter-dropdown:hover {
			transform: scale(1.02);
			border-color: #007bff;
		}

		/* Notification Box Styling */
		.notification-box {
			display: none;
			position: fixed;
			top: 10px;
			right: 10px;
			background-color: #ff4444;
			color: #fff;
			padding: 10px 15px;
			border-radius: 5px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
			animation: slideInRight 0.5s ease forwards;
		}

		.notification-box.show {
			display: block;
		}

		/* Animation for Notification */
		@keyframes slideInRight {
			from {
				opacity: 0;
				transform: translateX(100%);
			}

			to {
				opacity: 1;
				transform: translateX(0);
			}
		}
	</style>


</head>

<body>
	<div class="wrapper">