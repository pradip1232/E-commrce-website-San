<?php
include('includes/header.php');
// include "ptest.php";
?>



<div class="container-fluid product-conatiner-page">
    <!-- <p class="home-product-page-top">Home - Product Page</p> -->
    <h2 class="all-categories">All Categories</h2>

    <button class="navbar-toggler navbar-toggler-second btn mb-3 d-md-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="row">
        <div id="sidebar" class=" ml-4 sidebar-products col-lg-2">
            <!-- <div class="text-end mt-3 toggle-close-container">
                <button class="btn btn-link close-btn-toggle" id="closeButton">
                    <i class="fas fa-times cross-icon"></i>
                </button>
            </div> -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="category-select">
                        <p data-value="healthcare" class="health-care-1">Health care</p>
                        <p data-value="healthsupplements" class="health-care-2">Health supplements</p>
                        <p data-value="beverages" class="beverages-1">Beverages</p>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="category-select">
                        <p data-value="personalcare" class="beverages-2">Personal Care</p>
                        <p data-value="haircare" class="beverages-3">Hair care</p>
                        <p data-value="oralcare" class="beverages-4">Oral Care</p>
                        <p data-value="skincare" class="beverages-5">Skin care</p>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="category-select">
                        <p data-value="ayurvedicmedicines" class="Ayurvedic-1">Ayurvedic Medicines</p>
                        <p data-value="classicmedicines" class="Ayurvedic-2">Classic Medicines</p>
                        <p data-value="patentmedicines" class="Ayurvedic-3">Patent Medicines</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="cart-count">0</div> -->
        <!-- <div id="totalProductCount"></div> -->

        <!-- Second Section (Right Column) -->
        <div class="col-lg-9">
            <div class="container-fluid">
                <div class="row">
                    <p class="mb-0 mr-3">18 products</p>
                    <select class="form-select border-0 custom-select-arrow">
                        <option>Sort</option>
                        <!-- Add more options if needed -->
                    </select>
                </div>
            </div>
            <section class="mt-3">
                <div class="row" id="cardContainer">
                    <!-- Your cards will be displayed here -->
                </div>
            </section>


        </div>
    </div>
</div>



<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Please Log In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You need to log in to add items to your wishlist.</p>
                <!-- Add your login form here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="login.php" class="btn btn-primary">Log In</a>
            </div>
        </div>
    </div>
</div>












<?php

$response = array('loggedIn' => false);

// Check if the user is logged in by checking session variable
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $response['loggedIn'] = true;
}
?>

<script>
    // Set global JavaScript variable for login status
    window.isLoggedIn = <?php echo json_encode($response['loggedIn']); ?>;
</script>


<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const response = await fetch('item.json');
        const items = await response.json();
        console.log(items);

        const cardContainer = document.getElementById("cardContainer");
        const categories = document.querySelectorAll("[data-value]");
        const cartCount = document.querySelector(".cart-count");

        // Function to display all cards initially
        function displayAllCards() {
            cardContainer.innerHTML = ""; // Clear previous cards
            for (const category in items) {
                items[category].forEach(item => {
                    const card = createCard(item);
                    cardContainer.appendChild(card);
                });
            }
        }

        // Function to create a card element
        function createCard(item) {
            const card = document.createElement("div");
            card.className = "col-lg-3 col-md-4 col-sm-6 mb-4";
            card.dataset.id = item.id;
            card.innerHTML = `
                <div class="card-product2 card h-100">
                    <img class="card-img-top" src="${item.image}" alt="${item.title}">
                    <div class="card-body">
                        <h5 class="card-title card-redirection">${item.title}</h5>
                        <p class="card-text">${item.description}</p>
                        <div class="reviews-container">
                            <div class="stars">
                                ${'<span class="fa fa-star text-warning"></span>'.repeat(5)}
                            </div>
                            <span class="reviews-4">4 reviews</span>
                        </div>
                        <div class="text-center mt-2 font-weight-bold">&#8377;${item.price}</div>
                        <button class="btn-product-add mt-3">Add to Cart</button>
                        <i class="fa fa-heart-o mt-2 heart-icon" style="color: black; cursor: pointer;" data-product-id="${item.id}"></i>
                    </div>
                </div>
                `;

            // Add click event listener to the product title and image
            const title = card.querySelector(".card-title");
            const image = card.querySelector(".card-img-top");

            title.addEventListener("click", function() {
                window.location.href = `product-details.php?id=${item.id}`;
            });

            image.addEventListener("click", function() {
                window.location.href = `product-details.php?id=${item.id}`;
            });

            // Handle Add to Cart button click
            const addToCartBtn = card.querySelector(".btn-product-add");
            addToCartBtn.addEventListener("click", function(event) {
                event.stopPropagation();
                addToCart(item);
            });

            // Handle heart icon click
            const heartIcon = card.querySelector(".heart-icon");
            heartIcon.addEventListener("click", async function() {
                const productId = this.getAttribute('data-product-id');
                if (window.isLoggedIn) {
                    const isAdded = await toggleWishlist(productId, this);
                    if (isAdded) {
                        heartIcon.classList.remove('fa-heart-o');
                        heartIcon.classList.add('fa-heart');
                        heartIcon.style.color = 'red';
                    } else {
                        heartIcon.classList.remove('fa-heart');
                        heartIcon.classList.add('fa-heart-o');
                        heartIcon.style.color = 'black';
                    }
                } else {
                    // Show modal if user is not logged in
                    $('#loginModal').modal('show');
                }
            });

            return card;
        }

        // Function to display cards based on category
        function displayCards(category) {
            cardContainer.innerHTML = "";
            items[category].forEach(item => {
                const card = createCard(item);
                cardContainer.appendChild(card);
            });
        }

        // Function to add item to cart
        function addToCart(item) {
            let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const cartItem = cart.find(cartItem => cartItem.id === item.id);
            if (cartItem) {
                cartItem.quantity += 1;
            } else {
                item.quantity = 1;
                cart.push(item);
            }
            localStorage.setItem("shoppingCart", JSON.stringify(cart));

            // Display notification
            showAddToCartNotification(item.title);

            // Update the cart count immediately without page refresh
            getTotalProductCount();
        }

        // Function to show "Added to Cart" notification
        function showAddToCartNotification(productName) {
            const notification = document.createElement('div');
            notification.classList.add('cart-notification');
            notification.textContent = `${productName} has been added to your cart!`;
            document.body.appendChild(notification);

            // Remove the notification after a few seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Function to get the total count of products
        function getTotalProductCount() {
            const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const totalCount = cart.reduce((total, product) => total + product.quantity, 0);
            document.getElementById('totalProductCount').textContent = `${totalCount}`;
            // console.log("Total count: " + totalCount);
        }

        // Call the function to update the total count on page load or whenever needed
        getTotalProductCount();

        // Function to update cart count
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
            if (cartCount) {
                cartCount.textContent = totalQuantity;
            }
        }

        // Function to handle wishlist toggle
        async function toggleWishlist(productId, heartIcon) {
            try {
                const response = await fetch('config/wishlist-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        productId: productId
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                if (result.success) {
                    // Show wishlist notification
                    if (result.inWishlist) {
                        showWishlistNotification(productId);
                    }
                    return result.inWishlist;
                } else {
                    throw new Error('Server response indicates failure');
                }
            } catch (error) {
                console.error('Error toggling wishlist:', error);
                return false;
            }
        }

        function showWishlistNotification(productId) {
            console.log("Showing wishlist notification for product ID:", productId);

            // Find the product in items to get its title
            let productTitle = '';
            for (const category in items) {
                const item = items[category].find(item => item.id === parseInt(productId));
                if (item) {
                    productTitle = item.title;
                    break;
                }
            }

            if (productTitle) {
                const notification = document.createElement('div');
                notification.classList.add('wishlist-notification');
                notification.style.backgroundColor = 'orange'; // Set background color to orange
                notification.textContent = `${productTitle} has been added to your wishlist!`;
                document.body.appendChild(notification);

                // Remove the notification after a few seconds
                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }
        }


        // Attach click event listeners to category headings
        categories.forEach(category => {
            category.addEventListener("click", function() {
                const selectedCategory = this.dataset.value;
                displayCards(selectedCategory);
            });
        });

        // Display all cards initially and update cart count
        displayAllCards();
        updateCartCount();
    });

    // Function to get the total count of products in the cart
    function getTotalProductCount() {
        const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

        // Calculate the total quantity
        const totalCount = cart.reduce((total, product) => total + product.quantity, 0);

        // Update the displayed total count
        document.getElementById('totalProductCount').textContent = totalCount;
        console.log("Total count: " + totalCount);
    }

    // Call the function to update the total count on page load
    getTotalProductCount();
</script>













<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const response = await fetch('item.json');
        const items = await response.json();
        console.log(items);

        const cardContainer = document.getElementById("cardContainer");
        const categories = document.querySelectorAll("[data-value]");
        const cartCount = document.querySelector(".cart-count");

        // Function to display all cards initially
        function displayAllCards() {
            cardContainer.innerHTML = ""; // Clear previous cards
            for (const category in items) {
                items[category].forEach(item => {
                    const card = createCard(item);
                    // console.log("Cardddddd " +  items[category][id]);
                    cardContainer.appendChild(card);
                });
            }
        }

        // Function to create a card element
        function createCard(item) {
            const card = document.createElement("div");
            card.className = "col-lg-3 col-md-4 col-sm-6 mb-4";
            card.dataset.id = item.id;
            card.innerHTML = `
                <div class="card-product2 card h-100">
                    <img class="card-img-top" src="${item.image}" alt="${item.title}">
                    <div class="card-body">
                        <h5 class="card-title card-redirection">${item.title}</h5>
                        <p class="card-text">${item.description}</p>
                        <div class="reviews-container">
                            <div class="stars">
                                ${'<span class="fa fa-star text-warning"></span>'.repeat(5)}
                            </div>
                            <span class="reviews-4">4 reviews</span>
                        </div>
                        <div class="text-center mt-2 font-weight-bold">&#8377;${item.price}</div>
                        <button class="btn-product-add mt-3">Add to Cart</button>
                        <i class="fa fa-heart-o mt-2 heart-icon" style="color: black; cursor: pointer;" data-product-id="${item.id}"></i>
                    </div>
                </div>
                `;

            // Add click event listener to the product title and image
            const title = card.querySelector(".card-title");
            const image = card.querySelector(".card-img-top");

            title.addEventListener("click", function() {
                window.location.href = `product-details?id=${item.id}&sku=${item.sku}`;
            });

            image.addEventListener("click", function() {
                window.location.href = `product-details.php?id=${item.id}&sku=${item.sku}`;
            });

            // Handle Add to Cart button click
            const addToCartBtn = card.querySelector(".btn-product-add");
            addToCartBtn.addEventListener("click", function(event) {
                event.stopPropagation();
                addToCart(item);
            });

            // Handle heart icon click
            const heartIcon = card.querySelector(".heart-icon");
            heartIcon.addEventListener("click", async function() {
                const productId = this.getAttribute('data-product-id');
                if (window.isLoggedIn) {
                    const isAdded = await toggleWishlist(productId, this);
                    if (isAdded) {
                        heartIcon.classList.remove('fa-heart-o');
                        heartIcon.classList.add('fa-heart');
                        heartIcon.style.color = 'red';
                    } else {
                        heartIcon.classList.remove('fa-heart');
                        heartIcon.classList.add('fa-heart-o');
                        heartIcon.style.color = 'black';
                    }
                } else {
                    // Show modal if user is not logged in
                    $('#loginModal').modal('show');
                }
            });

            return card;
        }

        // Function to display cards based on category
        function displayCards(category) {
            cardContainer.innerHTML = "";
            items[category].forEach(item => {
                const card = createCard(item);
                cardContainer.appendChild(card);
            });
        }

        // Function to add item to cart
        function addToCart(item) {
            let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const cartItem = cart.find(cartItem => cartItem.id === item.id);
            if (cartItem) {
                cartItem.quantity += 1;
            } else {
                item.quantity = 1;
                cart.push(item);
            }
            localStorage.setItem("shoppingCart", JSON.stringify(cart));

            // Display notification
            showAddToCartNotification(item.title);

            // Update the cart count immediately without page refresh
            getTotalProductCount();
        }

        // Function to show "Added to Cart" notification
        function showAddToCartNotification(productName) {
            const notification = document.createElement('div');
            notification.classList.add('cart-notification');
            notification.textContent = `${productName} has been added to your cart!`;
            document.body.appendChild(notification);

            // Remove the notification after a few seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Function to get the total count of products
        function getTotalProductCount() {
            const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const totalCount = cart.reduce((total, product) => total + product.quantity, 0);
            document.getElementById('totalProductCount').textContent = `${totalCount}`;
            console.log("Total count: " + totalCount);
        }

        // Call the function to update the total count on page load or whenever needed
        getTotalProductCount();

        // Function to update cart count
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
            if (cartCount) {
                cartCount.textContent = totalQuantity;
            }
        }

        // Function to handle wishlist toggle
        async function toggleWishlist(productId, heartIcon) {
            try {
                const response = await fetch('config/wishlist-handler.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        productId: productId
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const result = await response.json();
                if (result.success) {
                    // Show wishlist notification
                    if (result.inWishlist) {
                        showWishlistNotification(productId);
                    }
                    return result.inWishlist;
                } else {
                    throw new Error('Server response indicates failure');
                }
            } catch (error) {
                console.error('Error toggling wishlist:', error);
                return false;
            }
        }

        function showWishlistNotification(productId) {
            console.log("Showing wishlist notification for product ID:", productId);

            // Find the product in items to get its title
            let productTitle = '';
            for (const category in items) {
                const item = items[category].find(item => item.id === parseInt(productId));
                if (item) {
                    productTitle = item.title;
                    break;
                }
            }

            if (productTitle) {
                const notification = document.createElement('div');
                notification.classList.add('wishlist-notification');
                notification.style.backgroundColor = 'orange'; // Set background color to orange
                notification.textContent = `${productTitle} has been added to your wishlist!`;
                document.body.appendChild(notification);

                // Remove the notification after a few seconds
                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }
        }


        // Attach click event listeners to category headings
        categories.forEach(category => {
            category.addEventListener("click", function() {
                const selectedCategory = this.dataset.value;
                displayCards(selectedCategory);
            });
        });

        // Display all cards initially and update cart count
        displayAllCards();
        updateCartCount();
    });

    // Function to get the total count of products in the cart
    function getTotalProductCount() {
        const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

        // Calculate the total quantity
        const totalCount = cart.reduce((total, product) => total + product.quantity, 0);

        // Update the displayed total count
        document.getElementById('totalProductCount').textContent = totalCount;
        console.log("Total count: " + totalCount);
    }

    // Call the function to update the total count on page load
    getTotalProductCount();
</script>












<!-- Include FontAwesome for star and heart icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Add Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- close icon -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.getElementById('closeButton');
        var sidebar = document.getElementById('sidebar');

        closeButton.addEventListener('click', function() {
            sidebar.classList.remove('slide-in');
            sidebar.classList.add('slide-out');
        });
    });
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript -->
<script>
    $(document).ready(function() {
        $('.navbar-toggler-second').click(function() {
            $('#sidebar').slideToggle(); // Smoothly shows and hides the sidebar
        });

        $('#closeButton').click(function() {
            $('#sidebar').slideUp(); // Hides the sidebar when close button is clicked
        });
    });
</script>


<?php
include('includes/footer.php')
?>

<!-- <script src="assets/js/products.js"></script> -->