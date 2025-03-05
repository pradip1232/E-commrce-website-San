<?php
include('includes/header.php')
?>

<!-- frst section  -->
<!-- First Section with Image Slider -->
<section>
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- First Image -->
            <div class="carousel-item active">
                <img src="assets/images/hair oilll 1.webp" alt="Image 1" class="d-block w-100" />
            </div>
            <!-- Second Image -->
            <div class="carousel-item">
                <img src="assets/images/hair oilll 1.webp" alt="Image 2" class="d-block w-100" />
            </div>
            <!-- Third Image -->
            <div class="carousel-item">
                <img src="assets/images/hair oilll 1.webp" alt="Image 3" class="d-block w-100" />
            </div>
            <!-- Fourth Image -->
            <div class="carousel-item">
                <img src="assets/images/hair oilll 1.webp" alt="Image 4" class="d-block w-100" />
            </div>
        </div>

        <!-- Carousel Controls (Optional) -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<!-- End of First Section with Image Slider -->


<!-- frst section  -->





<!-- second section 
 -->
<section>
    <div class="container-section-two pt-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-2 mb-4">
                <div class="text-center">
                    <div class="image-container">
                        <img src="assets/images/samisha march 3.webp" alt="Image" class="health-care-images " />
                    </div>
                    <button class="health-care-btn-1">Health Care</button>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <div class="text-center">
                    <img src="assets/images/samisha march 1.webp" alt="Image" class="health-care-images " />
                    <button class="health-care-btn-2">Personal Care</button>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <div class="text-center">
                    <img src="assets/images/samisha march 1.webp" class="health-care-images " alt="Image" />
                    <button class="health-care-btn-3">Ayurvedic Medicines</button>
                </div>
            </div>

            <div class="col-md-2 mb-4">
                <div class="text-center">
                    <img src="assets/images/samisha march 4.webp" class="health-care-images " alt="Image" />
                    <button class="health-care-btn-4">Seasonal</button>
                </div>
            </div>
            <div class="col-md-2 mb-4">
                <div class="text-center">
                    <img src="assets/images/samisha march 5 (1).webp" class="health-care-images " alt="Image" />
                    <button class="health-care-btn-5">Special Combos</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- second section  -->



<!-- third section  -->
<style>
    .product-card-upar {
        height: auto;
        /* Fixed height */
        width: 100%;
        /* Full width of the column */
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1rem;
    }

    .image-container-upar {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px;
        /* Fixed height for image container */
    }

    .product-image-upar {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.3));

    }
    
    .img-container img {
                /*filter: drop-shadow(0px 10px 15px rgba(0, 0, 0, 0.3));*/

    }

    .product-title-upar {
        font-size: 1rem;
        font-weight: bold;
    }

    .product-subtitle {
        font-size: 0.875rem;
        color: #666;
    }

    .product-reviews {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .review-count {
        margin-left: 0.5rem;
        font-size: 0.875rem;
    }

    .product-price {
        font-size: 1rem;
        font-weight: bold;
    }

    .add-to-cart-btn {
        background-color: #77C712;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        cursor: pointer;
    }

    /* .add-to-cart-btn:hover {
    background-color: #218838;
} */
</style>
<section>
    <div class="container container-section-three pt-2 mt-2 w-100">
        <div class="d-flex justify-content-center align-items-center">
            <div class="align-items-center d-flex">
                <img src="assets/images/Leaf.png" alt="Image description" class="leave-img mr-2" />
                <p class="mb-0 Best-sellers">Best Sellers</p>
            </div>
        </div>
        <div class="row d-flex align-items-stretch">
            <!-- Product 1 -->
            <div class="col-md-3 mb-3 d-flex">
                <div class="card card-body d-flex flex-column  text-center product-card-upar">
                    <div class="image-container-upar">
                        <img src="assets/images/12 6.webp" class="product-image-upar mb-3" alt="Product Image" />
                    </div>
                    <h3 class="product-title-upar mb-2">Neem Face wash Gel 80g</h3>
                    <div class="product-reviews mb-2">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="review-count ms-2">4 reviews</span>
                    </div>
                    <div>
                        <p class="product-price mb-1">Rs 106</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
            </div>
            <!-- Repeat for other products with the same structure -->
            <!-- Product 2 -->
            <div class="col-md-3 mb-3 d-flex">
                <div class="card card-body d-flex flex-column  text-center product-card-upar">
                    <div class="image-container-upar">
                        <img src="assets/images/11 5 (1).webp" class="product-image-upar mb-3" alt="Product Image" />
                    </div>
                    <h3 class="product-title-upar mb-2">Arogya Amrit</h3>
                    <h3 class="product-subtitle mb-2">Herbal Tea 115g</h3>
                    <div class="product-reviews mb-2">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="review-count ms-2">4 reviews</span>
                    </div>
                    <div>
                        <p class="product-price mb-1">Rs 106</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-md-3 mb-3 d-flex">
                <div class="card card-body d-flex flex-column  text-center product-card-upar">
                    <div class="image-container-upar">
                        <img src="assets/images/10 2.webp" class="product-image-upar mb-3" alt="Product Image" />
                    </div>
                    <h3 class="product-title-upar mb-2">Keshwardhna Herbal</h3>
                    <h3 class="product-subtitle mb-2">Shampoo 200ml</h3>
                    <div class="product-reviews mb-2">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="review-count ms-2">4 reviews</span>
                    </div>
                    <div>
                        <p class="product-price mb-1">Rs 106</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="col-md-3 mb-3 d-flex">
                <div class="card card-body d-flex flex-column  text-center product-card-upar">
                    <div class="image-container-upar">
                        <img src="assets/images/DANT SHUDDHI.webp" class="product-image-upar mb-3" alt="Product Image" />
                    </div>
                    <h3 class="product-title-upar mb-2">Dant Shuddhi Tooth Paste 100gm</h3>
                    <div class="product-reviews mb-2">
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="text-warning">&#9733;</span>
                        <span class="review-count ms-2">4 reviews</span>
                    </div>
                    <div>
                        <p class="product-price mb-1">Rs 106</p>
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- third section  -->









<!-- 44444444 section  -->

<section>
    <div class="container-slider mt-5 pt-5">
        <div class="align-items-center d-flex justify-content-center">
            <p class="mb-0 seasonal">Seasonal Products</p>
        </div>
        <div id="myCarousel" class="carousel slide container" data-bs-ride="carousel">
            <div class="">
                <ol class="carousel-indicators custom d-flex justify-content-center">
                    <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active dot-slider-home rounded-circle dot-bottom-slider d-flex justify-content-center align-items-center indicator-spacing" style="width: 22px; height: 22px; background-color: #D9D9D9;"></li>
                    <li data-bs-target="#myCarousel" data-bs-slide-to="1" class="rounded-circle dot-slider-home dot-bottom-slider d-flex justify-content-center align-items-center indicator-spacing" style="width: 22px; height: 22px; background-color: #D9D9D9;"></li>
                    <li data-bs-target="#myCarousel" data-bs-slide-to="2" class="rounded-circle dot-slider-home dot-bottom-slider d-flex justify-content-center align-items-center indicator-spacing" style="width: 22px; height: 22px; background-color: #D9D9D9;"></li>
                    <li data-bs-target="#myCarousel" data-bs-slide-to="3" class="rounded-circle dot-slider-home dot-bottom-slider d-flex justify-content-center align-items-center indicator-spacing" style="width: 22px; height: 22px; background-color: #D9D9D9;"></li>
                </ol>
            </div>

            <div class="carousel-inner w-100">
                <div class="carousel-item active">
                    <div class="col-md-3">
                        <div class="card card-body d-flex align-items-center justify-content-center product-card">
                            <div class="img-container">
                                <img class="sirums" src="assets/images/BRAHMI BADAM SHARBAT 1 (1).webp">
                            </div>
                            <div class="card-footer bg-white border-0 text-center ">
                                <h3 class="brahmi-uices-1">Brahmi Badam Sharbat 750ml</h3>
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                    </div>
                                    <div class="ms-2">
                                        <p class="mb-0">4 reviews</p>
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-center">
                                    <div class="col-md-12 text-center">
                                        <p class="rupees-num">Rs 194</p>
                                        <button class="brahmi-juices-btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3">
                        <div class="card card-body d-flex align-items-center justify-content-center product-card">
                            <div class="img-container">
                                <img class="sirums" src="assets/images/KIWI 1.webp">
                            </div>
                            <div class="card-footer bg-white border-0 text-center ">
                                <h3 class="brahmi-uices-2">Kiwi Fruit Juice 750ml</h3>
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                        <span class="text-warning">&#9733;</span>
                                    </div>
                                    <div class="ms-2">
                                        <p class="mb-0">4 reviews</p>
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-center">
                                    <div class="col-md-12 text-center">
                                        <p class="rupees-num">Rs 125</p>
                                        <button class="brahmi-juices-btn">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Repeat for other carousel items -->
            </div>
        </div>
    </div>
</section>


<!-- 44444444 section  -->




<!-- 5 section  -->
<section>
    <div class="container-fluid mt-5 pt-5 where-every-pinch-container" style="position: relative; padding-left: 0; padding-right: 0">
        <img src="assets/images/masla bannerf 1.webp" class="sanjiva-masal-banner" alt="Your Image" class="pt-0 mt-0" />
        <div style="position: absolute; top: 0; right: 0; padding: 20px" class="pt-5 mt-2">
            <div class="display-flex-end-sanivika" style="display: flex; justify-content: flex-end;">
                <h1 class="sanjeevika-masala">Sanjeevika Masala</h1>
            </div>

            <div class="aronotic-container col-12 d-flex justify-content-end">
                <h6 class="tale-of-rich">Where every pinch narrates a tale of rich, aromatic indulgence in every dish</h6>
            </div>

        </div>
    </div>
</section>

<!-- 5 section  -->



<section>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img src="assets/images/Icon (4).webp" alt="Image 1" class="samisha-march-images" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button class="btn-three-four mt-3">
                                GMP CERTIFIED
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img src="assets/images/Icon (2).webp" alt="Image 2" class="samisha-march-images" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button class="btn-three-four mt-3">
                                GLUTEN FREE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img src="assets/images/Icon (3).webp" alt="Image 3" class="samisha-march-images" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button class="btn-three-four mt-3">
                                BEST IN QUALITY
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <img src="assets/images/Icon (1).webp" alt="Image 4" class="samisha-march-images" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button class="btn-three-four mt-3">
                                NO EXTRACTS USED
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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




<section>
    <div class="container-fluid position-relative p-0 mt-5">
        <img src="assets/images/amla juice 1.png" alt="" class="amla-aloe-image" style="width: 100%" />
        <div class="position-absolute text-left p-4" style="top: 0; left: 0">
            <div class="row">
                <div class="col-md-10">
                    <div class="upar-side-text2">
                        <h3 class="wholesome-heading-1">The Wholesome blend of</h3>
                        <h6 class="wholesome-heading-3">Amla and Aloe Vera juice</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute col-md-4 bottom-left p-4">
            <div class="down-side-btn-andtext">
                <h6 class="wholesome-heading-4">Your natural elixir for vitality and well-being</h6>
                <button class="shop-now-1">Shop now</button>
            </div>
        </div>
    </div>
</section>

<style>
    .bottom-left {
        bottom: 0;
        left: 0;
    }

    .bottom-left .down-side-btn-andtext {
        /* background-color: rgba(255, 255, 255, 0.8); Example background color */
        padding: 15px;
        border-radius: 5px;
    }

    .toothpas-images {
        width: 100%;
        height: 200px;
        /* Set the desired height for all images */
        /* object-fit: cover; */
        /* Ensures the image covers the entire container without stretching */
    }
</style>






<section>
    <div class="container-fluid w-100 mt-5 pt-5">
        <div class="row">
            <div class="col-md-3 d-flex align-items-start justify-content-center flex-column p-0">
                <div class="text-end Subscribe-bg-color pr-3" style="background-color: #482607; color: white; padding: 10px;">
                    <h4 class="personal-care">Personal care</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Aloe Vera Skin gel 1.png" alt="Aloe Vera Skin Gel" class="img-fluid toothpas-images" />
                    </div>
                    <h4>Aloevera Skin gel 80g</h4>
                    <p>Rs 175</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Shine Lotion 1.png" alt="Shine Lotion" class="img-fluid toothpas-images" />
                    </div>
                    <h4>Shine Lotion 60g</h4>
                    <p>Rs 175</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Neam Face Wash 1.png" alt="Neem Face Wash" class="img-fluid toothpas-images" />
                    </div>
                    <h4>Neem Face Wash Gel 80g</h4>
                    <p>Rs 175</p>
                </div>
            </div>
        </div>
    </div>
</section>






<section>
    <div class="container-fluid padding-right-edge-container mt-4 pt-4">
        <div class="row">
            <!-- First column -->
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Hair Care Oil 1.png" alt="Image 3" class="img-fluid facewashes" />
                    </div>
                    <h4>Shine lotion 60g</h4>
                    <p>Rs 175</p>
                </div>
            </div>

            <!-- Second column -->
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Hair Care Oil 1.png" alt="Image 3" class="img-fluid facewashes" />
                    </div>
                    <h4>Shine lotion 60g</h4>
                    <p>Rs 175</p>
                </div>
            </div>

            <!-- Third column -->
            <div class="col-md-3">
                <div class="product-card text-center">
                    <div class="product-image-container">
                        <img src="assets/images/Anti Hair Fall Oil 1.png" alt="Image 4" class="img-fluid facewashes" />
                    </div>
                    <h4>Neem Face Wash Gel 80g</h4>
                    <p>Rs 175</p>
                </div>
            </div>

            <!-- Fourth column with category header -->
            <div class="col-md-3 d-flex align-items-center justify-content-center">
                <div class="text-center brown-width-container" style="background-color: #482607; color: white; width: 100%; padding: 10px;">
                    <h4 class="hair-care text-start pl-3">Hair care</h4>
                </div>
            </div>
        </div>
    </div>
</section>






<?php
include('includes/footer.php')
?>