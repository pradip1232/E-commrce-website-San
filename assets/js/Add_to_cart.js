
document.addEventListener("DOMContentLoaded", async function () {
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
    // function createCard(item) {
    //     const card = document.createElement("div");
    //     card.className = "col-lg-3 col-md-4 col-sm-6 mb-4";
    //     card.dataset.id = item.id;
    //     card.innerHTML = `
    //             <div class="card-product2 card h-100">
    //                 <img class="card-img-top" src="${item.image}" alt="${item.title}">
    //                 <div class="card-body">
    //                     <h5 class="card-title card-redirection">${item.title}</h5>
    //                     <p class="card-text">${item.description}</p>
    //                     <div class="reviews-container">
    //                         <div class="stars">
    //                             ${'<span class="fa fa-star text-warning"></span>'.repeat(5)}
    //                         </div>
    //                         <span class="reviews-4">4 reviews</span>
    //                     </div>
    //                     <div class="text-center mt-2 font-weight-bold">&#8377;${item.price}</div>
    //                     <button class="btn-product-add mt-3">Add to </button>
    //                     <i class="fa fa-heart-o mt-2 heart-icon" style="color: black; cursor: pointer;" data-product-id="${item.id}"></i>
    //                 </div>
    //             </div>
    //             `;

    //     // Add click event listener to the product title and image
    //     const title = card.querySelector(".card-title");
    //     const image = card.querySelector(".card-img-top");

    //     title.addEventListener("click", function () {
    //         window.location.href = `product-details.php?id=${item.id}`;
    //     });

    //     image.addEventListener("click", function () {
    //         window.location.href = `product-details.php?id=${item.id}`;
    //     });

    //     // Handle Add to Cart button click
    //     const addToCartBtn = card.querySelector(".btn-product-add");
    //     addToCartBtn.addEventListener("click", function (event) {
    //         event.stopPropagation();
    //         addToCart(item);
    //     });

    //     // Handle heart icon click
    //     const heartIcon = card.querySelector(".heart-icon");
    //     heartIcon.addEventListener("click", async function () {
    //         const productId = this.getAttribute('data-product-id');
    //         if (window.isLoggedIn) {
    //             const isAdded = await toggleWishlist(productId, this);
    //             if (isAdded) {
    //                 heartIcon.classList.remove('fa-heart-o');
    //                 heartIcon.classList.add('fa-heart');
    //                 heartIcon.style.color = 'red';
    //             } else {
    //                 heartIcon.classList.remove('fa-heart');
    //                 heartIcon.classList.add('fa-heart-o');
    //                 heartIcon.style.color = 'black';
    //             }
    //         } else {
    //             // Show modal if user is not logged in
    //             $('#loginModal').modal('show');
    //         }
    //     });

    //     return card;
    // }

    // Function to display cards based on category
    // function displayCards(category) {
    //     cardContainer.innerHTML = "";
    //     items[category].forEach(item => {
    //         const card = createCard(item);
    //         cardContainer.appendChild(card);
    //     });
    // }

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
        category.addEventListener("click", function () {
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



