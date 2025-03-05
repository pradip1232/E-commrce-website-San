<?php
session_start();
include("includes/auth.php");
include("includes/Header.php");
include("includes/Sidebar.php");
include("config/dbcon.php");
include("includes/Topbar.php");
?>



<style>
    .textuser {
        font-size: 2rem;
    }
</style>


<div class="content-wrapper">



    <?php
    // if (isset($_SESSION['auth']) && $_SESSION['auth'] && isset($_SESSION['modal_displayed'])) {
    // unset($_SESSION['auth']);
    ?>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Your Details</h5>
                    <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--    <span aria-hidden="true">&times;</span>-->
                    <!--</button>-->
                </div>
                <div class="modal-body">
                    <!-- Modal body content -->
                    <form action="#" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">Full Name</label>
                                <input type="text" class="form-control" id="editFirstName" name="username" value="<?php echo $_SESSION['user-auth']['name']; ?>" readonly>
                                <div class="invalid-feedback">
                                    Full name is required.
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                                <div class="invalid-feedback">
                                    Date of Birth is required.
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
                                <div class="invalid-feedback">
                                    Country is required.
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                                <div class="invalid-feedback">
                                    State is required.
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                <div class="invalid-feedback">
                                    City is required.
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pinCode">Pin Code</label>
                                <input type="text" class="form-control" id="pinCode" name="pincode" placeholder="Pin Code" required>
                                <div class="invalid-feedback">
                                    Pin Code is required.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                            <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        //     $(document).ready(function() {
        //         $('#editModal').modal('show');
        //     });
    </script>

    <?php
    // }
    ?>




    <!-- Main content -->
    <section class="content mt-2">
        <div class="container-fluid ">
            <?php
            if (isset($_SESSION['auth'])) {

            ?>
                <div id="alertMsg" class="alert alert-warning alert-dismissible fade show">
                    <strong>You logged in Successfully </strong>
                </div>

                <script>
                    setTimeout(function() {
                        document.getElementById('alertMsg').style.display = 'none';
                    }, 3000);
                </script>
            <?php

                unset($_SESSION['Msgs']);
            }
            ?>
            <!-- Small boxes (Stat box) -->
            <!-- <div class="row"> -->
            <!-- /.tab-pane -->
            <div class="row">
                <div class="col-12">
                    <div class="card p-1">




                        <?php
                        if (isset($_SESSION['auth'])) {
                            $loggedinuser = $_SESSION['user-auth']['email'];
                            // echo "loggedinuser222222 $loggedinuser";
                            $a = "SELECT * FROM `user-data` WHERE Email = '$loggedinuser'";
                            $query_run = mysqli_query($conn, $a);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>








                                    <div class="container-fluid">
                                        <div class="row seven-levle-box">

                                            <div class="col-md-12 main-content">

                                                <section>
                                                    <div class="container text-center mt-5">
                                                        <p>My Account</p>
                                                        <div class="row justify-content-center row-equal">
                                                            <div class="col-md-3 d-flex justify-content-center">
                                                                <p>Joining Date</p>
                                                            </div>
                                                            <div class="col-md-3 d-flex justify-content-center">
                                                                <p>Activation Date</p>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center row-equal">
                                                            <div class="col-md-3 d-flex justify-content-center">
                                                                <p>00/00/0000</p>
                                                            </div>
                                                            <div class="col-md-3 d-flex justify-content-center">
                                                                <p>00/00/0000</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" align-items-center">
                                                        <div class="form-group row">
                                                            <label for="inputFirstName" class="col-sm-2 col-form-label float-right">Affiliate ID</label>
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    <span id="affiliateID" class="form-control" disabled>
                                                                        <?php echo $row['User_aff_id']; ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div id="submitButtonContainer">
                                                                    <?php
                                                                    $affiliateID = $row['User_aff_id'];
                                                                    $hideButtonClass = !empty($affiliateID) ? 'd-none' : '';
                                                                    ?>

                                                                    <style>
                                                                        @keyframes shake {
                                                                            0% {
                                                                                transform: translateX(0);
                                                                            }

                                                                            25% {
                                                                                transform: translateX(-5px) rotate(-5deg);
                                                                            }

                                                                            50% {
                                                                                transform: translateX(5px) rotate(5deg);
                                                                            }

                                                                            75% {
                                                                                transform: translateX(-5px) rotate(-5deg);
                                                                            }

                                                                            100% {
                                                                                transform: translateX(0);
                                                                            }
                                                                        }

                                                                        .shake {
                                                                            animation: shake 1.5s ease-in-out;
                                                                        }
                                                                    </style>

                                                                    <!--<form action="" method="post">-->
                                                                    <form action="config/userid.php" method="post">
                                                                        <input type="hidden" name="user-id" id="result">
                                                                        <input type="hidden" id="cntry" name="country" value="<?php echo $row['countery']; ?>">
                                                                        <input type="hidden" id="stt2" name="state" value="<?php echo $row['state']; ?>">
                                                                        <input type="hidden" id="usredreg" name="usredreg" value="<?php echo $_SESSION['user-auth']['email']; ?>">
                                                                        <button type="submit" id="submitButton" name="userid" class="btn btn-primary shake <?php echo $hideButtonClass; ?>">
                                                                            Generate ID
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row align-items-center mt-3">
                                                        <div class="col-md-2 text-right">
                                                            <p>My Referral Link</p>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <?php
                                                            // Assuming $row['User_aff_id'] contains the user ID or is defined elsewhere
                                                            $userId = isset($row['User_aff_id']) ? $row['User_aff_id'] : null;

                                                            if ($userId) {
                                                                // Generate the referral link
                                                                $referralLink = 'https://gyanimind.in/signup?id=' . $userId;
                                                            ?>
                                                                <input type="text" id="referralLink" class="form-control" value="<?php echo $referralLink; ?>" readonly>
                                                            <?php
                                                            } else {
                                                                // Display a message or handle if no user ID is available
                                                                echo '<p>Please generate your ID for referral link availability.</p>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?php if ($userId) : ?>
                                                                <!-- Button to copy referral link -->
                                                                <button id="copyReferralLink" class="btn btn-primary btn-sm">Copy Link</button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        // JavaScript to copy the referral link to clipboard
                                                        document.getElementById('copyReferralLink').addEventListener('click', function() {
                                                            var referralLink = document.getElementById('referralLink');

                                                            // Select the text in the input field
                                                            referralLink.select();
                                                            referralLink.setSelectionRange(0, 99999); // For mobile devices

                                                            // Copy the text to clipboard
                                                            document.execCommand('copy');

                                                            // Deselect the text
                                                            window.getSelection().removeAllRanges();

                                                            // Change button text briefly to indicate success
                                                            var copyBtn = this;
                                                            copyBtn.textContent = 'Copied!';
                                                            setTimeout(function() {
                                                                copyBtn.textContent = 'Copy Link';
                                                            }, 2000); // Reset button text after 2 seconds
                                                        });
                                                    </script>
                                                    <div class="row align-items-center mt-3">
                                                        <div class="col-md-2 text-right">
                                                            <p>Sponsor Id</p>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" value="<? echo $row['sp']; ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <?php

                                                    $spname = $row['sp'];
                                                    // echo "spname $spname";
                                                    $q = "SELECT * FROM `user-data` WHERE User_aff_id = '$spname'";
                                                    $query_run2 = mysqli_query($conn, $q);
                                                    // echo "dedfasedf";
                                                    if (mysqli_num_rows($query_run2) > 0) {
                                                        $row1 = mysqli_fetch_assoc($query_run2); // Fetching the row once is sufficient
                                                        $w = $row1['Name'];
                                                        // echo "wwwwwwwwwww $w";
                                                    ?>
                                                        <div class="row align-items-center mt-3">
                                                            <div class="col-md-2 text-right">
                                                                <p>Referrer Name</p>
                                                            </div>

                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" value="<?php echo $row1['Name']; ?>" readonly>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                    ?>
                                                </section>
                                                <div class="container-fluid form-container mt-5 pt-5 remove-left-space">
                                                    <h6 class="user-profile-heading">User Profile</h6>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group row profile-form-group-container">
                                                                <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="name" placeholder="" value="<? echo strtoupper($row['Name']); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mt-2">
                                                                <label for="phone" class="col-md-3 col-form-label text-md-right">Phone</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control" id="phone" placeholder="" value="<? echo $row['Mobile_number']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mt-2">
                                                                <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>
                                                                <div class="col-md-9">
                                                                    <input type="email" class="form-control" id="email" placeholder="" value="<? echo $row['Email']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 image-container">
                                                            <div class="circle-bg" onclick="insertImage()">
                                                                <img src="Images/Checked User Male.png" alt="Profile Image">
                                                            </div>
                                                            <p>User Photo</p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="state" class="col-md-2 col-form-label text-md-right">State</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" id="state" placeholder="" value="<? echo $row['state']; ?>">
                                                        </div>
                                                        <label for="city" class="col-md-3 col-form-label text-md-right">City</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" id="city" placeholder="Enter your city">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mt-2">
                                                        <label for="pincode" class="col-md-2 col-form-label text-md-right">Pincode</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" id="pincode" placeholder="Enter your pincode">
                                                        </div>
                                                        <label for="gender" class="col-md-2 col-form-label text-md-right">Gender</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" id="gender" placeholder="Enter your gender">
                                                        </div>
                                                        <label for="dob" class="col-md-2 col-form-label text-md-right">DOB</label>
                                                        <div class="col-md-2">
                                                            <input type="date" class="form-control" id="dob">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </section>







    <!--//new ciodedfdsfdsafffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff-->








    <!--<div class="content-header">-->
    <!--<div class="container-fluid">-->
    <!--<div class="row mb-2 justify-content-center">-->
    <!--<div class="col-sm-6">-->
    <!--<h1 class="m-0">My Information</h1>-->
    <!--</div><!-- /.col -->-->
    <!--<div class="col-sm-auto">-->
    <!--<ol class="breadcrumb bg-blue">-->
    <!--<li class="breadcrumb-item text-white">Joining Date</li>-->
    <!--<li class="breadcrumb-item active">Activation Date</li>-->
    <!--</ol>-->
    <!--</div><!-- /.col -->-->
    <!--</div>-->
    <!-- /.row -->
    <!--</div><!-- /.container-fluid -->-->
    <!--</div>-->
    <!-- Main content -->
    <!--<section class="content mt-2">-->
    <!--    <div class="container-fluid ">-->

    <!--        <div class="row">-->
    <!--            <div class="col-12">-->
    <!-- <div class="card p-1"> -->

    <?php
    if (isset($_SESSION['auth'])) {
        $loggedinuser = $_SESSION['user-auth']['email'];
        // echo "loggedinuser222222 $loggedinuser";
        $a = "SELECT * FROM `user-data` WHERE Email = '$loggedinuser'";
        $query_run = mysqli_query($conn, $a);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
    ?>

                <?php
                // if (isset($_SESSION['auth'])) {
                ?>
                <!--<div class="tab-pane" id="settings">-->
                <!--    <div class="card custom-card">-->
                <!--        <div class="card-body">-->
                <!--            <form class="form-horizontal p-2">-->
                <!--                <div class="form-group row">-->
                <!--                    <label for="inputAffiliateID" class="col-sm-2 col-form-label">Affiliated ID</label>-->
                <!--                    <div class="col-sm-10">-->
                <!--                        <div class="input-group">-->
                <!--                            <input type="text" class="form-control" id="inputAffiliateID" value="<?php echo $row['User_aff_id']; ?>" disabled>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                     <div class="col-sm-4"> <!-- Adjusted column size to accommodate both elements in the same row -->-->
                <!--                    <div id="submitButtonContainer">-->
                <!--                         <div id="submitButtonContainer">-->
                <!--<form action="config/user-data.php" method="post">-->
                <!--    <input type="text" name="aff_user_id" id="result">-->
                <!--    <input type="hidden" id="cntry" name="country" value="<?php echo $row['countery']; ?>">-->
                <!--    <input type="hidden" id="stt2" name="state" value="<?php echo $row['state']; ?>">-->
                <!--    <button  type="submit" name="userid" class="btn btn-primary">Generate ID</button>-->
                <!--</form>-->

                <?php
                // Check if the affiliate ID exists for the user
                $affiliateID = $row['User_aff_id'];
                if (!empty($affiliateID)) {
                    // If affiliate ID exists, apply the 'd-none' class to hide the button
                    $hideButtonClass = 'd-none';
                } else {
                    $hideButtonClass = '';
                }
                ?>

                <!--            <form action="config/userid.php" method="post">-->
                <!--                <input type="hidden" name="user-id" id="result">-->
                <!--                <input type="hidden" id="cntry" name="country" value="<?php echo $row['countery']; ?>">-->
                <!--                <input type="hidden" id="stt2" name="state" value="<?php echo $row['state']; ?>">-->
                <!--                <input type="hidden" id="usredreg" name="usredreg" value="<?php echo $_SESSION['user-auth']['email']; ?>">-->
                <!--                <button type="submit" id="submitButton" name="userid" class="btn btn-primary <?php echo $hideButtonClass; ?>">Generate ID</button>-->
                <!--            </form>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--</div>-->
                <?php

                $spname = $row['sp'];
                // echo "spname $spname";
                $q = "SELECT * FROM `user-data` WHERE User_aff_id = '$spname'";
                $query_run2 = mysqli_query($conn, $q);
                // echo "dedfasedf";
                if (mysqli_num_rows($query_run2) > 0) {
                    $row1 = mysqli_fetch_assoc($query_run2); // Fetching the row once is sufficient
                    $w = $row1['Name'];
                    // echo "wwwwwwwwwww $w";
                ?>

                    <!--<div class="form-group row">-->
                    <!--    <label for="inputEmail" class="col-sm-2 col-form-label">Sponsor Name</label>-->
                    <!--    <div class="col-sm-10">-->
                    <!--        <input type="text" class="form-control" value="<?php echo $row1['Name']; ?>" disabled>-->
                    <!--    </div>-->
                    <!--</div>-->
                <?php
                }
                ?>
                <!--<div class="form-group row">-->
                <!--    <label for="inputSponsorName" class="col-sm-2 col-form-label">Sponsor Name</label>-->
                <!--    <div class="col-sm-10">-->
                <!--        <input type="text" class="form-control" id="inputSponsorName" value="DEMO" disabled>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="form-group row">-->
                <!--    <label for="inputReferralLink" class="col-sm-2 col-form-label">Referral Link</label>-->
                <!--    <div class="col-sm-10">-->
                <!--        <input type="text" class="form-control" id="inputReferralLink" value="Referral Link" disabled>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="form-group row">-->
                <!--    <label for="inputUserName" class="col-sm-2 col-form-label">Sponsor Id</label>-->
                <!--    <div class="col-sm-10">-->
                <!--        <input type="text" class="form-control" id="inputUserName" value="<? echo $row['sp']; ?>" disabled>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="form-group row">-->
                <!--    <label for="inputPhoneNumber" class="col-sm-2 col-form-label">Phone Number</label>-->
                <!--    <div class="col-sm-10">-->
                <!--        <input type="text" class="form-control" id="inputPhoneNumber" value="DEMO" disabled>-->
                <!--    </div>-->
                <!--</div>-->
                <!--            </form>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

    <?php
            }
        }
    }
    ?>
    <!-- </div> -->
    <!--    </div>-->
    <!--</div>-->
    <!-- /.tab-pane -->
    <!-- </div> -->
    <!--    </div>-->
    <!--</section>-->

    <!--<section class="content">-->
    <!--    <div class="container-fluid">-->
    <!--        <div class="row">-->
    <!--            <div class="col-12">-->
    <!--                <div class="card">-->
    <!--                    <div class="card-header">-->
    <!--                        <h3 class="ml-2 mt-2 textuser">User Profile</h3>-->
    <!--                    </div>-->
    <!--                    <div class="card-body">-->

    <?php
    if (isset($_SESSION['auth'])) {
        $loggedinuser = $_SESSION['user-auth']['email'];
        // echo "loggedinuser222222 $loggedinuser";
        $a = "SELECT * FROM `user-data` WHERE Email = '$loggedinuser'";
        $query_run = mysqli_query($conn, $a);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
    ?>
                <!--<form action="ProductDB.php" method="post" class="row">-->
                <!-- Input fields on the left -->
                <!--    <div class="col-sm-10">-->
                <!--        <div class="form-group row">-->
                <!--            <label for="name" class="col-sm-2 col-form-label">Name</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" class="form-control" id="name" value="<? echo strtoupper($row['Name']); ?>" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="phoneNumber" class="col-sm-2 col-form-label">Phone Number</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" class="form-control" id="phoneNumber" value="DEMO" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="email" class="col-sm-2 col-form-label">Email</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="email" class="form-control" id="email" value="DEMO@example.com" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="state" class="col-sm-2 col-form-label">State</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" class="form-control" id="state" value="California" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="city" class="col-sm-2 col-form-label">City</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" class="form-control" id="city" value="Los Angeles" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="pincode" class="col-sm-2 col-form-label">Pincode</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="text" class="form-control" id="pincode" value="90001" disabled>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="gender" class="col-sm-2 col-form-label">Gender</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <select class="form-control" id="gender" disabled>-->
                <!--                    <option>Male</option>-->
                <!--                    <option>Female</option>-->
                <!--                    <option>Other</option>-->
                <!--                </select>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--        <div class="form-group row">-->
                <!--            <label for="dob" class="col-sm-2 col-form-label">Date of Birth</label>-->
                <!--            <div class="col-sm-10">-->
                <!--                <input type="date" class="form-control" id="dob" value="2000-01-01" disabled>-->
                <!--            </div>-->
                <!--        </div>-->

                <!-- Other input fields -->
                <!--</div>-->
                <!-- Icon on the right -->
                <!--<div class="col-sm-2 text-sm-right mb-3">-->
                <!--    <div class="image-container bg-gradient-blue rounded-circle text-center p-2">-->
                <!--        <img src="assets/img/Checked User Male.png" alt="" class="img-fluid rounded-circle" style="max-width: 100%; height: auto;">-->
                <!--    </div>-->
                <!--</div>-->


                <!-- <div class="col-sm-2 text-sm-right mb-3">
                                    <input type="file" id="profileImage" name="profileImage" accept="image/*">
                                </div> -->

                <!--</form>-->

    <?php
            }
        }
    }
    ?>
    <!--</div>-->

</div>
</div>
</div>

</div>
</section>



</div>
<?php
include("includes/Footer.php")
?>






<script>
    const statesAndUTs = [{
            name: "Andhra Pradesh",
            code: "AP"
        },
        {
            name: "Arunachal Pradesh",
            code: "AR"
        },
        {
            name: "Assam",
            code: "AS"
        },
        {
            name: "Bihar",
            code: "BR"
        },
        {
            name: "Chhattisgarh",
            code: "CG"
        },
        {
            name: "Goa",
            code: "GA"
        },
        {
            name: "Gujarat",
            code: "GJ"
        },
        {
            name: "Haryana",
            code: "HR"
        },
        {
            name: "Himachal Pradesh",
            code: "HP"
        },
        {
            name: "Jharkhand",
            code: "JH"
        },
        {
            name: "Karnataka",
            code: "KA"
        },
        {
            name: "Kerala",
            code: "KL"
        },
        {
            name: "Madhya Pradesh",
            code: "MP"
        },
        {
            name: "Maharashtra",
            code: "MH"
        },
        {
            name: "Manipur",
            code: "MN"
        },
        {
            name: "Meghalaya",
            code: "ML"
        },
        {
            name: "Mizoram",
            code: "MZ"
        },
        {
            name: "Nagaland",
            code: "NL"
        },
        {
            name: "Odisha",
            code: "OD"
        },
        {
            name: "Punjab",
            code: "PB"
        },
        {
            name: "Rajasthan",
            code: "RJ"
        },
        {
            name: "Sikkim",
            code: "SK"
        },
        {
            name: "Tamil Nadu",
            code: "TN"
        },
        {
            name: "Telangana",
            code: "TG"
        },
        {
            name: "Tripura",
            code: "TR"
        },
        {
            name: "Uttar Pradesh",
            code: "UP"
        },
        {
            name: "Uttarakhand",
            code: "UK"
        },
        {
            name: "West Bengal",
            code: "WB"
        },
        {
            name: "Andaman and Nicobar Islands",
            code: "AN"
        },
        {
            name: "Chandigarh",
            code: "CH"
        },
        {
            name: "Dadra and Nagar Haveli and Daman and Diu",
            code: "DN"
        },
        {
            name: "Lakshadweep",
            code: "LD"
        },
        {
            name: "Delhi",
            code: "DL"
        },
        {
            name: "Puducherry",
            code: "PY"
        }
    ];

    let stateCounters = JSON.parse(localStorage.getItem('stateCounters')) || {};

    function generateUniqueID(stateCode) {
        if (!stateCounters[stateCode]) {
            stateCounters[stateCode] = {
                prefix: 'A',
                number: 1
            };
        } else if (stateCounters[stateCode].number === 999) {
            stateCounters[stateCode].prefix = 'B';
            stateCounters[stateCode].number = 1;
        }

        let counter = stateCounters[stateCode];
        let randomNumber = Math.floor(Math.random() * 999) + 1;
        let uniqueID = counter.prefix + String(randomNumber).padStart(3, '0');

        counter.number++;

        localStorage.setItem('stateCounters', JSON.stringify(stateCounters));

        return uniqueID;
    }

    function checkUserIDExistence(userID, callback) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "config/user-data.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    callback(xhr.responseText === "exists");
                } else {
                    console.error("Error checking user ID existence.");
                }
            }
        };
        xhr.send("check-user-id=" + encodeURIComponent(userID));
    }

    function submitUserID(resultValue, countryInput, stateInput, usredreg) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "config/user-data.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert("User ID has been created successfully");
                    console.log("User ID sent to the database successfully.");
                } else {
                    console.error("Error sending user ID to the database.");
                }
                location.reload(); // Reload the page
            }
        };
        xhr.send("user-id=" + encodeURIComponent(resultValue) + "&country=" + encodeURIComponent(countryInput) +
            "&state=" + encodeURIComponent(stateInput) + "&usredreg=" + encodeURIComponent(usredreg));
    }

    document.getElementById("submitButton").addEventListener("click", function(event) {
        event.preventDefault();

        let countryInput = document.getElementById('cntry').value.trim().substring(0, 2).toUpperCase();
        let stateInput = document.getElementById('stt2').value.trim().toUpperCase();
        let usredreg = document.getElementById('usredreg').value.trim().toUpperCase();

        if (!countryInput || !stateInput) {
            alert('Please fill in all fields.');
            return;
        }

        let state = statesAndUTs.find(s => s.name.toUpperCase() === stateInput.toUpperCase() || s.code === stateInput.toUpperCase());
        if (!state) {
            alert('Invalid state.');
            return;
        }

        let stateCode = state.code;
        let generateAndCheckID = () => {
            let uniqueID = generateUniqueID(stateCode);
            let resultValue = countryInput + "B" + stateCode + uniqueID;

            checkUserIDExistence(resultValue, exists => {
                if (exists) {
                    generateAndCheckID();
                } else {
                    document.getElementById('result').value = resultValue;
                    submitUserID(resultValue, countryInput, stateInput, usredreg);
                }
            });
        };

        generateAndCheckID();
    });
</script>




















<script>
    function checkPinCode() {
        // Get the entered pin code from the form
        const pincode = document.getElementById('pinCode').value;

        // Call the fetchData function with the entered pin code
        fetchData(pincode);
    }

    async function fetchData(pincode) {
        try {
            const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();

            if (data[0].Status === "Success") {

                const district = data[0].PostOffice[0].District;
                console.log(`District: ${district}`);
                document.getElementById('city').value = district;

                document.getElementById('error-msgs').textContent = '';
            } else {

                document.getElementById('error-msgs').textContent = 'Invalid Pin Code. Please try again.';
                alert('Wrong Pin Code');
                console.log("khfguk")
                // document.getElementById('error-msgs').textContent = 'Invalid Pin Code. Please try again.';
                // document.getElementById('error-msgs').value = "error";
                // Handle the error, show a message to the user, etc.
            }
        } catch (error) {
            console.error(`Error: ${error.message}`);
        }
    }
</script>
<script>
    function addCourseSection() {
        // Clone the existing course section
        var courseSection = document.getElementById('courseContainer').cloneNode(true);

        // Clear values in the cloned section
        var selects = courseSection.getElementsByTagName('select');
        for (var i = 0; i < selects.length; i++) {
            selects[i].selectedIndex = 0;
        }

        // Append the cloned section to the container
        document.getElementById('courseContainer').appendChild(courseSection);
    }
</script>