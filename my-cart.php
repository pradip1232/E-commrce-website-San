<?php
// session_start();
include('includes/header.php');
?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
    .lightgray-color-colmn {
        background: #dee2e6 !important;
    }

    .cart-container {
        padding: 20px;
        min-height: calc(100vh - 100px);
        /* display: flex;
        flex-direction: column; */
        margin-top: 130px;
        /* Adjust based on your header height */
    }

    .cart-header {
        color: #482607;
        font-family: Roboto;
        font-size: 32px;
        font-weight: 700;
        line-height: 37.5px;
        text-align: center;

        text-align: center;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .cart-summary {
        width: 100%;
        margin-top: 20px;
    }

    .btn-qty {
        width: 32px;
        height: 32px;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
    }

    .cart-summary .table {
        margin-bottom: 0;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .input-group-w {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .qnityt-area input {
        width: 50px;
        text-align: center;
        border: none;
    }

    /* Responsive adjustments */
    @media (max-width: 1199px) {

        /* For large screens (tablets and below) */
        .container-fluid {
            padding: 15px;
        }

        .cart-summary {
            width: 100%;
            margin-top: 20px;
        }
    }

    @media (max-width: 991px) {

        /* For medium screens (tablets) */
        .col-lg-8,
        .col-lg-4 {
            flex: 1 1 100%;
            /* Make columns stack on top of each other */
            max-width: 100%;
        }

        .input-group-w {
            width: 100%;
        }
    }

    @media (max-width: 767px) {

        /* For small screens (phones) */
        .btn-qty {
            width: 28px;
            height: 28px;
        }

        .qnityt-area input {
            width: 40px;
        }

        .cart-header {
            font-size: 18px;
        }

        .table th,
        .table td {
            font-size: 14px;
        }
    }

    .btn-success-check {
        background-color: #482607;
        color: white;
    }

    .price-p,
    .total {
        color: #77C712;
        font-family: Archivo;
        font-size: 18px;
        font-weight: 400;
        line-height: 19.58px;
        text-align: left;

    }

    .sumry-cal {
        background: #F4F4F4;

    }
</style>





<div id="notificationBar" class="alert alert-success alert-dismissible fade" role="alert" style="position:fixed; bottom:20px; right:10px; z-index:1050; display:none;">
    <span id="notificationMessage">Product removed successfully</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>










<div class="container-fluid cart-container ">
    <h2 class="cart-header">Your Cart</h2>
    <div class="row">
        <div class="col-lg-8">
            <div class="cart-items">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th class="lightgray-color-colmn text-center">PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="lightgray-color-colmn text-center">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        <!-- Table rows will be dynamically added here -->
                        <td class="product-column">
                            <div class="product-wrapper">
                                <!-- <img src="${image}" alt="${title}" class="img-fluid"> -->
                                <span>${title}</span>
                                <button class="remove-btn" onclick="removeItem('${id}')">X</button>
                            </div>
                        </td>
                        <!-- Include Bootstrap Icons CDN (Add this in your HTML head if not already included) -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

                        <!-- Styling for the remove icon -->
                        <style>
                            /* Hide the remove icon by default */
                            .remove-icon {
                                display: none;
                                position: absolute;
                                top: 5px;
                                /* Adjust as needed */
                                right: 10px;
                                /* Adjust as needed */
                                font-size: 20px;
                                color: red;
                                cursor: pointer;
                            }

                            /* Show the remove icon when the row is hovered */
                            tr:hover .remove-icon {
                                display: block;
                            }

                            /* Ensure the total column is relatively positioned to properly position the remove icon */
                            .total {
                                position: relative;
                            }
                        </style>

                        <!-- Script to handle cart functionality -->
                        <script>
                            // Function to populate the cart table and calculate the subtotal
                            function populateCartTable() {
                                const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
                                const tableBody = document.getElementById("cartTableBody");
                                const noProductsMessage = document.getElementById("noProductsMessage");
                                const subtotalElement = document.getElementById("subtotal");

                                tableBody.innerHTML = ""; // Clear any existing rows

                                let subtotal = 0; // Initialize subtotal

                                if (cart.length === 0) {
                                    // Show the no products message
                                    noProductsMessage.style.display = "block";
                                } else {
                                    // Hide the no products message and populate the table
                                    noProductsMessage.style.display = "none";
                                    cart.forEach(item => {
                                        const {
                                            id,
                                            title = 'Product Name',
                                            image = 'https://via.placeholder.com/100',
                                            price = 0,
                                            quantity = 1
                                        } = item;

                                        const row = document.createElement("tr");
                                        row.setAttribute("data-id", id);

                                        row.innerHTML = `
                                                <td class="product-column">
                                                    <div class="product-wrapper">
                                                        <span>${title}</span>
                                                    </div>
                                                </td>
                                                <td class="lightgray-color-colmn text-center price" data-price="${price}">
                                                    <p class="price-p text-center">₹ ${price.toFixed(2)}</p>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group-w qnityt-area text-center justify-content-center">
                                                        <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, -1)">-</button>
                                                        <input type="text" class="form-control text-center qty" value="${quantity}" readonly>
                                                        <button class="btn btn-outline-secondary btn-qty" type="button" onclick="updateQty(this, 1)">+</button>
                                                    </div>
                                                </td>
                                                <td class="total text-center">
                                                    <p class="price-p text-center">₹ ${(price * quantity).toFixed(2)}</p>
                                                    <i class="bi bi-x remove-icon" onclick="removeItem('${id}')"></i>
                                                </td>
                                            `;

                                        tableBody.appendChild(row);

                                        // Add to subtotal
                                        subtotal += price * quantity;
                                    });

                                    // Update the subtotal display
                                    subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
                                }
                            }





                            // Function to update quantity
                            function updateQty(button, change) {
                                const input = button.parentNode.querySelector('.qty');
                                let quantity = parseInt(input.value, 10);
                                quantity = Math.max(1, quantity + change); // Ensure quantity is at least 1
                                input.value = quantity;

                                // Get the row's product ID and price
                                const row = button.closest('tr');
                                const price = parseFloat(row.querySelector('.price').dataset.price);
                                const totalCell = row.querySelector('.total .price-p');

                                // Update the total price in the table
                                totalCell.textContent = `₹${(price * quantity).toFixed(2)}`;

                                // Update local storage
                                const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];
                                const itemId = row.getAttribute("data-id");
                                const itemIndex = cart.findIndex(item => item.id === itemId);
                                if (itemIndex !== -1) {
                                    cart[itemIndex].quantity = quantity;
                                    localStorage.setItem("shoppingCart", JSON.stringify(cart));
                                }

                                // Update subtotal
                                updateSubtotal();
                            }

                            // Function to update subtotal
                            function updateSubtotal() {
                                const totals = document.querySelectorAll('.total .price-p');
                                let subtotal = 0;
                                totals.forEach(function(total) {
                                    subtotal += parseFloat(total.textContent.replace('₹', ''));
                                });
                                document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
                            }

                            function removeItem(id) {
                                const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

                                // console.log('Removing product with ID:', id); // Log the ID
                                // console.log('Cart contents before removal:', cart); // Log cart contents

                                // Convert both IDs to the same type for comparison (e.g., string)
                                const updatedCart = cart.filter(item => item.id.toString() !== id.toString());

                                // If the length hasn't changed, the product ID wasn't found
                                if (updatedCart.length === cart.length) {
                                    showNotification('Product ID not found', 'alert-danger');
                                    return;
                                }

                                // Update local storage with the new cart
                                localStorage.setItem("shoppingCart", JSON.stringify(updatedCart));

                                // Remove the item from the table
                                const row = document.querySelector(`tr[data-id="${id}"]`);
                                if (row) {
                                    row.remove();
                                }

                                // Update subtotal
                                updateSubtotal();

                                // Show notification after successful removal
                                showNotification('Product removed successfully', 'alert-success');

                                // Check if cart is empty and show the no products message
                                if (updatedCart.length === 0) {
                                    document.getElementById("noProductsMessage").style.display = "block";
                                }
                            }

                            // Function to show Bootstrap alert notification
                            function showNotification(message, alertType) {
                                const notificationBar = document.getElementById('notificationBar');
                                const notificationMessage = document.getElementById('notificationMessage');

                                notificationMessage.textContent = message; // Set the message
                                notificationBar.classList.remove('alert-success', 'alert-danger'); // Reset any previous alert types
                                notificationBar.classList.add(alertType); // Add the new alert type (success, danger, etc.)

                                notificationBar.style.display = 'block'; // Show the notification
                                notificationBar.classList.add('show'); // Ensure the fade-in animation works

                                // Hide the alert after 3 seconds
                                setTimeout(() => {
                                    notificationBar.classList.remove('show');
                                    notificationBar.style.display = 'none';
                                }, 3000);
                            }



                            // Call the function to populate the table on page load
                            window.onload = populateCartTable;
                        </script>


                    </tbody>
                </table>
                <div id="noProductsMessage" class="no-products" style="display: none;">
                    No products in your cart. Please add some products.
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="cart-summary">
                <table class="table sumry-cal">
                    <tr>
                        <td>Shipping</td>
                        <td class="text-end">CALCULATED AT CHECKOUT</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end" id="subtotal">₹00.00</td>
                    </tr>
                </table>
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

                // Display the email if found in session or cookie
                if ($email) {
                    // echo "User Email (from session or cookie): " . htmlspecialchars($email);
                } else {
                    // echo "No email found in session or cookie.";
                }

                // Debugging the productTax value
                // if (isset($minQuantityVariant['productTax'])) {
                //     echo "<pre>Debug: Product Tax Value: " . htmlspecialchars($minQuantityVariant['productTax']) . "</pre>";
                // } else {
                //     echo "<pre>Debug: productTax key does not exist or is null</pre>";
                // }

                // Debug: Check if the required fields are set
                // var_dump($minQuantityVariant);

                // Generate URL based on login status
                if ($isLoggedIn) {
                    // Ensure email, price, and tax are properly set before encoding
                    $emailEncoded = isset($email) ? urlencode($email) : '';
                    $price = isset($minQuantityVariant['sellingPrice']) ? urlencode($minQuantityVariant['sellingPrice']) : '';
                    $tax = isset($minQuantityVariant['productTax']) ? urlencode($minQuantityVariant['productTax']) : '';

                    $buyNowUrl = "checkout?email={$emailEncoded}&price={$price}&tax={$tax}";
                } else {
                    $buyNowUrl = "login";
                }

                // Output the URL for verification
                // echo "<pre>Debug: Generated URL: " . htmlspecialchars($buyNowUrl) . "</pre>";
                ?>

                <!-- Final button -->
                <a href="<?php echo $buyNowUrl; ?>" class="btn btn-success-check btn-block">
                    PROCEED TO CHECKOUT
                </a>
                <div class="text-center mt-2">
                    <a href="#">or continue shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
include('includes/footer.php');
?>