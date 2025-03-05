<?php
// Start session
session_start();



// Include header.php (assuming it contains necessary HTML and session_start() if needed)


?>

<!DOCTYPE html>

    <meta charset="UTF-8">
   
    <!-- Include CSS files -->
    <link rel="stylesheet" href="assets/Css/product/product.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Include JavaScript files -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Additional styles -->
    <style>
    .pc-navbar {
        height: 130px;
        background-color: white;
        position: -webkit-sticky;
        /* For Safari */
        position: sticky;
        top: 0;
        z-index: 1000;
        /* Ensure it stays above other content */
        box-shadow: 0px 4px 13.7px 0px #00000040;
        /* Adds a bottom shadow */
    }

    /* Example content to enable scrolling */
    .content {
        height: 2000px;
        /* Make the page long enough to scroll */
        background: linear-gradient(to bottom, #f0f0f0, #333);
        /* Just for visual */
    }

    .category-list li {
        color: #D58711 !important;
        font-family: Arial;
        font-size: 20px !important;
        font-weight: 400 !important;
        line-height: 33.95px;
        letter-spacing: 0.06em;
        text-align: left;

    }

    .category-list {
        list-style-type: none;
        padding: 0;
    }

    .category-item {
        margin: 5px 0;
    }

    .searchbycate {
        font-family: Arial !important;
        font-size: 24px !important;
        font-weight: 400 !important;
        line-height: 27.54px !important;
        letter-spacing: 0.06em;
        text-align: left;

    }

    #txtSearch {
        border: none;
        box-shadow: 0px 4px 4px 0px #00000040 inset;
        background: #FFFFFF;


        gap: 0px;
        border-radius: 5px;
        max-width: 100%;
        opacity: 0px;

    }

    input[type=checkbox],
    input[type=radio] {
        box-shadow: 0px 4px 4px 0px #00000040 inset !important;

    }
</style>

<section class="pc-navbar">
    <?php
    include ("includes/haeder.php");
    include ("includes/navbar.php");
    ?>
</section>
<link rel="stylesheet" href="assets/Css/product/product.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T6w02O3EgoAVfTtfPVjHhGz/Yv3eA0M2Z1EmWj7YZnFET1I8SxeO3frtT9tiDmWm" crossorigin="anonymous">

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
   <!-- Custom CSS -->
    <style>
    
    
    .login-cont{
         /*margin-toprem!important;*/
            margin-bottom:5rem!important;
    }
    .shodowbg{
                    /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);*/

    }
    
    
    
    .form-container {
      background-color: white;
      padding: 2rem;
      /*border-radius: 10px;*/
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
        .form-container {
           
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('assets/Images/agro immm 1.png'); /* Replace with the path to your image */
            background-size: cover;
            background-position: center;
            margin: 0;
     
        }
        .form-wrapper {
            margin-top:-8rem!important;
             width: 560px!important;
      height: 400px!important;
            /*background: rgba(255, 255, 255, 0.9);*/
            padding: 30px;
            /*border-radius: 10px;*/
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);*/
        }
        .form-control {
    background-color: transparent!important; /* or any other background color you prefer */
}
        .form-heading {
            font-family: Arial;
font-size: 24px!important;
font-weight: 700;
line-height: 27.6px;
text-align: center;
color: #482607;

            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-custom {
            background-color: #f0ad4e;
            border: none;
        }
        .loginbtn{
            color:black!important;
            font-family: Arial;
font-size: 16px!important;
font-weight: 400!important;
line-height: 20px!important;
text-align: center;

        }
        .btn-custom:hover {
            background-color: #ec971f;
        }
        
        .signupbtn{
            background: #D58711;

        }
        strong{
            color:black;
                font-weight: bolder;
        }
    </style>
    
    
    <section class="login-cont mt-2 pt-3">
        
          <div class="container-fluid shodowbg">
                <h2 class="text-center form-heading mb-1">SIGN IN / REGISTER</h2>
          </div>
        <div class="form-container">
        <div class="form-wrapper">
           <!--<form id="signupForm1" action="config/user_data.php" method="post">-->
           <form id="signupForm">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Enter Your Full Name" name="name" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" required>
                        <small class="error-msg" style="color: red; display: none;" style="font-size:12px!important;">Mobile number must be 10 digits long.</small>
                    </div>
                </div>
                <?php
                    $states = [
                        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat",
                        "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh",
                        "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
                        "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand",
                        "West Bengal"
                    ];
                ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="state" required>
                            <option value="" disabled selected>Select State</option>
                            <?php
                            foreach ($states as $state) {
                                echo "<option value=\"$state\">$state</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="country" required>
                            <option value="India" selected>India</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <small class="password-strength" style="display: none;"></small>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-custom signupbtn">SIGN UP</button>
                </div>
                <p class="text-center loginbtn">Already have an account? <a href="login"><strong>Log In</strong></a></p>
            </form>

        </div>
    </div>

    </section>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS and jQuery (for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Your custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Function to validate mobile number length
            function validateMobileLength(mobile) {
                return mobile.length === 10;
            }

            // Function to handle form submission
            $('#signupForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Check mobile number length before AJAX submission
                var mobile = $('#mobile').val();
                if (!validateMobileLength(mobile)) {
                    $('#mobile-error').text('Mobile number should be exactly 10 digits.');
                    return; // Stop submission if mobile number length is incorrect
                }

                // Perform AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'config/user_data.php', // The URL to the PHP script that will process the form
                    data: $(this).serialize(), // Serialize the form data
                    success: function(response) {
                        alert(response); // Display the response from the PHP script
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error); // Handle errors
                    }
                });
            });

            // Clear mobile number error message on input change
            $('#mobile').on('input', function() {
                $('#mobile-error').text('');
            });
        });
    </script>



<?php
include ("includes/footer.php")
    ?>
