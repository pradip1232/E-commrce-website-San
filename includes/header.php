<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/home.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/about.css">
    <link rel="stylesheet" type="text/css" href="assets/css/contact.css">
    <link rel="stylesheet" type="text/css" href="assets/css/product.css">
    <!-- <link rel="stylesheet" type="text/css" href="assets/css/product-details.css"> -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> -->

    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">

    <title>Sanjeevika</title>
    <link rel="icon" href="assets/images/header-logo.webp" type="image/png">




    <style>
        .carousel-indicators.custom {
            margin-top: 3rem;
        }

        .carousel-item {
            padding-bottom: 4rem;
            /* Adjust as needed for more/less space */
        }
    </style>

    <style>
        /* Custom CSS for the toggle icon change */


        .navbar-toggler.collapsed .navbar-toggler-icon::before {
            content: '\f00d';
            /* Unicode for FontAwesome 'times' icon */
            font-family: FontAwesome;
            font-size: 1.25rem;
        }

        @media (max-width: 767.98px) {
            .navbar-collapse {
                position: absolute;
                left: 0;
                width: 100%;
                z-index: 1000;
                /* background: rgba(255, 255, 255, 0.8); */
                /* backdrop-filter: blur(10px); */
                opacity: 5;
                /* width: 100vw; */
            }

            .navbar-nav.ml-auto {
                margin-top: 10px;
                /* Added margin to adjust spacing */
            }

            .wishlist-nav {
                display: flex;
                justify-content: flex-end;
                margin-top: 10px;
                /* Adjust this value as needed */
            }

            .wishlist-nav .nav-item {
                margin-right: 15px;
                /* Adjust spacing between items */
            }

            .navbar-toggler {
                margin-top: 10px;
                border: none;
            }
        }

        @media (min-width: 768px) {
            .wishlist-nav {
                display: none;
                /* Hide wishlist nav items on larger screens */
            }

            .navbar-collapse .wishlist-nav {
                display: flex;
                /* Show wishlist nav items within collapse on larger screens */
            }
        }
    </style>

    <!-- toggle cross icon  button  -->
    <style>
        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath stroke="rgba%280, 0, 0, 0.5%29" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/%3E%3C/svg%3E');
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,%3Csvg viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath stroke="rgba%280, 0, 0, 0.5%29" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M6 6l18 18M6 24L24 6"/%3E%3C/svg%3E');
        }
    </style>
    <style>
        .toothpas-images {
            /* width: 88px; */
            height: 251px;
            /* object-fit: cover;  */
        }

        .stip-row {
            padding: 0px !important;
        }

        .stip-row div {
            padding: 0px !important;
        }

        .welcome-container {
            box-shadow: 0px 4px 4px 0px #00000040;

        }

        .stip-row h7 {
            font-size: 16px;
        }

        .navbar-light .navbar-nav .nav-link {
            font-weight: bold;
            text-transform: uppercase;
        }

        .first-section-slider {
            margin-top: 8rem;
        }

        
        .first-section,
        .product-conatiner-page,
        .products-details-page,

        .about-us-first-section-container {
            margin-top: 185px;
        }

        .products-details-page,
        .wishlist-container-page {
            margin-top: 155px;
        }

        .logo-container {
            margin-top: 20px;

        }

        .navlink-container-r-search {
            margin-top: 32px;
        }

        .toggle-space-top-remove {
            background-color: white !important;
        }
    </style>


    <style>
        .modal-dialog-top-right {
            position: absolute;
            top: 0;
            right: 6rem;
            max-width: 450px !important;
            margin: 1rem;
            /* max-width: 100%; */
        }

        .modal-content {
            width: 100%;
            /* max-width: 400px; */
        }

        .quantity-controls {
            display: flex;
            align-items: center;
        }

        .quantity-controls input {
            width: 50px;
            text-align: center;
        }

        .subtotal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-top: 1px solid #e9ecef;
        }

        .buy-now {
            width: 100%;
            background-color: #77c712;
            color: white;
            font-weight: bold;
        }

        .goes-great-with {
            display: flex;
            overflow-x: scroll;
            padding: 10px 0;
            scroll-behavior: smooth;
            scrollbar-arrow-color: #77c712;
        }

        .product-wrapper {
            position: relative;
            margin-right: 10px;
            /* width: 100px; */
            /* height: 100px; */
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .wishlist-icon {
            position: absolute;
            top: 5px;
            right: 8px;
            display: none;
            color: red;
        }

        .product-wrapper:hover .wishlist-icon {
            display: block;
        }


        .goes-great-with img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            /* max-height: 100px;
            margin-right: 10px; */
        }
    </style>
    <style>
        .wishlist-notification {
            position: fixed;
            bottom: 25px;
            right: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
        }

        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 16px;
            z-index: 9999;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="w-100 to-strip ">
        <div class="welcome-container marquee-tag">
            <div class="row p-0 stip-row">
                <div class="col-lg-12 text-center">
                    <!-- <h7>Welcome to Sanjivka Store</h7> -->
                    <marquee width="50%" direction="right" class="marquee-tag">
                        Welcome to Sanjeevika Store
                    </marquee>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid p-0 toggle-space-top-remove ">
        <div class="row no-gutters w-100 fixed-top floter-header">
            <div class="col-2 d-flex align-items-center logo-container">
                <a class="navbar-brand" href="/">
                    <img src="assets/images/LOGO Support Useful links About Us Career Become An Instructor Become An Affiliate Lorem Ipsum is simply dummy text of the printing and typesetting industry 2.png" alt="Logo" class="header-logo header-logo-img-home">
                </a>
            </div>
            <div class="col-10 navlink-container-r-search">
                <nav class="navbar navbar-expand navbar-custom upperside-navbar-home navbar-light py-1 mt-4">
                    <div class="navbar-collapse" id="navbarNav1">
                        <form class="form-inline mx-auto d-none d-lg-block">
                            <div class="input-group search-container-home" style="width: 703px;">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search" style="background-color: #d9d9d9;">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: #77c712;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav ml-auto navbar-expand-lg navbar-light">
                            <li class="nav-item">
                                <a class="nav-link" href="my-wishlist">
                                    <i class="fas fa-heart" style="color: red;"></i>
                                    Wishlist
                                </a>
                            </li>
                            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                                <!-- User is logged in: Show Profile dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user-circle"></i> My Profile
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="user/my-profile">View Profile</a>
                                        <a class="dropdown-item" href="user/settings">Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout">Logout</a>
                                    </div>
                                </li>
                            <?php else: ?>
                                <!-- User is not logged in: Show Login link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="login">Login</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="#" data-toggle="modal" data-target="#cartModal">
                                    <i class="fas fa-shopping-cart ml-1"></i>
                                    <span class="shopping-cart-top-display" id="totalProductCount"> 0</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <nav class="navbar toggle-icon-left navbar-expand-lg navbar-light py-1 ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav2" aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav2">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item items-li-toggle-mobile-views">
                                <a class="nav-link text-dark" href="index">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="about-us">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="products">Health Care</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="products">Personal Care</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="products">Ayurvedic Medicines</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="contact-us">Contact Us</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link text-dark track-order" style="background-color: #77c712;" href="#">Track Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark track-home-icon" href="#"><i class="fas fa-home"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener("scroll", function() {
            var header = document.querySelector(".floter-header");
            var ll = document.querySelector(".logo-container");
            var nav = document.querySelector(".navlink-container-r-search");
            if (window.scrollY > 0) {
                header.style.backgroundColor = "white";
                header.style.boxShadow = "0 4px 2px -2px gray";
                nav.style.marginTop = "0px";
                ll.style.marginTop = "-10px";

            } else {
                header.style.backgroundColor = "transparent";
                header.style.boxShadow = "none";
                nav.style.marginTop = "32px";
                ll.style.marginTop = "20px";
            }
        });
    </script>

























    <!-- Shopping Cart Modal -->
    <div class="modal fade w-100" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top-right modal-top-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Table for product details -->
                    <div class="container-fluid">
                        <div class="row">
                            <!-- <div class="col-12 d-flex align-items-center">
                                <img src="https://via.placeholder.com/75" alt="product-images" class="mr-3">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <span>Jeevan Sanjeevani Kwath</span>
                                        <span class="price" data-price="425">₹425.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Size: 1000 ml | Pack of 1</span>
                                        <div class="quantity-controls">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(this, -1)">-</button>
                                            <input type="text" value="1" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-12 d-flex align-items-center mt-3">
                                <img src="https://via.placeholder.com/75" alt="product-images" class="mr-3">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <span>Chyawanprash Preservative Free</span>
                                        <span class="price" data-price="428">₹428.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Size: 500 g</span>
                                        <div class="quantity-controls">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(this, -1)">-</button>
                                            <input type="text" value="1" readonly>
                                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <span>Goes great with</span>
                                <div class="goes-great-with">
                                    <div class="product-wrapper">
                                        <img src="assets/images/samisha march 1.webp" alt="Product Image 2" class="product-image-w">
                                        <div class="wishlist-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </div>
                                    <div class="product-wrapper">
                                        <img src="assets/images/samisha march 3.webp" alt="Product Image 3" class="product-image-w">
                                        <div class="wishlist-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </div>
                                    <div class="product-wrapper">
                                        <img src="assets/images/samisha march 1.webp" alt="Product Image 4" class="product-image-w">
                                        <div class="wishlist-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </div>
                                    <div class="product-wrapper">
                                        <img src="assets/images/samisha march 4.webp" alt="Product Image 5" class="product-image-w">
                                        <div class="wishlist-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </div>
                                    <div class="product-wrapper">
                                        <img src="assets/images/samisha march 5 (1).webp" alt="Product Image 1" class="product-image-w">
                                        <div class="wishlist-icon">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row subtotal">
                            <div class="col-6">Subtotal</div>
                            <div class="col-6 text-right total-price">₹853.00</div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn buy-now">BUY NOW</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="my-cart" class="btn">View More</a>
                </div>
            </div>
        </div>
    </div>









    <script>
        function updateQuantity(button, increment) {
            var quantityInput = button.parentElement.querySelector('input');
            var quantity = parseInt(quantityInput.value) + increment;
            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;

            var priceCell = button.closest('.row').querySelector('.price');
            var pricePerUnit = parseFloat(priceCell.getAttribute('data-price'));
            priceCell.textContent = '₹' + (pricePerUnit * quantity).toFixed(2);

            updateTotalPrice();
        }

        function updateTotalPrice() {
            var totalPrice = 0;
            document.querySelectorAll('.price').forEach(function(priceCell) {
                totalPrice += parseFloat(priceCell.textContent.replace('₹', ''));
            });
            document.querySelector('.total-price').textContent = '₹' + totalPrice.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPrice();
        });
    </script>










    <!-- 

    <div>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="#" data-toggle="modal" data-target="#cartModal">
                <span class="shopping-cart-top-display">Cart</span>
                <span id="totalProductCount">0</span>
                <i class="fas fa-shopping-cart ml-1"></i>
            </a>
        </li>
    </div> -->