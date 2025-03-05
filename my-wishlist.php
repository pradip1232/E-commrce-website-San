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
            <div class="cart-item d-md-flex justify-content-between">
                <span class="remove-item">
                    <i class="fa fa-times remove-btn"></i>
                </span>
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

            <div class="cart-item d-md-flex justify-content-between">
                <span class="remove-item">
                    <i class="fa fa-times remove-btn"></i>
                </span>
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

<div class="cart-item d-md-flex justify-content-between">
    <span class="remove-item">
        <i class="fa fa-times remove-btn"></i>
    </span>
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

        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all remove buttons
        const removeButtons = document.querySelectorAll('.remove-btn');

        // Iterate over each remove button
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Find the parent cart item
                const cartItem = this.closest('.cart-item');
                // Remove the cart item from the DOM
                if (cartItem) {
                    cartItem.remove();
                }
            });
        });
    });
</script>





<?php
// Start the session

// Assuming the user's email is saved in the session
$user_email = $_SESSION['user_email'];

// Database connection
include 'config/conn.php'; // Your database connection file

// Prepare the SQL query
$sql = "SELECT `id`, `user_email`, `product_id`, `sku_id`, `added_at` FROM `wishlist` WHERE `user_email` = '$user_email'";

// Execute the query
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        // print_r($row);
    }
} else {
    echo "No items found in your wishlist.";
}

mysqli_close($conn);
?>







<?php
include('includes/footer.php');
?>