<?php
include('includes/header.php');

include "config/conn.php";
?>
<link rel="stylesheet" type="text/css" href="assets/css/product-details.css">


<style>
    .btn-anti {
        width: 240px;
        height: 38px;
        /* background-color: #77C712; */
        /* color: white; */
        border: none;
        cursor: text;
        background-color: #E8E8E8;
    }

    .overlay-text {
        position: absolute;
        top: 10px;
        left: 10px;
        color: black;
        /* background: rgba(0, 0, 0, 0.5); */
        /* Optional: To make text more readable */
        padding: 10px;
    }

    .position-relative-container {
        position: relative;
    }
</style>
<style>
    .text-dark a {
        text-decoration: none;
    }

    .custom-nav .nav-item {
        margin-right: 12rem;
        /* Adjust this value as needed */
    }

    .nav-top {
        margin-bottom: 2rem;
        gap: 14rem;
        /* Increase the gap between tabs and content */
    }

    .nav-link {
        color: #001026;
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #001026;
        left: 50%;
        bottom: -5px;
        transition: width 0.3s ease, left 0.3s ease;
    }

    .nav-link.active::after {
        width: 100%;
        left: 0;
    }
</style>

<!-- heeader -->
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
            background: rgba(255, 255, 255, 0.8);
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
<!--  -->



<style>
    .variant-detail {
        /* font-size: 1.2em; */
        /* color: #333; */
    }

    .discount-text {
        /* font-weight: bold; */
        font-size: 16px;
        color: red;


    }

    .selling-price-text {
        /* font-weight: bold; */
        /* font-size: 1.3em; */
        /* color: #4caf50; */
        /* Green color for selling price */
    }


    .mrp-price {
        text-decoration: line-through;
    }
</style>

<div class="container  products-details-page">


    <?php
    // $s = isset($_GET['sku']) ? $_GET['sku'] : '';
    
$product_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($product_id)) {
    die(json_encode(["success" => false, "message" => "Product ID is required."]));
}

// echo "Product ID: " . htmlspecialchars($product_id) . "<br>";

$sql = "SELECT * FROM products WHERE product_id = '$product_id'";
$result = $conn->query($sql);

$productDetails = $result->fetch_assoc();


// print_r($productDetails);

// Prepare SQL query (select only necessary columns)
// $sql = "SELECT * FROM products_new WHERE product_id = ?";

// $stmt = $conn->prepare($sql);
// if (!$stmt) {
//     die("SQL Error: " . $conn->error);
// }

// // Bind parameters
// $stmt->bind_param("s", $a);
// $stmt->execute();

// // Bind result variables
// $stmt->bind_result($id, $product_name, $sku, $product_id, $category, $description,$key_benefits,$selected_tags,$variants);

// // Fetch data
// $productDetails = [];
// if ($stmt->fetch()) {
//     $productDetails = [
//         "id" => $id,
//         "product_name" => $product_name,
//         "sku" => $sku,
//         "product_id" => $product_id,
//         "category" => $category,
//         "description" => $description ,
//         "key_benefits" => $key_benefits ,
//         "selected_tags" => $selected_tags ,
//         "variants" => $variants ,
//         ];
       
// } else {
//     die("No product found with this ID.");
// }




    // Key Benefits
    // echo "<h3>Key Benefits:</h3>";
    $keyBenefits = json_decode($productDetails["key_benefits"], true);
    if (is_array($keyBenefits)) {
        foreach ($keyBenefits as $benefit) {
            // echo "- " . htmlspecialchars($benefit) . "<br>";
        }
    }

    // Selected Tags
    // echo "<h3>Selected Tags:</h3>";
    $selectedTags = json_decode($productDetails["selected_tags"], true);
    if (is_array($selectedTags)) {
        foreach ($selectedTags as $tag) {
            // echo "- " . htmlspecialchars($tag) . "<br>";
        }
    }

    // Variants
    // echo "<h3>Variants:</h3>";
    $variants = json_decode($productDetails["variants"], true);
    if (is_array($variants)) {
        foreach ($variants as $variant) {
            if (is_array($variant)) {
                foreach ($variant as $key => $value) {
                    // echo "- " . htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
                }
            } else {
                // If the variant is a simple string, display it directly
                // echo "- " . htmlspecialchars($variant) . "<br>";
            }
        }
    } else {
        // echo "No variants available.<br>";
    }



    // print_r($productDetails);
    // Close the statement and connection
    // $stmt->close();
    // $conn->close();
    ?>



    <div class="container">
        <div class="row  text-center text-align-center">

            <h6 class=" ">Tags:</h6>
            <div class="d-flex flex-wrap mb-5">
                <?php
                $selectedTags = json_decode($productDetails["selected_tags"], true);
                if (is_array($selectedTags)) {
                    foreach ($selectedTags as $tag) {
                        echo '<button class="btn btn-successss m-1" style="background-color:#E8E8E8; cursor:text; color:black;">' . htmlspecialchars($tag) . '</button>';
                    }
                }
                ?>
            </div>
        </div>
    </div>


<?php
$uploadedimgpath = 'admin/config/uploads/';
$imageString = $productDetails['image_paths']; 

$imageString = trim($imageString, '"'); 
$images = array_map('trim', explode(',', $imageString)); // Split and trim

// echo "<pre>";
// print_r($images);
// echo "</pre>";

// if (!empty($images)) {
//     foreach ($images as $image) {
//         $imagePath = $uploadedimgpath . $image;
//         if (file_exists($imagePath)) {
//             echo "<img src='$imagePath' alt='Product Image' style='max-width: 300px; height: auto;'><br>";
//         } else {
//             echo "⚠ Image not found: $imagePath<br>";
//         }
//     }
// } else {
//     echo "No images found.";
// }
?>


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
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    $imagePath = $uploadedimgpath . $image;
                            
                                    if (file_exists($imagePath)) {
                                        $escapedImagePath = htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8');
                                        echo "<img src='$escapedImagePath' alt='Small Image' class='img-fluid small-image' onclick='swapImages(this)'>";
                                    } else {
                                        echo "⚠ Image not found: $imagePath<br>";
                                    }
                                }
                            } else {
                                echo "No images found.";
                            }
                            ?>

                            <!--<img src="assets/images/turmeric-power.png" alt="Small Image 1" class="img-fluid small-image" onclick="swapImages(this)">-->
                        </div>
                        <!--<div class="col-2 col-md-10">-->
                        <!--    <img src="assets/images/turmeric-power.png" alt="Small Image 2" class="img-fluid small-image" onclick="swapImages(this)">-->
                        <!--</div>-->
                        <!--<div class="col-2 col-md-10">-->
                        <!--    <img src="assets/images/10 2.png" alt="Small Image 3" class="img-fluid small-image" onclick="swapImages(this)">-->
                        <!--</div>-->
                        <!--<div class="col-2 col-md-10">-->
                        <!--    <img src="assets/images/11 5 (1).webp" alt="Small Image 4" class="img-fluid small-image" onclick="swapImages(this)">-->
                        <!--</div>-->
                        <!--<div class="col-2 col-md-10">-->
                        <!--    <img src="assets/images/10 2.webp" alt="Small Image 5" class="img-fluid small-image" onclick="swapImages(this)">-->
                        <!--</div>-->
                    </div>
                </div>


                <!-- Left Column for Small Image Thumbnails -->
                <div class="col-md-8 d-flex align-items-center justify-content-center ">
                    <img src="assets/images/Rectangle 5.png" alt="rectangle-border" class="img-fluid">
                    
                   <?php
                    if (!empty($images) && isset($images[0])) {
                        $mainImage = htmlspecialchars($uploadedimgpath . $images[0], ENT_QUOTES, 'UTF-8');
                        echo '<img id="main-image" src="' . $mainImage . '" alt="Main Image" class="img-fluid individual-haldi-powder-one position-absolute">';
                    } else {
                        echo "No images found.";
                    }
                    ?>
                    <!--<img id="main-image" src="assets/images/turmeric-power.png" alt="Main Image" class="img-fluid individual-haldi-powder-one position-absolute">-->
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





            <?php
            $variants = json_decode($productDetails["variants"], true);
            // print_r($variants);
            
            if (is_array($variants)) {
                $minQuantity = PHP_INT_MAX; 
                $minQuantityVariant = null;
            
                foreach ($variants as $variant) {
                    if (is_array($variant)) {
                        preg_match('/\d+/', $variant["quantity"], $matches);
                        $quantityValue = isset($matches[0]) ? intval($matches[0]) : PHP_INT_MAX;
            
                        if ($quantityValue < $minQuantity) {
                            $minQuantity = $quantityValue;
                            $minQuantityVariant = $variant;
                        }
                    }
                }
            
                // echo "Variant with the lowest quantity: ";
                // print_r($minQuantityVariant);


                if ($minQuantityVariant) {
                    echo '<div class="row mt-3">
                        <div class="col">
                         <button class="btn-button-one">' . htmlspecialchars($minQuantityVariant["quantity"]) . '</button>
                            <p class="variant-detail mrp-price"> M.R.P ₹' . htmlspecialchars($minQuantityVariant["price"]) . '</p>
                            <p class="variant-detail price-singn-top"> ' . '<span class="discount-text">' . htmlspecialchars($minQuantityVariant["discount"]) . '%' . '</span>' . ' ₹<span class="selling-price-text price-singn-top">' . htmlspecialchars($minQuantityVariant["sellingPrice"]) . '</span></p>
                            
                            <p class="variant-detail ">' . htmlspecialchars($minQuantityVariant["productTax"]) . '</p>
                        </div>
                    </div>';
                }
            } else {
                echo "No variants available.<br>";
            }
            ?>



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









<style>
    .card-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .card {
        flex: 0 0 22%;
        margin-bottom: 10px;
        padding: 8px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .card-img-top {
        height: 150px;
        object-fit: cover;
    }

    .card {
        height: 100%;
    }
</style>




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















<!-- 

<section>
    <div class="container mt-5 pt-5">
        <h2 class="text-center key-benefits">Key Benefit</h2>

        <div class="row justify-content-center mt-3 pt-3">
            <div class="col-lg-12 text-center">
                <div class="btn-group">
                    <button type="button" class="btn-anti me-4 anti-btn-1">Anti-inflammatory</button>
                    <button type="button" class="btn-anti me-4 anti-btn-2">Rich in Antioxidants</button>
                    <button type="button" class="btn-anti me-4 anti-btn-3">Support Digestive Health</button>
                    <button type="button" class="btn-anti me-4 anti-btn-4">Boost Immunity</button>
                    <button type="button" class="btn-anti me-4 anti-btn-3">Support Digestive Health</button>
                    <button type="button" class="btn-anti me-4 anti-btn-4">Boost Immunity</button>
                    <button type="button" class="btn-anti me-4 anti-btn-3">Support Digestive Health</button>
                    <button type="button" class="btn-anti anti-btn-4">Boost Immunity</button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-2 pt-2">
            <div class="col-3 mb-2">
                <button type="button" class="btn-anti btn-block anti-btn-5">Promotes Skin Health</button>
            </div>
            <div class="col-3 mb-2">
                <button type="button" class="btn-anti btn-block anti-btn-6">Support Brain Function</button>
            </div>
        </div>
    </div>
</section> -->




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

<style>
    /* Custom styles for mobile responsiveness */
    .card-body-sizes {
        padding: 1rem;
    }

    .centered-paragraph {
        text-align: center;
    }

    .width-navigation-paragraph {
        max-width: 100%;
        word-wrap: break-word;
    }

    @media (max-width: 576px) {
        .nav-top {
            /* flex-direction: column; */
            gap: 0px;
        }

        .nav-item {
            width: 100%;
            text-align: center;
        }

        .custom-nav1 .nav-link {
            width: 100%;
        }

        .card-size {
            margin: 0;
        }
    }
</style>
<section>
    <h2 class="mt-5 pt-5 text-center discover-customer-powder pb-2 mb-3">
        Discover why customers rave about our Turmeric (Haldi) Powder! Here's what they're saying
    </h2>
    <div id="myCarousel" class="carousel slide container" data-bs-ride="carousel">
        <!-- Reviews buttons container above carousel items -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn-ten-reviews" type="button">10 Reviews</button>
            <button class="btn-write-reviews mr-4 " type="button">WRITE A REVIEW</button>
        </div>

        <div class="carousel-inner w-100">
            <div class="carousel-item active">
                <div class="col-md-3">
                    <div class="card card-body" style="margin-right: 15px;">
                        <h5 class="card-title sliderfirst-heading-1">Amandeep Singh</h5>
                        <div class="stars custom-stars">
                            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                        </div>
                        <p class="card-text">The best turmeric powder I have ever used. The quality is
                            outstanding.</p>
                        <p class="card-date">June 4, 2024</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="col-md-3">
                    <div class="card card-body" style="margin-right: 15px;">
                        <h5 class="card-title sliderfirst-heading-2">Aditya Sharma</h5>
                        <div class="stars custom-stars">
                            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                        </div>
                        <p class="card-text">I love this turmeric powder! It adds such a rich flavor to
                            my dishes.</p>
                        <p class="card-date">June 4, 2024</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="col-md-3">
                    <div class="card card-body" style="margin-right: 15px;">
                        <h5 class="card-title sliderfirst-heading-3">Priya Mehta</h5>
                        <div class="stars custom-stars">
                            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                        </div>
                        <p class="card-text">Fantastic product! It has made a noticeable difference in
                            my cooking.</p>
                        <p class="card-date">June 3, 2024</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="col-md-3">
                    <div class="card card-body" style="margin-right: 15px;">
                        <h5 class="card-title sliderfirst-heading-4">Ravi Kumar</h5>
                        <div class="stars custom-stars">
                            <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                        </div>
                        <p class="card-text">High-quality turmeric powder with great color and aroma.
                            Highly recommend.</p>
                        <p class="card-date">June 2, 2024</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" class="active" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" class="active" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" class="active" aria-label="Slide 4"></button>
        </div>

        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->
    </div>
</section>



<!-- second slider  -->
<section>
    <div class="container mt-5 position-relative">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="col-md-3 mx-auto">
                        <div class="card card-body no-border card-spacing">
                            <img src="assets/images/whatsup.png" alt="Image 1" class="whats-img" />
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3 mx-auto">
                        <div class="card card-body no-border card-spacing">
                            <img src="assets/images/whatsup.png" alt="Image 2" class="whats-img" />
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3 mx-auto">
                        <div class="card card-body no-border card-spacing">
                            <img src="assets/images/whatsup.png" alt="Image 3" class="whats-img" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- 
                            <img src="assets/images/Back Arrow (4).png" alt=""
                                class="left-arrow position-absolute top-50 start-0 translate-middle-y"
                                style="z-index: 1" />
                            <img src="assets/images/Back Arrow (6).png" alt=""
                                class="right-arrow position-absolute top-50 end-0 translate-middle-y"
                                style="z-index: 1" /> -->

            <!-- Controls -->
            <!-- <button class="carousel-control-prev top-50 translate-middle-y" type="button"
                                data-bs-target="#myCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next top-50 translate-middle-y" type="button"
                                data-bs-target="#myCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button> -->
        </div>
    </div>
</section>





<section>
    <div class="container-fluid position-relative pt-4 mt-4">
        <img src="assets/images/banner 1.png" alt="Turmeric Powder" class="img-fluid-turmeric" />
        <div class="overlay-text">
            <h2 class="turmeric-second-slider-below-heading">Turmeric</h2>
            <h2 class="powder-second-slider-below-heading ml-2 pl-5">Powder</h2>

            <p class="anit-inflflammatory-heading-below-second slider">Anti-inflammatory Properties</p>
            <p class="antioxidant-inflflammatory-heading-below-second slider">Antioxidant Activity</p>
            <p class="potential-cancer-heading-below-second slider">Potential Cancer Prevention</p>
            <p class="improve-digestive-heading-below-second slider">Improves Digestive Health</p>
        </div>
    </div>
</section>

<style>
    .overlay-text {
        position: absolute;
        bottom: 10px;
        left: 10px;
        color: black;
        padding: 10px;
    }

    .anit-inflflammatory-heading-below-second,
    .potential-cancer-heading-below-second,
    .antioxidant-inflflammatory-heading-below-second,
    .improve-digestive-heading-below-second {
        background-color: #77C712;
        color: #FFFFFF;
        text-align: center;
        padding: 10px;
        margin-top: 10px;
        /* spacing between paragraphs */
    }

    @media (max-width: 768px) {
        .overlay-text {
            position: static;
            /* reset position */
            text-align: center;
            /* center align text */
        }

        .powder-second-slider-below-heading {
            margin-top: 10px;
            /* add margin to separate headings */
        }

        .anit-inflflammatory-heading-below-second,
        .potential-cancer-heading-below-second,
        .antioxidant-inflflammatory-heading-below-second,
        .improve-digestive-heading-below-second {
            width: auto;
            /* auto width */
        }
    }
</style>
















<section>
    <div class="container-fluid text-center text-white mt-5 pt-3 Subscribe-newsletter-container" style="background-color: #482607">
        <h6 class="Newsletter">Subscribe to our Newsletter</h6>
        <p class="get-updates">Get updates right in your inbox</p>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter your email" aria-label="Recipient's email" aria-describedby="basic-addon2" style="height: 36px;">
                        <div class="input-group-append">
                            <button class="btn btn-primary green-subscribe-btn" type="button" style="height: 36px; background-color: #77C712; color: #000000; border: none; width: 146px;">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>



<!-- JavaScript to Swap Main Image with Clicked Small Image -->
<script>
    function swapImages(clickedImage) {
        // Get the main image element
        const mainImage = document.getElementById('main-image');

        // Log the current state of the images for debugging
        // console.log("Before Swap:");
        // console.log("Main Image Source:", mainImage.src);
        // console.log("Clicked Small Image Source:", clickedImage.src);

        // Swap the `src` attributes visually without changing the actual file
        const tempSrc = mainImage.src;
        mainImage.src = clickedImage.src;
        clickedImage.src = tempSrc;

        // Log the updated state of the images after swapping
        // console.log("After Swap:");
        // console.log("Main Image Source:", mainImage.src);
        // console.log("Clicked Small Image Source:", clickedImage.src);
    }
</script>












<?php
include('includes/footer.php')
?>







<!-- Bootstrap JS Bundle CDN (optional) -->
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // var myCarousel = document.querySelector('#myCarousel')
    // var carousel = new bootstrap.Carousel(myCarousel, {
    //   interval: 100000
    // })

    $('.carousel .carousel-item').each(function() {
        var minPerSlide = 4;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < minPerSlide; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });
</script>
<script>
    $(document).ready(function() {
        $("#btn1").click(function() {
            $("#desc1").slideToggle();
            $("#desc2").slideUp();
            $("#desc3").slideUp();
        });
        $("#btn2").click(function() {
            $("#desc2").slideToggle();
            $("#desc1").slideUp();
            $("#desc3").slideUp();
        });
        $("#btn3").click(function() {
            $("#desc3").slideToggle();
            $("#desc1").slideUp();
            $("#desc2").slideUp();
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap JS Bundle CDN (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>