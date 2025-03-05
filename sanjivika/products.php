<?php
include('includes/header.php')
?>

<div class="container-fluid product-conatiner-page">
    <!-- <p class="home-product-page-top">Home - Product Page</p> -->
    <h2 class="all-categories">All Categories</h2>
    <!-- Button for toggling sidebar -->
    <button class="navbar-toggler navbar-toggler-second btn mb-3 d-md-none" type="button">
        <span class="navbar-toggler-icon">☰</span>
    </button>
    <div class="row">
        <!-- Left side with three cards (hidden on small screens) -->
        <div id="sidebar" class="d-md-block ml-4">
            <div class="text-end mt-3 toggle-close-container">
                <button class="btn btn-link close-btn-toggle" id="closeButton">
                    <i class="fas fa-times cross-icon"></i>
                </button>
            </div>
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
            card.className = "col-lg-3 col-md-4 col-sm-6 mb-4 card-redirection"; // Adjusted Bootstrap grid classes for responsiveness and margin
            card.dataset.id = item.id; // Add the id as a data attribute
            card.innerHTML = `
                <div class="card-product2 card h-100">
                    <img class="card-img-top" src="${item.image}" alt="${item.title}">
                    <div class="card-body">
                        <h5 class="card-title">${item.title}</h5>
                        <p class="card-text">${item.description}</p>
                        <div class="reviews-container">
                            <div class="stars">
                                ${'<span class="fa fa-star text-warning"></span>'.repeat(5)}
                            </div>
                            <span class="reviews-4">4 reviews</span>
                        </div>
                        <div class="text-center mt-2 font-weight-bold">&#8377;${item.price}</div> <!-- Centered price -->
                        <button class="btn-product-add mt-3">Add to Cart</button>
                        <i class="fa fa-heart-o mt-2" style="color: black;"></i>
                    </div>
                </div>
            `;

            // Add click event listener to redirect to the product-details.php page
            card.addEventListener("click", function() {
                window.location.href = `product-details.php?id=${item.id}`;
            });

            const addToCartBtn = card.querySelector(".btn-product-add");
            addToCartBtn.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent the redirection when the Add to Cart button is clicked
                addToCart(item);
            });

            return card;
        }


        // Function to display cards based on category
        function displayCards(category) {
            cardContainer.innerHTML = ""; // Clear previous cards
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
            updateCartCount();
        }

        // Function to update cart count
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
            const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
            cartCount.textContent = totalQuantity;
            console.log('anand add to cart');
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
    });
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

<script>
    $(document).ready(function() {
        $('.navbar-toggler-second').click(function() {
            $('#sidebar').toggleClass('show');
        });
    });
</script>


<?php
include('includes/footer.php')
?>

<!-- <script src="assets/js/products.js"></script> -->