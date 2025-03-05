<?php
include('includes/header.php');
include('includes/already-auth.php');
// session_start();
// Check if there is a status message to display
$statusMessage = isset($_SESSION["Status"]) ? $_SESSION["Status"] : '';

// Clear the status message after displaying it
unset($_SESSION["Status"]);
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

<section class="login-body">
    <div class="container login-container mt-5 pt-5">
        <div class="login-form">
            <h2 class="text-center sign-headding">Sign In / Register</h2>

            <?php if ($statusMessage): ?>
                <div class="alert alert-warning">
                    <?php echo htmlspecialchars($statusMessage); ?>
                </div>
            <?php endif; ?>
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']); // Clear the error message
            }
            ?>
            <form id="loginForm" method="post">
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Login</button>
                <div class="text-center mt-3">
                    <a href="#">Forgot Password?</a>
                </div>
                <div class="text-center mt-2">
                    <span>Don't have an account? <a href="signup">Sign Up</a></span>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
    document.getElementById('loginForm324234').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        fetch('config/user_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("data.redirect_url      " + data.redirect_url);
                    // window.location.href = data.redirect_url;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>


<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- The message from the server will be inserted here -->
            </div>
            <!-- Close button outside of modal header -->
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px;">-->
            <!--    <span aria-hidden="true">&times;</span>-->
            <!--</button>-->
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#responseModal').on('shown.bs.modal', function () {
            setTimeout(function() {
                $('#responseModal').modal('hide');
            }, 5000);   
        });
    });
</script>


<script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Check if fields are empty
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!email || !password) {
        alert('Please fill in both email and password fields.');
        return;
    }

    const formData = new FormData(this);

    fetch('config/user_login.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            console.log('Server response:', data);

            // Show modal with server message
            const modalBody = document.querySelector('#responseModal .modal-body');
            if (modalBody) {
                modalBody.innerHTML = data.message;
                $('#responseModal').modal('show');

                if (data.success) {
                    // Store user email in localStorage and sessionStorage
                    localStorage.setItem('userEmail', data.email);
                    sessionStorage.setItem('userEmail', data.email);

                    // Redirect after closing the modal
                    $('#responseModal').on('hidden.bs.modal', function() {
                        window.location.href = data.redirect_url;
                    });
                }
            } else {
                // If modal body not found, log the error
                console.error('Modal element not found.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while processing your request: ' + error.message);
        });
});

</script>



<?php
include('includes/footer.php');
?>