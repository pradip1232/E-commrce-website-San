<?php
             ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
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

            <?php
         

            $e = $_SESSION['user_email'];

// SELECT `id`, `name`, `gender`, `mobile`, `state`, `country`, `email`, `password`, `full_add`, `timestamp` FROM `user_data` WHERE 1
            $sql = "SELECT `name`, `gender`, `mobile`, `state`, `country`, `email`, `timestamp` 
            FROM `user_data` 
            WHERE `email` = '$e'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the data
                $user = $result->fetch_assoc();
            } else {
                echo "No user found!";
            }


            // print_r($user);



            // $conn->close();
            ?>

            <!-- Edit Profile Button -->
            <button type="button" class="btn float-right" id="editProfileBtn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit Profile
            </button>

            <div class="container mt-5">
                <form class="row g-4">
                    <div class="col-md-6">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName"
                            value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail"
                            value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userGender" class="form-label">Gender</label>
                        <input type="text" class="form-control" id="userGender"
                            value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userMobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="userMobile"
                            value="<?php echo htmlspecialchars($user['mobile']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userState" class="form-label">State</label>
                        <input type="text" class="form-control" id="userState"
                            value="<?php echo htmlspecialchars($user['state']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userCountry" class="form-label">Country</label>
                        <input type="text" class="form-control" id="userCountry"
                            value="<?php echo htmlspecialchars($user['country']); ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="userTimestamp" class="form-label">Account Created On</label>
                        <input type="text" class="form-control" id="userTimestamp"
                            value="<?php echo htmlspecialchars($user['timestamp']); ?>" readonly>
                    </div>
                </form>

                <div class="col-xl-12 col-lg-12 mt-5">
                    <form id="checkoutForm" method="POST">
                        <div class="cardd shadoww border-0">
                            <div class="p-4">
                                <h5 class="mb-4">Your Addresses</h5>
                               
                            </div>
                        </div>


                        <!-- Edit Address Modal -->
                        <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAddressModalLabel">Edit Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editAddressForm">
                                            <input type="hidden" id="editKey">
                                            <div class="mb-3">
                                                <label for="editLine1" class="form-label">Address Line 1</label>
                                                <input type="text" class="form-control" id="editLine1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editLine2" class="form-label">Address Line 2</label>
                                                <input type="text" class="form-control" id="editLine2" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editLandmark" class="form-label">Landmark</label>
                                                <input type="text" class="form-control" id="editLandmark" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editCity" class="form-label">City</label>
                                                <input type="text" class="form-control" id="editCity" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editState" class="form-label">State</label>
                                                <input type="text" class="form-control" id="editState" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editPinCode" class="form-label">Pin Code</label>
                                                <input type="text" class="form-control" id="editPinCode" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Edit Address Functionality
                            document.getElementById('editAddressForm').addEventListener('submit', (e) => {
                                e.preventDefault();
                                const key = document.getElementById('editKey').value;
                                const updatedAddress = {
                                    line1: document.getElementById('editLine1').value,
                                    line2: document.getElementById('editLine2').value,
                                    landmark: document.getElementById('editLandmark').value,
                                    city: document.getElementById('editCity').value,
                                    state: document.getElementById('editState').value,
                                    pinCode: document.getElementById('editPinCode').value,
                                };

                                fetch('config/edit_address.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            key,
                                            address: updatedAddress
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            alert('Address updated successfully.');
                                            location.reload(); // Reload page to reflect changes
                                        } else {
                                            alert('Failed to update address.');
                                        }
                                    });
                            });

                            // Delete Address Functionality
                            document.querySelectorAll('.delete-address').forEach(icon => {
                                icon.addEventListener('click', () => {
                                    const key = icon.closest('.address-card').dataset.key;
                                    if (confirm('Are you sure you want to delete this address?')) {
                                        fetch('config/delete_address.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    key
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.status === 'success') {
                                                    alert('Address deleted successfully.');
                                                    icon.closest('.address-card').remove(); // Remove card from UI
                                                } else {
                                                    alert('Failed to delete address.');
                                                }
                                            });
                                    }
                                });
                            });
                        </script>

                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

                    </form>
                </div>
            </div>

            <!-- Modal for Adding New Address -->
            <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addressModalLabel">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="newAddressForm">
                                <div class="mb-3">
                                    <label for="line1" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" id="line1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="landmark" class="form-label">Landmark</label>
                                    <input type="text" class="form-control" id="landmark" required>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" required>
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pinCode" class="form-label">Pin Code</label>
                                    <input type="text" class="form-control" id="pinCode" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Save Address</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7ie1Vf3qPt19MGR/aQwxaF5g6X7SkZZU9G6" crossorigin="anonymous">

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <!-- Name and Email Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modalUserName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="modalUserName" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="modalUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="modalUserEmail" name="email" readonly>
                        </div>
                    </div>

                    <!-- Gender and Mobile Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modalUserGender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="modalUserGender" name="gender">
                        </div>
                        <div class="col-md-6">
                            <label for="modalUserMobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="modalUserMobile" name="mobile" readonly>
                        </div>
                    </div>

                    <!-- State and Country Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="modalUserState" class="form-label">State</label>
                            <input type="text" class="form-control" id="modalUserState" name="state">
                        </div>
                        <div class="col-md-6">
                            <label for="modalUserCountry" class="form-label">Country</label>
                            <input type="text" class="form-control" id="modalUserCountry" name="country">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                <button type="button" id="saveChangesBtn" class="btn ">Save changes</button>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>





<script>
    $(document).ready(function() {
        // Check if the user data is loaded correctly
        var userData = <?php echo json_encode($user); ?>;
        // console.log('User Data:', userData);
        // alert(userData);
        $('#editProfileBtn').on('click', function() {
            console.log('Edit Profile Button Clicked');

            // Check if individual fields are being populated correctly
            $('#modalUserName').val(userData.name);
            // console.log('Name:', userData.name);

            $('#modalUserEmail').val(userData.email);
            // console.log('Email:', userData.email);

            $('#modalUserGender').val(userData.gender);
            // console.log('Gender:', userData.gender);

            $('#modalUserMobile').val(userData.mobile);
            // console.log('Mobile:', userData.mobile);

            $('#modalUserState').val(userData.state);
            // console.log('State:', userData.state);

            $('#modalUserCountry').val(userData.country);
            // console.log('Country:', userData.country);
        });

        $('#saveChangesBtn').on('click', function() {
            var updatedData = {
                name: $('#modalUserName').val(),
                email: $('#modalUserEmail').val(),
                gender: $('#modalUserGender').val(),
                mobile: $('#modalUserMobile').val(),
                state: $('#modalUserState').val(),
                country: $('#modalUserCountry').val()
            };

            console.log('Updated Data:', updatedData); // Debugging the updated data

            $.ajax({
                url: 'config/update_user_info.php', // PHP script to handle the update
                type: 'POST',
                data: updatedData,
                success: function(response) {
                    console.log('AJAX Response:', response); // Debugging the AJAX response
                    if (response === 'success') {
                        alert('Profile updated successfully!');
                        window.location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to update profile.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to update user info:', error);
                }
            });
        });
    });
</script>

















<?php
include('includes/footer.php');
?>