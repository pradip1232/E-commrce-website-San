<?php
include('includes/header.php');

include "config/conn.php";
?>


<style>
    .btn-group button {
        margin-right: 5px;
    }

    .turmeric-heading-1 {
        font-family: Roboto;
        font-weight: 700;
        font-size: 32px;
        line-height: 100%;
        letter-spacing: 0%;
        text-align: left;
        color: rgba(72, 38, 7, 1);
        text-transform: capitalize;
    }

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
        background-color: rgba(119, 199, 18, 1);
        /* Light Green */
        color: black;
    }

    .green-btn {
        background-color: rgba(119, 199, 18, 1);
        /* Green */
        color: white;
    }


    .products-details-page .btn-success {
        background-color: rgba(119, 199, 18, 1);
        border-color: rgba(119, 199, 18, 1);
    }
</style>
<style>
    .products-details-page {
        /* margin-top: 1rem; */
    }

    .multiple-image-left-side {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: flex-end;
        margin-right: 2rem;

    }

    .products-details-page .multiple-image-left-side .small-image {
        margin-top: 5px;
        position: absolute;
    }

    .products-details-page .multiple-image-left-side .small-box-img {
        position: absolute;
    }

    .products-details-page .multiple-image-left-side #main-image {
        height: 92%;
        width: 90%;
    }
</style>




<?php
$product_id = isset($_GET["id"]) ? trim($_GET["id"]) : null;
$product_sku = isset($_GET["sku"]) ? trim($_GET["sku"]) : null;
$product_batch = isset($_GET["batch"]) ? trim($_GET["batch"]) : null;

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
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <p>Tags: Oral</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-10 position-relative  ">
            <div class="row multiple-image-left-side">
                <!-- Right Column for Large Main Image -->
                <div class="col-md-3 col-12  mt-3 mt-md-0">
                    <div class="row g-2">
                        <!-- Small Image Boxes -->
                        <div class="col-2 col-md-10">
                            <img src="assets/images/Rectangle 5.png" alt="rectangle-border" class="img-fluid small-box-img">
                            <img src="assets/images/turmeric-power.png" alt="Small Image 1" class="img-fluid small-image" onclick="swapImages(this)">
                        </div>

                    </div>
                </div>
                <!-- Left Column for Small Image Thumbnails -->
                <div class="col-md-7 d-flex align-items-center justify-content-center ">
                    <img src="assets/images/Rectangle 5.png" alt="rectangle-border" class="img-fluid">
                    <img id="main-image" src="assets/images/turmeric-power.png" alt="Main Image" class="img-fluid individual-haldi-powder-one position-absolute">
                </div>
            </div>
        </div>
        <div class="col-md-5 col-lg-5 col-sm-6">
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
            $query = "SELECT `id`, `mrp`, `discount`, `selling_price`, `stock_quantity`, `packagingwithunit`, `manufacturing_date`, `expiration_date` 
          FROM `inventory` 
          WHERE `product_id` = '$product_id'";

            $result = mysqli_query($conn, $query);
            $inventoryDetails = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($inventoryDetails): ?>
                <div class="btn-group" role="group" id="packagingOptions">
                    <?php foreach ($inventoryDetails as $batch => $details):
                        $price = (isset($details['discount']) && $details['discount'] > 0)
                            ? htmlspecialchars($details['selling_price'], ENT_QUOTES, 'UTF-8')
                            : htmlspecialchars($details['mrp'], ENT_QUOTES, 'UTF-8');
                        $packaging = htmlspecialchars($details['packagingwithunit'], ENT_QUOTES, 'UTF-8');
                    ?>
                        <button
                            class="btn packaging-btn"
                            data-price="<?= $price ?>"
                            data-batch="<?= $batch ?>"
                            onclick="updatePrice(this)">
                            <?= $packaging ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="price-container-details mb-3 mt-3">
                    <div class="d-flex align-items-center mb-1">
                        <!-- Discount Percentage -->
                        <span class="text-dangerr text-decoration-line-through me-3 fs-5 discount">
                            -<?= (int)$inventoryDetails[0]['discount'] ?>%
                        </span>

                        <!-- Selling Price -->
                        <h4 class="fw-bold text-dark mb-0">
                            ₹<span id="productPrice">

                                <?= htmlspecialchars($inventoryDetails[0]['selling_price'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </h4>
                    </div>

                    <!-- MRP -->
                    <div class="text-muted small mrp-price">
                        M.R.P.: <span class="text-decoration-line-through"> <del>

                                ₹<?= htmlspecialchars($inventoryDetails[0]["mrp"], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                        </del>
                    </div>
                </div>


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

            <div class="row gap-2 custom-row-add-btn mt-2">
                <div class="col-md-9 custom-col">
                    <button class="btn light-green-btn w-100">ADD TO CART</button>
                </div>
                <div class="col-md-9 custom-col">
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
                let product_name = "<?php echo $allproduct["product_name"]; ?>";
                let product_id = "<?php echo $allproduct["product_id"]; ?>";
                let product_sku = "<?php echo $allproduct["product_sku"]; ?>";


                let checkoutUrl = "<?php echo $isLoggedIn ? 'checkout' : 'login'; ?>";
                if (checkoutUrl === "checkout") {
                    checkoutUrl += `?name=${encodeURIComponent(product_name)}&id=${encodeURIComponent(product_id)}&sku=${encodeURIComponent(product_sku)}&&&email=${encodeURIComponent(email)}&price=${selectedPrice}&quantity=${quantity}&batch=${selectedBatch}`;
                }

                window.location.href = checkoutUrl;
            }
        </script>

    </div>

</div>



<script>
    // function updatePrice(button) {
    //     // Remove active class from all buttons
    //     document.querySelectorAll("#packagingOptions button").forEach(btn => {
    //         btn.classList.remove("btn-success");
    //         btn.classList.add("btn-outline-secondary");
    //     });

    //     // Add active class to the selected button
    //     button.classList.remove("btn-outline-secondary");
    //     button.classList.add("btn-success");

    //     // Update the price
    //     document.getElementById("productPrice").innerText = button.getAttribute("data-price");
    // }
</script>





<div class="key-benefits-section py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold text-brown mb-4">Key Benefits</h2>

        <div class="row justify-content-center mb-3">
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Anti-inflammatory properties</button>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Rich in antioxidants</button>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Support digestive health</button>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Boost immunity</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Promotes skin health</button>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <button class="btn btn-success w-100">Support brain function</button>
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
                            <div class="tab-pane fade show active width-navigation-paragraph" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <p class="centered-paragraph">
                                    Our product is a state-of-the-art solution designed to enhance your daily life with unparalleled efficiency and reliability. Crafted from high-quality materials, it ensures durability and longevity, providing exceptional value for your investment. With a sleek design and user-friendly interface, this product seamlessly integrates into any environment, offering both functionality and aesthetic appeal.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                <p class="centered-paragraph">
                                    The benefits of using our product are numerous. It boosts productivity by streamlining tasks and minimizing downtime. Its innovative features are designed to adapt to your specific needs, making your operations more efficient. Furthermore, the product's intuitive design ensures a hassle-free user experience, reducing the learning curve and allowing you to achieve optimal results quickly.
                                </p>
                            </div>
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
    <div class="container">
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







<?php
include('includes/footer.php');

?>