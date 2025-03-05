<?php
include('includes/header.php');
include('includes/already-auth.php');


?>




<style>
    .login-body {
        background: url('assets/images/Group 270.png') no-repeat left center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        min-height: 100vh;
    }

    .login-container {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }

    .login-form {
        /* background: rgba(255, 255, 255, 0.9); */
        padding: 20px;
        border-radius: 10px;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        max-width: 520px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .login-body {
            justify-content: center;
            background: none;
        }

        .login-container {
            justify-content: center;
        }
    }

    .sign-headding {
        font-family: Roboto;
        font-size: 24px;
        font-weight: 700;
        line-height: 28.13px;
        text-align: center;
        color: #482607;
    }

    .btn-success21 {
        background-color: #77C712;
        color: white;
    }
</style>

<section class="login-body wishlist-container-page">
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center">Sign In / Register</h2>
            <form id="signupForm">
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled selected>Select </option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control"
                            id="mobile"
                            name="mobile"
                            placeholder="Mobile Number"
                            required
                            minlength="10"
                            maxlength="10"
                            pattern="\d{10}"
                            oninput="validateMobile(this)">
                        <small id="mobileError" class="text-danger" style="display: none;">Please enter exactly 10 digits.</small>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="state">State <span class="text-danger">*</span></label>
                        <select id="state" name="state" class="form-control" required>
                            <option selected disabled>Choose...</option>
                            <?php
                            $states_and_uts = [
                                'Andhra Pradesh',
                                'Arunachal Pradesh',
                                'Assam',
                                'Bihar',
                                'Chhattisgarh',
                                'Goa',
                                'Gujarat',
                                'Haryana',
                                'Himachal Pradesh',
                                'Jharkhand',
                                'Karnataka',
                                'Kerala',
                                'Madhya Pradesh',
                                'Maharashtra',
                                'Manipur',
                                'Meghalaya',
                                'Mizoram',
                                'Nagaland',
                                'Odisha',
                                'Punjab',
                                'Rajasthan',
                                'Sikkim',
                                'Tamil Nadu',
                                'Telangana',
                                'Tripura',
                                'Uttar Pradesh',
                                'Uttarakhand',
                                'West Bengal',
                                'Andaman and Nicobar Islands',
                                'Chandigarh',
                                'Dadra and Nagar Haveli and Daman and Diu',
                                'Lakshadweep',
                                'Delhi',
                                'Puducherry',
                                'Ladakh',
                                'Lakshadweep',
                                'Jammu and Kashmir'
                            ];

                            foreach ($states_and_uts as $state_or_ut) {
                                echo "<option value=\"$state_or_ut\">$state_or_ut</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="country">Country <span class="text-danger">*</span></label>
                        <select class="form-control" id="country" name="country" required>
                            <option value="India" selected>India</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Sign Up</button>
                <div class="text-center mt-3">
                    <span>Already have an account? <a href="login">Log In</a></span>
                </div>
            </form>






            <script>
                // Function to validate mobile number input
                function validateMobile(input) {
                    const errorElement = document.getElementById('mobileError');
                    const isValid = /^\d{10}$/.test(input.value); // Check if the value is 10 digits
                    if (!isValid && input.value.length > 0) {
                        errorElement.style.display = 'block'; // Show error message
                    } else {
                        errorElement.style.display = 'none'; // Hide error message
                    }
                }

                // Additional validation during form submission
                document.getElementById('signupForm').addEventListener('submit', function(event) {
                    const mobileInput = document.getElementById('mobile');
                    if (!/^\d{10}$/.test(mobileInput.value)) {
                        event.preventDefault(); // Prevent form submission
                        alert('Mobile number must be exactly 10 digits.');
                        mobileInput.focus();
                    }
                });
            </script>

                  <script>
                        document.getElementById('signupForm').addEventListener('submit', function (event) {
                            event.preventDefault();
                    
                            const formData = new FormData(this);
                    
                            // Debugging: Log form data to console
                            console.log("Form Data:");
                            for (const [key, value] of formData.entries()) {
                                console.log(`${key}: ${value}`);
                            }
                    
                            fetch('config/user_data.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.text())
                                .then(data => {
                                    // console.log("Server Response:", data); // Debugging: Log server response
                                    if (data.includes('Registration successful')) {
                                        alert('Registration successful');
                                        location.reload();
                                    } else {
                                        alert(data);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error); // Debugging: Log error to console
                                    alert('An error occurred. Please try again.');
                                });
                        });
                    </script>


        </div>
    </div>
</section>










<?php
include('includes/footer.php');
?>