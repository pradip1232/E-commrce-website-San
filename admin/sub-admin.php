<?php
// if (session_status() == PHP_SESSION_NONE) {
//     // Start the session only if it's not already started
//     session_start();
// }
include "includes/auth.php";
include "includes/header.php";
include "includes/sidebar.php";
include "config/conn.php";

?>











<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-2">
                    <div class="card-header d-flex justify-content-between align-items-center p-2">
                        <h4 class="mb-0">Sub Admin</h4>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#subAdminModal">
                            Add New Sub Admin +
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php

    // Now you can safely use the session
    if (isset($_SESSION)) {
        // print_r($_SESSION);
    } else {
        // echo "No session data available.";
    }
    // $aa = 'admin001';
    $aa = $_SESSION['sub_admin_id'];

    // $bb = $_SESSION['name'];
    // echo "user id " . $aa;


    $admin = 'admin001';


    if ($aa == $admin) {
        // Query to fetch all sub-admins
        $sql = "SELECT * FROM sub_admins";
        $result = $conn->query($sql);

    ?>

        <div class="container-fluid mt-4">
            <h4 class="text-center mb-4 text-primary fw-bold">Sub-Admin Management</h4>
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle text-center table-striped">
                        <thead class="bg-primaryy text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>State</th>
                                <th>Edit </th>
                                <th>Delete </th>
                                <th>Upload </th>
                            </tr>
                        </thead>
                        <tbody class="animate__animated animate__fadeIn">
                            <?php
                            // Check if records are found
                            if ($result->num_rows > 0) {
                                $i = 1; // Counter for serial number
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $i++ . '</td>'; // Serial number
                                    echo '<td>' . htmlspecialchars($row['name']) . '</td>'; // Name
                                    echo '<td>' . htmlspecialchars($row['user_id']) . '</td>'; // User ID
                                    echo '<td>' . htmlspecialchars($row['password']) . '</td>'; // User ID
                                    echo '<td>' . htmlspecialchars($row['state']) . '</td>'; // State

                                    // Access rights with Bootstrap badges
                                    echo '<td><span class="badge ' . ($row['edit_access'] ? 'bg-success' : 'bg-danger') . '">' . ($row['edit_access'] ? 'Yes' : 'No') . '</span></td>';
                                    echo '<td><span class="badge ' . ($row['delete_access'] ? 'bg-success' : 'bg-danger') . '">' . ($row['delete_access'] ? 'Yes' : 'No') . '</span></td>';
                                    echo '<td><span class="badge ' . ($row['upload_access'] ? 'bg-success' : 'bg-danger') . '">' . ($row['upload_access'] ? 'Yes' : 'No') . '</span></td>';
                                    // Edit and Delete buttons
                                    echo '<td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-user_id="' . $row['user_id'] . '" data-state="' . $row['state'] . '" data-edit_access="' . $row['edit_access'] . '" data-delete_access="' . $row['delete_access'] . '" data-upload_access="' . $row['upload_access'] . '">Edit</button>
                                    <button class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            data-id="' . $row['id'] . '" 
                                            data-name="' . $row['name'] . '" 
                                            data-user_id="' . $row['user_id'] . '" 
                                            data-state="' . $row['state'] . '" 
                                            data-edit_access="' . $row['edit_access'] . '" 
                                            data-delete_access="' . $row['delete_access'] . '" 
                                            data-upload_access="' . $row['upload_access'] . '" 
                                            onclick="openDeleteModal(this)">Delete</button>   
                                            </td>';
                                    echo '</tr>';
                                }
                            } else {
                                // If no records are found
                                echo '<tr><td colspan="7" class="text-muted">No Sub-Admins Found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php
    }
    ?>



    <?php
    $conn->close();
    ?>

</main>



<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sub-Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSubAdminForm">
                    <!-- <input type="" class="form-control" id="editName" name="name" required> -->
                    <div class="mb-3">
                        <label for="editName" class="form-label">Sub-Admin Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserId" class="form-label">User ID <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="editUserId" name="user_id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editState" class="form-label">State</label>
                        <input type="text" class="form-control" id="editState" name="state" required>
                    </div>

                    <label class="form-label">Access Rights</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editAccess" name="editAccess">
                        <label class="form-check-label" for="editAccess">Edit Access</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="deleteAccess" name="deleteAccess">
                        <label class="form-check-label" for="deleteAccess">Delete Access</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="uploadAccess" name="uploadAccess">
                        <label class="form-check-label" for="uploadAccess">Upload Product Access</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate Edit Modal with data
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const userId = button.getAttribute('data-user_id');
        const name = button.getAttribute('data-name');
        const state = button.getAttribute('data-state');
        const editAccess = button.getAttribute('data-edit_access') === '1';
        const deleteAccess = button.getAttribute('data-delete_access') === '1';
        const uploadAccess = button.getAttribute('data-upload_access') === '1';
        const subAdminId = button.getAttribute('data-id'); // Get sub-admin ID for editing

        // Set the values in the modal
        document.getElementById('editUserId').value = userId;
        document.getElementById('editName').value = name;
        document.getElementById('editState').value = state;
        document.getElementById('editAccess').checked = editAccess;
        document.getElementById('deleteAccess').checked = deleteAccess;
        document.getElementById('uploadAccess').checked = uploadAccess;
        document.getElementById('subAdminId').value = subAdminId; // Set ID in hidden input
    });

    // Submit form data to update sub-admin details
    document.getElementById('editSubAdminForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        const formData = new FormData(this);
        formData.append('action', 'update_sub_admin'); // Action to update sub-admin

        // Send the form data to the server
        fetch('config/update_sub_admin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Sub-Admin updated successfully');
                    location.reload();
                } else {
                    alert('Error updating Sub-Admin');
                }
            })
            .catch(error => alert('Error: ' + error));
    });
</script>



<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Sub-Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Dynamic message displaying the user ID to be deleted -->
                <p id="deleteMessage"></p>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript to handle Delete -->
<script>
    // Function to open the modal and set the user ID dynamically
    function openDeleteModal(button) {
        // Get the user_id from the clicked button's data attributes
        const userId = button.getAttribute('data-user_id');

        // Display the user ID in the modal for confirmation
        document.getElementById('deleteMessage').textContent = `Are you sure you want to delete the sub-admin with user ID: ${userId}?`;

        // Store the user ID in the variable to be used when confirming the deletion
        userIdToDelete = userId;

        // Show the modal
        $('#deleteModal').modal('show');
    }

    // Event listener for the "Delete" button inside the modal
    document.getElementById('confirmDelete').addEventListener('click', function() {
        // Make an AJAX request to delete the sub-admin
        fetch('config/delete_sub_admin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userIdToDelete
                })
            })
            .then(response => response.json())
            .then(data => {
                // Handle response
                if (data.status === "success") {
                    alert("Sub-Admin deleted successfully!");
                    location.reload(); // Reload the page after successful deletion
                } else {
                    alert("Error deleting sub-admin: " + data.message);
                }
            })
            .catch(error => {
                alert("Error: " + error);
            });

        // Hide the modal after deleting
        $('#deleteModal').modal('hide');
    });
</script>





<!-- Modal for Sub Admin Creation -->
<div class="modal fade" id="subAdminModal" tabindex="-1" aria-labelledby="subAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subAdminModalLabel">Create New Sub Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subAdminForm">
                    <!-- Sub Admin Name -->
                    <div class="mb-3">
                        <label for="subAdminName" class="form-label">Sub Admin Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subAdminName" name="subAdminName" required>
                    </div>

                    <!-- Auto-Generated User ID -->
                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="userId" name="userId" readonly>
                    </div>

                    <!-- Auto-Generated Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Auto-Generated Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="password" name="password" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">Choose State</label>
                        <select class="form-select" id="state" name="state" required>
                            <option value="" disabled selected>Select a State</option>
                            <?php
                            // Array of all Indian states
                            $states = [
                                "Andhra Pradesh",
                                "Arunachal Pradesh",
                                "Assam",
                                "Bihar",
                                "Chhattisgarh",
                                "Goa",
                                "Gujarat",
                                "Haryana",
                                "Himachal Pradesh",
                                "Jharkhand",
                                "Karnataka",
                                "Kerala",
                                "Madhya Pradesh",
                                "Maharashtra",
                                "Manipur",
                                "Meghalaya",
                                "Mizoram",
                                "Nagaland",
                                "Odisha",
                                "Punjab",
                                "Rajasthan",
                                "Sikkim",
                                "Tamil Nadu",
                                "Telangana",
                                "Tripura",
                                "Uttar Pradesh",
                                "Uttarakhand",
                                "West Bengal",
                                "Andaman and Nicobar Islands",
                                "Chandigarh",
                                "Dadra and Nagar Haveli and Daman and Diu",
                                "Lakshadweep",
                                "Delhi",
                                "Puducherry"
                            ];

                            // Loop through the states array and generate dropdown options
                            foreach ($states as $state) {
                                echo "<option value='$state'>$state</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Access Rights -->
                    <div class="mb-3">
                        <label class="form-label">Access Rights</label>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editAccess" name="editAccess">
                                    <label class="form-check-label" for="editAccess">Edit Access</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deleteAccess" name="deleteAccess">
                                    <label class="form-check-label" for="deleteAccess">Delete Access</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="uploadAccess" name="uploadAccess">
                                    <label class="form-check-label" for="uploadAccess">Upload Product Access</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Create Sub Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('subAdminForm');
        const userIdField = document.getElementById('userId');
        const passwordField = document.getElementById('password');

        // Generate unique User ID and Password on modal open
        document.getElementById('subAdminModal').addEventListener('show.bs.modal', function() {
            // Generate a unique User ID (example: user002)
            const timestamp = Date.now().toString();
            const uniqueId = `Admin${timestamp.slice(-3)}`;
            userIdField.value = uniqueId;

            // Generate a random password (6-8 characters)
            const randomPassword = Math.random().toString(36).slice(-8);
            passwordField.value = randomPassword;
        });

        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect form data
            const formData = new FormData(form);

            // AJAX call to server-side script
            fetch('config/sub_admin.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Sub Admin created successfully!');
                        location.reload(); // Reload the page to see changes
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred.');
                });
        });
    });
</script>


<?php
include "includes/footer.php";
?>