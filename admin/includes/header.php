<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <!-- <link rel="icon" type="image/png" href="assets/img/favicon.png"> -->
    <link rel="icon" href="assets/img/header-logo.webp" type="image/png">

    <title>
        Sanjiveeka
    </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-5gFRUayRHNHjz92AI9ZHkNps9q7TwkNiYev6ML7fDj7r3eR0tw1SKhA/1mBTb5uv" crossorigin="anonymous">

    <!-- Bootstrap JavaScript Bundle with Popper (required for modals to function) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-QF2eTRxG5sJL9vlb1mu7fHrVfu84xCqPiTtXBcUIrKxyGJz5drFhdbDEpbe34i1d" crossorigin="anonymous"></script>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <!-- <link href="../assets/css/nucleo-icons.css" rel="stylesheet" /> -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/custom.css">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <style>
        table {
            /* overflow-y: hidden; */
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 5px;
            /* border: 1px solid #ced4da; */
            /* border-radius: 4px; */
            /* background-color: #f8f9fa; */
        }

        .tag {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 5px;
            /* border: 1px solid #ced4da; */
            /* border-radius: 4px; */
            /* background-color: #f8f9fa; */
        }

        .tag {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            color: white;
            transition: background-color 0.3s;
        }

        .tag.selected {
            background-color: #28a745;
            /* Green */
        }

        .tag.unselected {
            background-color: #ffc107;
            /* Yellow */
        }


        .dropdown-menu {
            min-width: 150px;
            text-align: center;
        }

        /* Style for the logout button */
        .logout-btn {
            background-color: #f44336;
            /* Red background for the logout button */
            color: white;
            /* White text */
            border: none;
            /* Remove border */
            padding: 8px 16px;
            /* Add padding */
            border-radius: 4px;
            /* Round corners */
            display: flex;
            /* Flexbox to align icon and text */
            align-items: center;
            /* Vertically align icon and text */
            cursor: pointer;
            /* Change cursor to pointer */
            transition: background-color 0.3s ease;
            /* Smooth transition for hover */
        }

        /* Add margin between the icon and text */
        .logout-btn i {
            margin-right: 8px;
        }

        /* Hover effect */
        .logout-btn:hover {
            background-color: #d32f2f;
            /* Darker red on hover */
        }

        /* Focus effect */
        .logout-btn:focus {
            outline: none;
            /* Remove default focus outline */
            box-shadow: 0 0 0 2px rgba(244, 67, 54, 0.6);
            /* Red focus outline */
        }


        #logoutBtn:hover {
            color: white;
            /* text-decoration: underline; */
        }

        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-100">



    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tables</li>
                    </ol>
                </nav> -->
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline">
                            <label class="form-label">Type here...</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <ul class="navbar-nav d-flex align-items-center  justify-content-end">

                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item dropdown pe-3 d-flex align-items-center">

                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                                    <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown d-flex align-items-center">
                            <button id="logoutBtn" class="dropdown-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

    </main>