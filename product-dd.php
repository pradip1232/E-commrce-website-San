<?php
include('includes/header.php');

include "config/conn.php";
?>


<style>
    .btn-group button {
        margin-right: 5px;
    }
</style>

<style>
    .custom-row-add-btn {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px;
    }

    @media (min-width: 768px) {
        .custom-row-add-btn {
            flex-direction: row;
        }
    }

    .custom-col {
        flex: 1;
    }

    .custom-btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .light-green-btn {
        background-color: #a8e06f;
        /* Light Green */
        color: black;
    }

    .green-btn {
        background-color: #4caf50;
        /* Green */
        color: white;
    }
</style>



<?php
$product_id = isset($_GET["id"]) ? trim($_GET["id"]) : null;
$product_sku = isset($_GET["sku"]) ? trim($_GET["sku"]) : null;

// echo "Product ID Type: " . gettype($product_id) . " | Value: " . htmlspecialchars($product_id) . "<br>";
// echo "Product SKU Type: " . gettype($product_sku) . " | Value: " . htmlspecialchars($product_sku) . "<br>";

// if (!is_numeric($product_id) || !is_numeric($product_sku)) {
//     die("<p class='text-danger'>Invalid product ID or SKU.</p>");
// }

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ? AND product_sku = ?");
$stmt->bind_param("ss", $product_id, $product_sku);
$stmt->execute();
$result = $stmt->get_result();
$allproduct = [];

if ($row = $result->fetch_assoc()) {
    $allproduct = $row;
} else {
    echo "<p class='text-danger'>No product found for ID: " . htmlspecialchars($product_id) . "</p>";
}
?>




<div class="container-fluid products-details-page">
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-10 position-relative">
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
                <div class="col-md-9 d-flex align-items-center justify-content-center ">
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
        <div class="col-md-6 col-lg-6 col-sm-6">
            <?php
            // echo "IDddddd" . $product_id;
            // print_r($allproduct);
            ?>
            <!-- Product Name -->
            <div class="product-name">
                <h3 class="turmeric-heading-1"><?php echo htmlspecialchars($row["product_name"]); ?></h3>
            </div>

            <!-- Star Ratings -->
            <div class="row">
                <div class="col">
                    <span class="star-icons">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <img src="assets/images/Star 1 (1).png" alt="Star" class="stat-top" />
                        <?php endfor; ?>
                    </span>
                </div>
            </div>

            <!-- Product Packaging Selection -->
            <?php
            $product_details = json_decode($row['product_details'], true);
            $minBatch = null;
            $minPrice = PHP_INT_MAX;

            foreach ($product_details as $batch => $details) {
                if ($details['selling_price'] < $minPrice) {
                    $minPrice = $details['selling_price'];
                    $minBatch = $batch;
                }
            }

            if ($product_details) :
                echo '<div class="btn-group" role="group" id="packagingOptions">';

                foreach ($product_details as $batch => $details) {
                    $activeClass = ($batch === $minBatch) ? 'btn-success' : 'btn-outline-secondary';
                    echo '<button class="btn ' . $activeClass . ' packaging-btn" data-price="' . $details['selling_price'] . '" data-batch="' . $batch . '" onclick="updatePrice(this)">' . $details['packaging'] . '</button>';
                }

                echo '</div>';
            ?>
                <h4 class="mt-3">₹ <span id="productPrice"><?php echo $minPrice; ?></span></h4>
            <?php endif; ?>

            <!-- Quantity Selector -->
            <div class="row">
                <div class="col">
                    <div class="counter-container-min-plus">
                        <button class="btn-minus btn" onclick="updateQuantity(-1)">-</button>
                        <span id="quantity-display">1</span>
                        <button class="btn-plus btn" onclick="updateQuantity(1)">+</button>
                    </div>
                </div>
            </div>

            <!-- Buy Now & Add to Cart Buttons -->
            <?php
            $email = $_SESSION['user_email'] ?? $_COOKIE['user_email'] ?? null;
            $isLoggedIn = isset($_SESSION['loggedin']);
            ?>

            <div class="row gap-2 custom-row-add-btn">
                <div class="col-md-6 custom-col">
                    <button class="btn light-green-btn w-100">ADD TO CART</button>
                </div>
                <div class="col-md-6 custom-col">
                    <div class="row">
                        <div class="col-md-9">
                            <button class="btn green-btn w-100" onclick="proceedToCheckout()">BUY NOW</button>
                        </div>
                        <div class="col-md-3">
                            <button class="heart-btn h-100 w-100"><i class="fas fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pincode Input -->
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-start align-items-center mt-3">
                        <div class="input-group custom-input-group">
                            <span class="input-group-text">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" class="form-control custom-input" placeholder="Enter Delivery Pincode">
                        </div>
                        <button class="btn green-btn ms-2">Check</button>
                    </div>
                </div>
            </div>

            <!-- Shipping Details -->
            <p class="mt-3">Delivering all across India</p>
            <div class="d-flex justify-content-start gap-4 feature-icons">
                <div><i class="fas fa-truck"></i><br />Free Shipping</div>
                <div><i class="fas fa-lock"></i><br />Secure Payment</div>
                <div><i class="fas fa-undo"></i><br />Easy Return</div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            let selectedPrice = <?php echo $minPrice; ?>;
            let selectedBatch = "<?php echo $minBatch; ?>";
            let quantity = 1;

            function updatePrice(element) {
                document.querySelectorAll('.packaging-btn').forEach(btn => btn.classList.remove('btn-success'));
                element.classList.add('btn-success');

                selectedPrice = element.getAttribute('data-price');
                selectedBatch = element.getAttribute('data-batch');
                document.getElementById('productPrice').innerText = selectedPrice;
            }

            function updateQuantity(value) {
                quantity = Math.max(1, quantity + value);
                document.getElementById('quantity-display').innerText = quantity;
            }

            function proceedToCheckout() {
                let email = "<?php echo $email; ?>";
                let checkoutUrl = "<?php echo $isLoggedIn ? 'checkout' : 'login'; ?>";

                if (checkoutUrl === "checkout") {
                    checkoutUrl += `?email=${encodeURIComponent(email)}&price=${selectedPrice}&quantity=${quantity}&batch=${selectedBatch}`;
                }

                window.location.href = checkoutUrl;
            }
        </script>

    </div>

</div>



<script>
    function updatePrice(button) {
        // Remove active class from all buttons
        document.querySelectorAll("#packagingOptions button").forEach(btn => {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-outline-secondary");
        });

        // Add active class to the selected button
        button.classList.remove("btn-outline-secondary");
        button.classList.add("btn-success");

        // Update the price
        document.getElementById("productPrice").innerText = button.getAttribute("data-price");
    }
</script>
























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