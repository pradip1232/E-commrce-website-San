<?php
include('includes/header.php');

include "config/conn.php";
?>


<div class="container  products-details-page">
    <div class="container">
        <div class="row  text-center text-align-center">

            <h6 class=" ">Tags:</h6>
            <div class="d-flex flex-wrap mb-5"> hello
                <!-- <?php
                        // $selectedTags = json_decode($productDetails["selected_tags"], true);
                        // if (is_array($selectedTags)) {
                        //     foreach ($selectedTags as $tag) {
                        //         echo '<button class="btn btn-successss m-1" style="background-color:#E8E8E8; cursor:text; color:black;">' . htmlspecialchars($tag) . '</button>';
                        //     }
                        // }
                        ?> -->
            </div>
        </div>
    </div>



    <div class="row">
        <!-- Right Column with Image -->
        <div class="col-md-6 col-lg-6 col-sm-6 col-10 col-xs-8 position-relative">
            <!-- <img src="assets/images/Rectangle 5.png" alt="rectangle-border" class="img-fluid">
            <img src="assets/images/turmeric-power.png" alt="Image" class="individual-haldi-powder-one position-absolute" style="top: 50%; left:50%; transform: translate(-50%, -50%);"> -->
            <div class="row">
                <!-- Right Column for Large Main Image -->

                <div class="col-md-3 col-12  mt-3 mt-md-0">
                    <div class="row g-2">
                        <!-- Small Image Boxes -->
                        <div class="col-2 col-md-10">
                            <?php
                            // if (!empty($images)) {
                            //     foreach ($images as $image) {
                            //         $imagePath = $uploadedimgpath . $image;

                            //         if (file_exists($imagePath)) {
                            //             $escapedImagePath = htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8');
                            //             echo "<img src='$escapedImagePath' alt='Small Image' class='img-fluid small-image' onclick='swapImages(this)'>";
                            //         } else {
                            //             echo "⚠ Image not found: $imagePath<br>";
                            //         }
                            //     }
                            // } else {
                            //     echo "No images found.";
                            // }
                            ?>

                            <img src="assets/images/turmeric-power.png" alt="Small Image 1" class="img-fluid small-image" onclick="swapImages(this)">
                        </div>

                    </div>
                </div>


                <!-- Left Column for Small Image Thumbnails -->
                <div class="col-md-8 d-flex align-items-center justify-content-center ">
                    <img src="assets/images/Rectangle 5.png" alt="rectangle-border" class="img-fluid">

                    <?php
                    // if (!empty($images) && isset($images[0])) {
                    //     $mainImage = htmlspecialchars($uploadedimgpath . $images[0], ENT_QUOTES, 'UTF-8');
                    //     echo '<img id="main-image" src="' . $mainImage . '" alt="Main Image" class="img-fluid individual-haldi-powder-one position-absolute">';
                    // } else {
                    //     echo "No images found.";
                    // }
                    ?>
                    <img id="main-image" src="assets/images/turmeric-power.png" alt="Main Image" class="img-fluid individual-haldi-powder-one position-absolute">
                </div>

            </div>




        </div>


        <!-- Left Column -->
        <div class="col-md-6 col-lg-6 col-sm-6  ">
            <!-- Heading -->
            <h3 class="turmeric-heading-1"><?php echo $productDetails["product_name"] ?>
            </h3>
            <!-- Four Yellow Stars -->
            <div class="row">
                <div class="col">
                    <span class="star-icons">
                        <img src="assets/images/Star 1 (1).png" alt="" class="stat-top" />
                        <img src="assets/images/Star 1 (1).png" alt="" class="stat-top" />
                        <img src="assets/images/Star 1 (1).png" alt="" class="stat-top" />
                        <img src="assets/images/Star 1 (1).png" alt="" class="stat-top" />
                        <img src="assets/images/Star 1 (1).png" alt="" class="stat-top" />
                    </span>
                </div>
            </div>
            <!-- Two Buttons -->








            <!-- Quantity Counter HTML -->
            <!-- Quantity Counter HTML -->
            <div class="row">
                <div class="col">
                    <div class="counter-container-min-plus">
                        <button class="btn-minus btn">-</button>
                        <span class="quantity-display">1</span>
                        <button class="btn-plus btn">+</button>
                    </div>
                </div>
            </div>
            <!-- <p>Total Price: ₹<span class="selling-price-text">0.00</span></p> -->



            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let quantity = 1; // Default quantity
                    const pricePerUnit = parseFloat("<?php echo $minQuantityVariant ? $minQuantityVariant['sellingPrice'] : '0'; ?>"); // Price per unit from PHP
                    const priceDisplay = document.querySelector(".selling-price-text"); // Total price display element
                    const quantityDisplay = document.querySelector(".quantity-display"); // Quantity display element

                    // Initial price display update
                    updatePriceDisplay();

                    // Event listener for the "+" button
                    document.querySelector(".btn-plus").addEventListener("click", function() {
                        quantity++; // Increment quantity
                        quantityDisplay.textContent = quantity; // Update quantity display
                        updatePriceDisplay(); // Update price
                    });

                    // Event listener for the "-" button
                    document.querySelector(".btn-minus").addEventListener("click", function() {
                        if (quantity > 1) { // Ensure quantity does not go below 1
                            quantity--; // Decrement quantity
                            quantityDisplay.textContent = quantity; // Update quantity display
                            updatePriceDisplay(); // Update price
                        }
                    });

                    // Function to update the displayed price based on the current quantity
                    function updatePriceDisplay() {
                        const totalPrice = pricePerUnit * quantity; // Calculate total price
                        priceDisplay.textContent = totalPrice.toFixed(2); // Display total price with 2 decimal places
                    }
                });
            </script>



            <!-- <div class="row mt-3">
                <div class="col">

                    <button class="btn-button-one ">100gm</button>
                </div>
            </div> -->
            <!-- Heading 2 -->
            <!-- <p class="mrp-all-taxes mt-3">MRP (includes all taxes)</p> -->

            <!-- Price Icon -->
            <!-- <div class="row">
                <div class="col">
                    <span class="price-singn-top">&#8377;38.00</span>

                </div>
            </div> -->
            <!-- Plus/Minus Container -->

            <!-- Big Button -->
            <div>
                <div class="row mt-4">
                    <div class="col-10">
                        <button class="btn-add">ADD TO CART</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-10 text-startgreen-heart  d-flex ">


                        <?php
                        // session_start(); // Start the session

                        // Initialize email variable
                        $email = null;

                        // Check if email exists in session
                        if (isset($_SESSION['user_email'])) {
                            $email = $_SESSION['user_email'];
                        }
                        // Check if email exists in cookies
                        elseif (isset($_COOKIE['user_email'])) {
                            $email = $_COOKIE['user_email'];
                        }


                        $isLoggedIn = isset($_SESSION['loggedin']); // Check if user is logged in
                        // echo $isLoggedIn;
                        // Display the email if found in session or cookie
                        // if ($email) {
                        //     echo "User Email (from session or cookie): " . htmlspecialchars($email);
                        // } else {
                        //     echo "No email found in session or cookie.";
                        // }
                        ?>



                        <?php
                        // Debugging the productTax value
                        // if (isset($minQuantityVariant['productTax'])) {
                        //     echo "<pre>Debug: Product Tax Value: " . htmlspecialchars($minQuantityVariant['productTax']) . "</pre>";
                        // } else {
                        //     echo "<pre>Debug: productTax key does not exist or is null</pre>";
                        // }

                        // Determine the URL based on whether the user is logged in
                        if ($isLoggedIn) {
                            $emailEncoded = urlencode($email);
                            $price = urlencode($minQuantityVariant['sellingPrice']);
                            $tax = urlencode($minQuantityVariant['productTax']);

                            $buyNowUrl = "checkout?email={$emailEncoded}&price={$price}&tax={$tax}";
                        } else {
                            $buyNowUrl = "login";
                        }

                        // Output the URL for verification
                        // echo "<pre>Debug: Genera ted URL: " . htmlspecialchars($buyNowUrl) . "</pre>";
                        ?>



                        <button
                            class="btn-buy-now-top"
                            onclick="window.location.href='<?php echo $buyNowUrl; ?>'">
                            BUY NOW
                        </button>
                        <div class="green-heart-container ">
                            <img src="assets/images/Heart (2).png" alt="" class="green-heart ms-3" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <div class="row mt-4">
                <div class="col">
                    <div class="input-group delivering-serch-box-box-container">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0 p-0 m-0">
                                <img src="assets/images/Location.png" alt="location" />
                            </span>
                        </div>
                        <input type="text" class="form-control border-left-0 p-0 m-0 no-border-radius" placeholder="Enter delivery pincode">
                        <div class="input-group-append location-icon-containerr">
                            <span class="input-group-text border-left-0 no-border-radius" style="background-color: #77C712; color: #FFFFFF;">Check</span>
                        </div>

                    </div>
                </div>
            </div>


            <p class="text-start mb-3 mt-5 all-cross-india">Delivering all across India</p>
            <div class="row">
                <div class="col-2">
                    <div class="text-center">
                        <img src="assets/images/Location-check.png" alt="" class="free-shipping-img-1" />
                        <p class="free-shipping-elements-1">Free Shipping</p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="text-center">
                        <img src="assets/images/Lock.png" alt="" class="free-shipping-img-2" />
                        <p class="free-shipping-elements-2">Secure Payment</p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="text-center">
                        <img src="assets/images/Refresh.png" alt="" class="free-shipping-img-3" />
                        <p class="free-shipping-elements-3">Easy return </p>
                    </div>
                </div>
            </div>



        </div>
    </div>



</div>

<div class="container mt-3 pt-5 ">
    <h2 class="text-center key-benefits mb-3 pb-1">Key Benefit</h2>

    <!-- Row for the first six cards -->
    <div class="row card-wrapper">
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Anti-inflammatory</p>
            </div>
        </div>
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Rich in Antioxidants</p>
            </div>
        </div>
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Support Digestive Health</p>
            </div>
        </div>
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Boost Immunity</p>
            </div>
        </div>
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Support Digestive Health</p>
            </div>
        </div>
        <div class="card btn-anti" style="width: 18rem;">
            <div class="card-body">
                <p class="card-text">Boost Immunity</p>
            </div>
        </div>
    </div>
</div>





<section>
    <div class="container-fluid mt-5 pt-5">
        <div class="row top-spaces-for-navigation-nav p-0">
            <div class="col-12 p-0">
                <div class="card card-primary card-tabs product-details-tab card-size">
                    <div>
                        <ul class="nav nav-top justify-content-center custom-nav1" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item custom-li">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Product Description</a>
                            </li>
                            <li class="nav-item custom-li">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Benefits</a>
                            </li>
                            <li class="nav-item custom-li">
                                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Usage</a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body container text-center card-body-sizes">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <!-- Product Description Tab -->
                            <div class="tab-pane fade show active width-navigation-paragraph" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <p class="centered-paragraph">
                                    Our product is a state-of-the-art solution designed to enhance your daily life with unparalleled efficiency and reliability. Crafted from high-quality materials, it ensures durability and longevity, providing exceptional value for your investment. With a sleek design and user-friendly interface, this product seamlessly integrates into any environment, offering both functionality and aesthetic appeal.
                                </p>
                            </div>
                            <!-- Benefits Tab -->
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                <p class="centered-paragraph">
                                    The benefits of using our product are numerous. It boosts productivity by streamlining tasks and minimizing downtime. Its innovative features are designed to adapt to your specific needs, making your operations more efficient. Furthermore, the product's intuitive design ensures a hassle-free user experience, reducing the learning curve and allowing you to achieve optimal results quickly.
                                </p>
                            </div>
                            <!-- Usage Tab -->
                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                <p class="centered-paragraph">
                                    To use the product, simply follow these easy steps: first, ensure it is properly assembled and all components are securely in place. Next, activate the device by pressing the power button. Refer to the included manual for specific settings and configurations tailored to your requirements. Regular maintenance, as outlined in the user guide, will ensure the product remains in peak condition, delivering consistent performance over time.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<?php
include('includes/footer.php');

?>