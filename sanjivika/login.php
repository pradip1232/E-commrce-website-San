<?php
include ('includes/header.php');
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
    .sign-headding{
        font-family: Roboto;
font-size: 24px;
font-weight: 700;
line-height: 28.13px;
text-align: center;
color:#482607;
    }
    .btn-success21{
        background-color:  #77C712;
        color:white;
    }
</style>

<section class="login-body">
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center sign-headding">Sign In / Register</h2>
            <form>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-success21 btn-block">Login</button>
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

<?php
include ('includes/footer.php');
?>
