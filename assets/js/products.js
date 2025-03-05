
document.addEventListener("DOMContentLoaded", async function () {
    const response = await fetch('items.json');
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
        card.className = "card size-sect-cards col-lg-3 col-md-4 col-sm-6 mb-4"; // Adjusted Bootstrap grid classes for responsiveness and margin
        card.dataset.id = item.id; // Add the id as a data attribute
        card.innerHTML = `
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
`;
        const addToCartBtn = card.querySelector(".btn-product-add");
        addToCartBtn.addEventListener("click", function () {
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
        category.addEventListener("click", function () {
            const selectedCategory = this.dataset.value;
            displayCards(selectedCategory);
        });
    });

    // Display all cards initially and update cart count
    displayAllCards();
});

document.addEventListener("DOMContentLoaded", async function () {
    const response = await fetch('items.json');
    const items = await response.json();
    console.log(items);

    const cardContainer = document.getElementById("cardContainer");
    const categories = document.querySelectorAll("[data-value]");

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
        card.className = "card size-sect-cards col-lg-3 col-md-4 col-sm-6 mb-4"; // Adjusted Bootstrap grid classes for responsiveness and margin
        card.dataset.id = item.id; // Add the id as a data attribute
        card.innerHTML = `
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
            <div class="text-center mt-2 font-weight-bold id="cart-price" ">&#8377;${item.price}</div> <!-- Centered price -->
            <button class="btn-product-add mt-3">Add to Cart</button>
            <i class="fa fa-heart-o mt-2" style="color: black;"></i>
        </div>
    `;
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

    // Attach click event listeners to category headings
    categories.forEach(category => {
        category.addEventListener("click", function () {
            const selectedCategory = this.dataset.value;
            displayCards(selectedCategory);
        });
    });

    // Display all cards initially
    displayAllCards();
});

// <!-- badge count script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

document.addEventListener("DOMContentLoaded", function () {
    // Function to get cart items from localStorage
    function getCartItems() {
        let cartItems = localStorage.getItem('cartItem');
        return cartItems ? JSON.parse(cartItems) : [];
    }

    // Function to update cart count
    function updateCartCount() {
        let cartItems = getCartItems();
        let cartCount = cartItems.reduce((total, item) => total + item.quantity, 0); // Summing up quantities
        console.log('anand cardCount', cartCount, cartItems);
        document.querySelector('.cart-count').textContent = cartCount; // Update the cart count in the UI
    }

    // Update cart count on page load
    updateCartCount();

    // Event delegation for "Add to Cart" buttons
    document.getElementById('cardContainer').addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-product-add')) {
            let itemCard = event.target.closest('.card');
            let itemId = itemCard.dataset.id; // Assuming data-id contains the item identifier
            addToCart({ id: itemId, quantity: 1 });
        }
    });

    // Example function to add/update item in cart
    function addToCart(item) {
        let cartItems = getCartItems();
        // Check if item already exists
        let existingItem = cartItems.find(i => i.id === item.id);

        if (existingItem) {
            // Update existing item (e.g., increase quantity)
            existingItem.quantity += item.quantity;
        } else {
            // Add new item to cart
            cartItems.push(item);
        }

        // Update localStorage
        localStorage.setItem('cartItem', JSON.stringify(cartItems));

        // Update cart count
        updateCartCount();
    }

});


// <!-- Include FontAwesome for star and heart icons -->

// <!-- Add Bootstrap JS and dependencies -->
{/* <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> */}


document.addEventListener('DOMContentLoaded', function () {
    var closeButton = document.getElementById('closeButton');
    var sidebar = document.getElementById('sidebar');

    closeButton.addEventListener('click', function () {
        sidebar.classList.remove('slide-in');
        sidebar.classList.add('slide-out');
    });
});

$(document).ready(function () {
    $('.navbar-toggler-second').click(function () {
        $('#sidebar').toggleClass('show');
    });
});
