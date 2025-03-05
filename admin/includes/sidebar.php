<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand   m-0" href="#" target="_blank" style="display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: center;
    align-items: flex-end;">
            <img src="assets/img/header-logo.webp" class="navbar-brand-img" width="126" height="77" alt="main_logo">
            <!-- <span class="ms-1 text-sm text-dark">LOGO</span> -->
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-dark  bg-gradient-darkk text-white2" href="dashboard">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="new-product">
                    <!-- <a class="nav-link text-dark" href="products"> -->
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-l  ink-text ms-1">My Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="new-orders">
                    <!-- <a class="nav-link text-dark" href="products"> -->
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-l  ink-text ms-1">Orders</span>
                </a>
            </li>
            <?php
            include "config/conn.php";
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
                <li class="nav-item">
                    <a class="nav-link text-dark" href="sub-admin">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Sub Admin</span>
                    </a>
                </li>

            <?php
            }
            ?>
            <!-- <li class="nav-item">
                <a class="nav-link text-dark" href="products2.php">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-l  ink-text ms-1">My Products 2</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">
                    <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">
                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/rtl.html">
                    <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/notifications.html">
                    <i class="material-symbols-rounded opacity-5">notifications</i>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/profile.html">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/sign-in.html">
                    <i class="material-symbols-rounded opacity-5">login</i>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="../pages/sign-up.html">
                    <i class="material-symbols-rounded opacity-5">assignment</i>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> -->
        </ul>
    </div>
    <!-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn btn-outline-dark mt-4 w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree" type="button">Documentation</a>
            <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
        </div>
    </div> -->
</aside>