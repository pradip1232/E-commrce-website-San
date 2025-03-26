<?php
include('includes/header.php');
include "config/conn.php";
?>

<style>
    .sidebar {
        height: auto;
        position: relative;
        left: 0;
        top: 0;
        /* width: 250px; */
        /* background: #f8f9fa; */
        padding: 0 20px 0 40px;
        display: none;
    }

    .sidebar.show {
        display: block;
    }



    .filter-category {
        cursor: pointer;
    }

    @media (min-width: 768px) {
        .sidebar {
            display: block;
        }
    }

    .sidebar .card {
        background: rgba(255, 255, 255, 1);
        border: 1px solid rgba(236, 236, 236, 1);
        border-radius: 0px;
    }

    .sidebar .card ul li {
        font-family: Roboto;
        font-weight: 300;
        font-size: 18px;
        line-height: 21.09px;
        letter-spacing: 0%;
        color: rgba(0, 0, 0, 1);
    }

    .sidebar .card-header {
        font-family: Roboto;
        font-weight: 400;
        font-size: 20px;
        line-height: 23.44px;
        letter-spacing: 0%;

        color: rgba(119, 199, 18, 1);
        background: rgba(244, 244, 244, 1);

    }

    .product-page-upperside h3 {
        padding: 0 20px 0 40px;
        font-family: Roboto;
        font-weight: 700;
        font-size: 32px;
        line-height: 37.5px;
        letter-spacing: 0%;
        color: rgba(72, 38, 7, 1);
    }

    .product-page-upperside hr {
        margin: 0 0 20px 0 !important;
    }

    .product-section-filtering #productContainer .products-card {
        border: none;
        padding: 10px;
        background-color: rgba(244, 244, 244, 1);
        border-radius: 6px;
    }
</style>


<?php
// Fetch categories and subcategories
$sql = "SELECT `category_name`, `sub_category_name` FROM `product_categories`";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$groupedCategories = [];

foreach ($categories as $category) {
    $groupedCategories[$category['category_name']][] = $category['sub_category_name'];
}
?>

<main class="main-content " style="margin-top: 10rem;">
    <div class="container-fluid p-0 product-page-upperside">
        <div class="row">

            <div class="col-md-3">
                <h3 class="All-Categories">All Categories</h3>
            </div>
            <div class="col-md-9">
                <p class="total-products">18 products</p>
            </div>
        </div>
        <hr>
    </div>
    <div class="container-fluid product-section-filtering">
        <button class="btn btn-primary d-md-none" id="toggleSidebar">☰ </button>
        <div class="row">
            <div class="col-md-3 sidebar" id="sidebar">
                <?php foreach ($groupedCategories as $categoryName => $subCategories) { ?>
                    <div class="card mb-2">
                        <div class="card-header bg-primaryy text-whitee filter-category" data-category="<?= htmlspecialchars($categoryName) ?>">
                            <?= htmlspecialchars($categoryName) ?>
                        </div>
                        <div class="card-body text-left">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($subCategories as $subCategory) { ?>
                                    <li class="list-group-item filter-category" data-category="<?= htmlspecialchars($subCategory) ?>"><?= htmlspecialchars($subCategory) ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <?php
            $sql_product = "SELECT  * FROM `products`";
            $res_product = $conn->query($sql_product);

            $products = [];
            if ($res_product->num_rows > 0) {
                while ($row = $res_product->fetch_assoc()) {
                    $products[] = $row;
                }
            }
            ?>
            <div class="col-md-9 ooffset-md-3">
                <div class="row" id="productContainer">
                    <?php
                    // Debugging: Print product array
                    // print_r($products);
                    ?>

                    <?php foreach ($products as $product) {
                        if (!empty($product['product_details']) && $product['product_details'] !== null) {
                            $product_details = json_decode($product['product_details'], true);
                            // print_r($product_details);
                            if (is_array($product_details) && !empty($product_details)) {
                                $prices = array_column($product_details, 'cost_price');
                                $min_price = !empty($prices) ? min($prices) : 0;
                                $batches_with_min_price = [];
                                foreach ($product_details as $batch => $details) {
                                    if (isset($details['cost_price']) && $details['cost_price'] == $min_price) {
                                        $batches_with_min_price[] = $batch;
                                    }
                                }

                                // if (!empty($batches_with_min_price)) {
                                //     echo "Batches with the lowest cost price ($min_price): " . implode(', ', $batches_with_min_price);
                                // } else {
                                //     echo "No batches found with the minimum cost price.";
                                // }
                                $pp = array_column($product_details, 'packaging');
                                $min_pp = !empty($pp) ? min($pp) : 0;
                                // echo "minimum pakcgaing . $min_pp";
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        }
                    ?>

                        <div class="col-6 col-md-4 col-lg-3 product" data-category="<?= htmlspecialchars($product['product_category']) ?>">
                            <div class="products-card text-center p-3 ">
                                <img src="./assets/images/product_images/haircare3.png" alt="img" class="img-fluid">
                                <h6 class="mt-2"
                                    onclick="window.location.href='product-dd?id=<?= urlencode($product['product_id']) ?>&sku=<?= urlencode($product['product_sku']) ?>&batch=<?= urlencode(implode(',', $batches_with_min_price)) ?>'">
                                    <?= htmlspecialchars($product['product_name']) . " " . htmlspecialchars($min_pp) ?>
                                </h6>

                                <p class="text-dangerr fw-boldd">&#8377; <?= htmlspecialchars($min_price) ?></p>
                                <div class="row mb-2">
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
                                <button class="btn btn-success">Add to Cart</button>
                            </div>
                        </div>

                    <?php } ?>



                </div>
                <p id="noProductMessage" class="text-center text-danger mt-3" style="display: none;">No products available in this category</p>

            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById("toggleSidebar").addEventListener("click", function() {
        document.getElementById("sidebar").classList.toggle("show");
    });

    document.querySelectorAll(".filter-category").forEach(item => {
        item.addEventListener("click", function() {
            let category = this.getAttribute("data-category");
            let hasProducts = false;

            document.querySelectorAll(".product").forEach(product => {
                if (category === "all" || product.getAttribute("data-category") === category) {
                    product.style.display = "block";
                    hasProducts = true;
                } else {
                    product.style.display = "none";
                }
            });
            document.getElementById("noProductMessage").style.display = hasProducts ? "none" : "block";
        });
    });
</script>
















<?php
include('includes/footer.php');
?>