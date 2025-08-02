<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table th,
        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .form-control,
        .form-select,
        textarea.form-control {
            min-width: 200px;
            width: 100%;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 60px;
        }

        .tax-rate-container {
            min-width: 200px;
        }

        .image-upload-container {
            min-width: 250px;
        }

        .image-upload-group {
            margin-bottom: 10px;
        }

        .btn-add-image {
            margin-top: 5px;
        }

        .btn {
            white-space: nowrap;
        }

        @media (max-width: 768px) {

            .form-control,
            .form-select,
            textarea.form-control {
                min-width: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Page Content -->
        <div class="main-content">
            <!-- Topbar -->
            <?php include 'includes/topbar.php'; ?>

            <!-- Main Content Area -->
            <div class="content-wrapper">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                $file = "pages/{$page}.php";
                if (file_exists($file)) {
                    include $file;
                } else {
                    include 'pages/dashboard.php';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
</body>

</html>