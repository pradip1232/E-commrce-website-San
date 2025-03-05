<?php
include('includes/header.php');
?>
<link rel="stylesheet" type="text/css" href="assets/css/wishlist.css">






<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container wishlist-container-page">
    <div class="row">

        <!-- Wishlist-->
        <div class="col-lg-10 pb-5">
            <!-- Item-->
            <div class="cart-item d-md-flex justify-content-between" onclick="window.location.href='product-details'"><span class="remove-item"><i class="fa fa-times"></i></span>
                <div class="px-3 my-3">
                    <a class="cart-item-product" href="#">
                        <div class="cart-item-product-thumb"><img src="" alt="Product"></div>
                        <div class="cart-item-product-info">
                            <h4 class="cart-item-product-title">Canon EOS M50 Mirrorless Camera</h4>
                            <div class="text-lg text-body font-weight-medium pb-1">₹910.00</div><span>Availability: <span class="text-success font-weight-medium">In Stock</span></span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Item-->
            <div class="cart-item d-md-flex justify-content-between"><span class="remove-item"><i class="fa fa-times"></i></span>
                <div class="px-3 my-3">
                    <a class="cart-item-product" href="#">
                        <div class="cart-item-product-thumb"><img src="" alt="Product"></div>
                        <div class="cart-item-product-info">
                            <h4 class="cart-item-product-title">Apple iPhone X 256 GB Space Gray</h4>
                            <div class="text-lg text-body font-weight-medium pb-1">₹1,450.00</div><span>Availability: <span class="text-warning font-weight-medium">2 - 3 Weeks</span></span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Item-->
            <div class="cart-item d-md-flex justify-content-between"><span class="remove-item"><i class="fa fa-times"></i></span>
                <div class="px-3 my-3">
                    <a class="cart-item-product" href="#">
                        <div class="cart-item-product-thumb"><img src="" alt="Product"></div>
                        <div class="cart-item-product-info">
                            <h4 class="cart-item-product-title">HP LaserJet Pro Laser Printer</h4>
                            <div class="text-lg text-body font-weight-medium pb-1">₹188.50</div><span>Availability: <span class="text-success font-weight-medium">In Stock</span></span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" checked="" id="inform-me">
                <label class="custom-control-label" for="inform-me">Inform me when item from my wishlist is available</label>
            </div> -->
        </div>
    </div>
</div>














<?php
include('includes/footer.php');
?>