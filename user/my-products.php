<?php

session_start();
// include('includes/auth.php');
include('includes/header.php');
include('includes/sidebar.php');
include('includes/topbar.php');
include('config/conn.php');
?>





<!-- Modal Structure -->
<div class="modal fade" id="buyAgainModal" tabindex="-1" aria-labelledby="buyAgainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyAgainModalLabel">You want purchase again</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalProductDetails">
                    <img id="modalProductImage" src="" class="img-fluid mb-3" alt="Product Image">
                    <h5 id="modalProductName"></h5>
                    <p id="modalProductPrice"></p>
                    <p id="modalProductDate"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="modalBuyNowBtn">Buy Now</button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Bar (hidden initially) -->
<div id="notification" class="notification" style="display: none;">
    No purchased products found for the selected filter.
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">



<section>
    <div class="main-panel">
        <div class="content">


            <div class="container my-4">
                <!-- Search Bar with Monthly/Yearly Filter -->
                <div class="d-flex row button-and-search">
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-4">
                                    <select id="monthFilter" class="form-select filter-dropdown">
                                        <!-- Dynamically populated with months -->
                                    </select>
                                    <select id="yearFilter" class="form-select ms-2 filter-dropdown">
                                        <!-- Dynamically populated with years -->
                                    </select>
                                </div>
                                <div id="notification" class="notification-box"></div>
                            </div>



                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const monthFilter = document.getElementById('monthFilter');
                                    const yearFilter = document.getElementById('yearFilter');
                                    const notification = document.getElementById('notification');
                                    const currentDate = new Date();

                                    // Pre-fill the current month and year
                                    const currentMonth = currentDate.getMonth() + 1;
                                    const currentYear = currentDate.getFullYear();

                                    // Populate the month dropdown
                                    function populateMonths() {
                                        const months = [
                                            'January', 'February', 'March', 'April', 'May', 'June',
                                            'July', 'August', 'September', 'October', 'November', 'December'
                                        ];
                                        months.forEach((month, index) => {
                                            const option = document.createElement('option');
                                            option.value = index + 1; // Month as a number (1-12)
                                            option.textContent = month;
                                            if (index + 1 === currentMonth) option.selected = true; // Default to current month
                                            monthFilter.appendChild(option);
                                        });
                                    }

                                    // Populate the year dropdown
                                    function populateYears() {
                                        for (let year = currentYear; year >= currentYear - 5; year--) {
                                            const option = document.createElement('option');
                                            option.value = year;
                                            option.textContent = year;
                                            if (year === currentYear) option.selected = true; // Default to current year
                                            yearFilter.appendChild(option);
                                        }
                                    }

                                    // Filter orders based on the selected month and year
                                    function searchOrders() {
                                        const selectedMonth = parseInt(monthFilter.value);
                                        const selectedYear = parseInt(yearFilter.value);
                                        const orderCards = document.querySelectorAll('.order-card');
                                        let cardsDisplayed = 0;

                                        orderCards.forEach(card => {
                                            const purchaseDate = new Date(card.getAttribute('data-date'));
                                            const cardMonth = purchaseDate.getMonth() + 1;
                                            const cardYear = purchaseDate.getFullYear();
                                            const matchesFilter = cardMonth === selectedMonth && cardYear === selectedYear;

                                            card.style.display = matchesFilter ? 'block' : 'none';
                                            if (matchesFilter) cardsDisplayed++;
                                        });

                                        if (cardsDisplayed === 0) {
                                            showNotification("No purchased products found for the selected filter.");
                                        }
                                    }

                                    // Display notification with animation
                                    function showNotification(message) {
                                        notification.textContent = message;
                                        notification.classList.add('show');
                                        setTimeout(() => {
                                            notification.classList.remove('show');
                                        }, 3000);
                                    }

                                    // Event listeners for dropdowns
                                    monthFilter.addEventListener('change', searchOrders);
                                    yearFilter.addEventListener('change', searchOrders);

                                    // Initialize the dropdowns and apply the default filter
                                    populateMonths();
                                    populateYears();
                                    searchOrders(); // Apply default filter
                                });
                            </script>







                           
                        </div>

                    </div>
                    <div class="col-2">
                        <div class="buy-now-button">
                            <button id="buySelectedBtn" class="btn btn-success d-none">Buy Again</button>

                        </div>
                    </div>
                </div>

















                <div id="orderCards">
                    <!-- Button to buy selected items -->

                    <?php


                    // Fetch all purchased products
                    $sql = "SELECT purchase_id, product_id, sku, product_name, price, purchase_date FROM user_purchased_products";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Format the purchase date
                            $formattedDate = date("M d, Y", strtotime($row['purchase_date']));

                            // Generate product card HTML
                            echo "
                                    <div class=\"card mb-3 order-card\" data-date=\"{$formattedDate}\" >
                                        <div class=\"row g-0\">
                                            <div class=\"col-md-2\">
                                                <img src=\"images/{$row['product_id']}.jpg\" class=\"img-fluid rounded-start\" alt=\"Product Image\">
                                            </div>
                                            <div class=\"col-md-6\">
                                                <div class=\"card-body\">
                                                    <h5 class=\"card-title\">{$row['product_name']}</h5>
                                                    <p class=\"card-text\">₹{$row['price']}</p>
                                                    <p class=\"card-text text-success\">Purchased on $formattedDate</p>
                                                </div>
                                            </div>
                                            <div class=\"col-md-2 d-flex align-items-center justify-content-center d-none\">
                                                <input type=\"checkbox\" class=\"select-card-checkbox d-nonee\">
                                            </div>
                                        </div>
                                    </div>
                                    ";
                        }
                    } else {
                        echo "No purchased products found.";
                    }

                    // Close connection
                    $conn->close();
                    ?>



                    <!-- Repeat similar structure for other cards -->
                </div>

                <script>
                    // Track selected cards using unique card elements
                    const selectedCards = new Set();

                    // Reference to the "Buy Selected" button
                    const buySelectedBtn = document.getElementById('buySelectedBtn');

                    // Add event listeners to cards
                    document.querySelectorAll('.order-card').forEach(card => {
                        card.addEventListener('click', function(event) {
                            // Prevent propagation if internal elements like checkbox or image are clicked
                            if (event.target.tagName === 'INPUT' || event.target.tagName === 'IMG') return;

                            // Toggle selection
                            if (selectedCards.has(this)) {
                                selectedCards.delete(this); // Remove card from Set
                                this.classList.remove('bg-success', 'text-white'); // Unselect styling
                            } else {
                                selectedCards.add(this); // Add card to Set
                                this.classList.add('bg-success', 'text-white'); // Select styling
                            }

                            // Update the checkbox state
                            const checkbox = this.querySelector('.select-card-checkbox');
                            checkbox.checked = selectedCards.has(this);

                            // Log selected cards for debugging
                            // console.log('Selected cards count:', selectedCards.size);
                            // console.log(
                            //     'Selected cards:',
                            //     Array.from(selectedCards).map(card => card.dataset.date)
                            // );

                            // Show or hide the "Buy Selected" button based on selection
                            if (selectedCards.size > 0) {
                                buySelectedBtn.classList.remove('d-none');
                                // console.log("showing");
                            } else {
                                buySelectedBtn.classList.add('d-none');
                                // console.log("now shwoing to the button");
                            }
                        });
                    });

                    // Reference to the modal and its content container
                    const buyAgainModal = new bootstrap.Modal(document.getElementById('buyAgainModal'));
                    const modalProductDetails = document.getElementById('modalProductDetails');

                    // Handle "Buy Again" button click
                    buySelectedBtn.addEventListener('click', function() {
                        if (selectedCards.size === 0) {
                            alert('No items selected.');
                            return;
                        }

                        // Clear previous modal content
                        modalProductDetails.innerHTML = '';

                        // Populate modal with selected product details
                        Array.from(selectedCards).forEach(card => {
                            const productImage = card.querySelector('img').src;
                            const productName = card.querySelector('.card-title').textContent;
                            const productPrice = card.querySelector('.card-text').textContent;
                            const productDate = card.querySelector('.card-text.text-success').textContent;

                            // Create a new product detail section
                            const productDetail = document.createElement('div');
                            productDetail.classList.add('mb-3');

                            productDetail.innerHTML = `
                                <img src="${productImage}" class="img-fluid mb-2" alt="Product Image">
                                <h5>${productName}</h5>
                                <p>${productPrice}</p>
                                <p>${productDate}</p>
                                <hr>
                            `;

                            modalProductDetails.appendChild(productDetail);
                        });

                        // Show the modal
                        buyAgainModal.show();
                    });

                    // Optional: Add functionality to the "Buy Now" button inside the modal
                    document.getElementById('modalBuyNowBtn').addEventListener('click', function() {
                        alert('Proceeding to purchase selected products...');
                        // Add your purchase logic here (e.g., redirect to checkout or call API)
                    });
                </script>


            </div>

















        </div>

    </div>

</section>









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function searchOrders() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let orderCards = document.getElementsByClassName('order-card');

        for (let i = 0; i < orderCards.length; i++) {
            let cardText = orderCards[i].innerText.toLowerCase();
            if (cardText.includes(input)) {
                orderCards[i].style.display = "";
            } else {
                orderCards[i].style.display = "none";
            }
        }
    }
</script>










<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<?php
include('includes/footer.php');
?>