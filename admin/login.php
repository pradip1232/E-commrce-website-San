<?php
// Start the session
session_start();

if (isset($_SESSION['sub_admin_logged_in']) && $_SESSION['sub_admin_logged_in'] == true) {
    header("Location: dashboard");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanjiveeka</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-12/assets/css/login-12.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <!-- Login 12 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-5">
                        <h2 class="display-5 fw-bold text-center">Sign in</h2>
                        <!-- <p class="text-center m-0">Don't have an account? <a href="#!">Sign up</a></p> -->
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="row gy-5 justify-content-center">
                        <div class="col-12 col-lg-10">
                            <form id="loginForm">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control border-0 border-bottom rounded-0"
                                                name="email" id="email" placeholder="enter your user id" required>
                                            <label for="email" class="form-label">User Id</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" class="form-control border-0 border-bottom rounded-0"
                                                name="password" id="password" placeholder="Password" required>
                                            <label for="password" class="form-label">Password</label>
                                            <i class="bi bi-eye-slash position-absolute end-0 top-50 translate-middle-y pe-3"
                                                id="togglePassword" style="cursor: pointer;"></i>
                                        </div>
                                        <script>
                                            // Toggle Password Visibility
                                            document.getElementById('togglePassword').addEventListener('click', function() {
                                                const passwordInput = document.getElementById('password');
                                                const icon = this;

                                                // Check input type and toggle
                                                if (passwordInput.type === 'password') {
                                                    passwordInput.type = 'text';
                                                    icon.classList.remove('bi-eye-slash');
                                                    icon.classList.add('bi-eye');
                                                } else {
                                                    passwordInput.type = 'password';
                                                    icon.classList.remove('bi-eye');
                                                    icon.classList.add('bi-eye-slash');
                                                }
                                            });
                                        </script>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me" required>
                                            <label class="form-check-label text-secondary" for="remember_me">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-dark rounded-0 fs-6" type="submit">Log in</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="notificationBar" class="alert d-none fixed-top text-center" role="alert"></div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>



    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this); // Collect form data

            fetch('config/admin_login.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        const userDetails = data.user_data;

                        // Save user details in sessionStorage
                        sessionStorage.setItem('subAdminDetails', JSON.stringify(userDetails));

                        // Optionally save in localStorage for persistent storage
                        localStorage.setItem('subAdminDetails', JSON.stringify(userDetails));

                        // Show success notification
                        showNotification('success', data.message);

                        // Redirect to dashboard after 2 seconds
                        setTimeout(() => {
                            window.location.href = 'dashboard'; // Adjust the dashboard URL
                        }, 2000);
                    } else {
                        // Show error notification
                        showNotification('danger', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('danger', 'An unexpected error occurred. Please try again.');
                });
        });

        // Function to show notifications
        function showNotification(type, message) {
            const notificationBar = document.getElementById('notificationBar');
            notificationBar.className = `alert alert-${type} fixed-top text-center`;
            notificationBar.textContent = message;
            notificationBar.classList.remove('d-none');

            // Auto-hide notification after 3 seconds
            setTimeout(() => {
                notificationBar.classList.add('d-none');
            }, 3000);
        }
    </script>

</body>

</html>