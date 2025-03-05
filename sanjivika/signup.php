<?php
include('includes/header.php');
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
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender">
                            <option value="" disabled selected>Select </option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" placeholder="Mobile Number">
                    </div>
                </div>
                <div class="form-row">
                    <?php
                    $states = [
                        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa", "Gujarat",
                        "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala", "Madhya Pradesh",
                        "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
                        "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura", "Uttar Pradesh", "Uttarakhand",
                        "West Bengal"
                    ];
                    ?>

                    <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <select class="form-control" id="state">
                            <option value="" disabled selected>Select your state</option>
                            <?php foreach ($states as $state) : ?>
                                <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class=" form-group col-md-6 mb-3">
                        <label for="state">Country</label>
                        <select class="form-control" name="country" required>
                            <option value="India" selected>India</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-success21 btn-block">Sign Up</button>
                <div class="text-center mt-3">
                    <span>Already have an account? <a href="login">Log In</a></span>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
include('includes/footer.php');
?>