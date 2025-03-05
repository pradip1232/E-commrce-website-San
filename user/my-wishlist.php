<?php

session_start();
// include('includes/auth.php');
include('includes/header.php');
include('includes/sidebar.php');
include('includes/topbar.php');
include('config/conn.php');
?>


<section>
    <div class="main-panel">
        <div class="content">
            
            
           <div class="container my-4">
        <!-- Search Bar -->
        <div class="input-group mb-4">
            <input id="searchInput" type="text" class="form-control" placeholder="Search your orders here" aria-label="Search Orders">
            <button class="btn " type="button" onclick="searchOrders()">Search</button>
        </div>

        <!-- Order Card -->
        <div class="card mb-3 order-card">
            <div class="row g-0">
                <div class="col-md-2">
                    <img src="product1.jpg" class="img-fluid rounded-start" alt="Product Image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Product name</h5>
                        <p class="card-text">₹661</p>
                        <p class="card-text text-success">Purchased on Jun 29</p>
                        <p class="card-text"><a href="#" class="text-primary">Rate & Review Product</a></p>
                    </div>
                </div>
                <!-- <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <span class="badge bg-success">Purchased</span>
                </div> -->
            </div>
        </div>

        <!-- Order Card -->
        <div class="card mb-3 order-card">
            <div class="row g-0">
                <div class="col-md-2">
                    <img src="product2.jpg" class="img-fluid rounded-start" alt="Product Image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Product name</h5>
                        <p class="card-text">₹347</p>
                        <p class="card-text text-success">Purchased on May 13</p>
                        <p class="card-text"><a href="#" class="text-primary">Rate & Review Product</a></p>
                    </div>
                </div>
                <!-- <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <span class="badge bg-success">Purchased</span>
                </div> -->
            </div>
        </div>

       
       
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



<?php
include ('includes/footer.php');
?>