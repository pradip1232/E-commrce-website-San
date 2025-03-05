<?php

// session_start();

include "includes/auth.php";
include "includes/header.php";
include "includes/sidebar.php";
include "config/conn.php";
// require_once "config/fetch_orderedPurchased.php";
?>


<main class="main-content">
    <div class="container-fluid">

        <?php

        // print_r($_SESSION);
        $sub_state = $_SESSION['sub_admin_state'] ?? "";
        // echo "Admin " . $sub_state;

        $adminStates = ["Jammu", "Punjab", "Haryana", "Himachal pradesh"];

        function assignOrder($orderState)
        {
            global $sub_state, $adminStates, $admin_type;

            if ($admin_type == "Admin") {
                return true;
            }

            if ($sub_state == "punjab" && in_array($orderState, $adminStates)) {
                return true;
            } elseif ($sub_state == "Delhi" && !in_array($orderState, $adminStates)) {
                return true;
            }

            return false;
        }


        $admin_type = $_SESSION["admin_type"] ?? "";

        // Fetch data from database
        $sql = "SELECT * FROM user_purchases";
        $result = $conn->query($sql);

        $data = [];

        if ($result->num_rows > 0) {
            // echo "<h3>Processing Orders...</h3>";
            while ($row = $result->fetch_assoc()) {
                // Check if order should be displayed for this admin
                if (assignOrder($row['user_state'])) {
                    $data[] = $row;
                }
            }
        } else {
            echo "<h3>No orders found in the database.</h3>";
        }

        // Debug: Display all filtered orders
        // echo "<h3>Filtered Orders for Sub-Admin:</h3>";
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        ?>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .table-responsive {
                margin-top: 20px;
            }

            .pagination {
                justify-content: center;
            }
        </style>

        <h5 class="mt-3">User Purchases (Filtered by Admin)</h5>
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search products...">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User Email</th>
                        <th>User State</th>
                        <th>Product SKU</th>
                        <th>Quantity</th>
                        <th>Payment Status</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    <?php if (!empty($data)) {
                        foreach ($data as $row) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['user_email'] ?></td>
                                <td><?= $row['user_state'] ?></td>
                                <td><?= $row['product_sku'] ?></td>
                                <td><?= $row['product_quantity'] ?></td>
                                <td><?= $row['payment_status'] ?></td>
                                <td><?= $row['purchase_date'] ?></td>
                                <td>
                                    <button class="btn btn-primary viewDetails"
                                        data-id="<?= $row['id'] ?>"
                                        data-email="<?= $row['user_email'] ?>"
                                        data-state="<?= $row['user_state'] ?>"
                                        data-sku="<?= $row['product_sku'] ?>"
                                        data-quantity="<?= $row['product_quantity'] ?>"
                                        data-status="<?= $row['payment_status'] ?>"
                                        data-date="<?= $row['purchase_date'] ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailsModal">
                                        GO For Delivery
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">No orders found for your assigned states.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <!-- Order Details Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID:</strong> <span id="modalId"></span></p>
                        <p><strong>User Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>User State:</strong> <span id="modalState"></span></p>
                        <p><strong>Product SKU:</strong> <span id="modalSku"></span></p>
                        <p><strong>Quantity:</strong> <span id="modalQuantity"></span></p>
                        <p><strong>Payment Status:</strong> <span id="modalStatus"></span></p>
                        <p><strong>Purchase Date:</strong> <span id="modalDate"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Confirm Delivery</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Controls -->
        <nav>
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#" id="prevPage">
                        < </a>
                </li>
                <li class="page-item"><a class="page-link" href="#" id="nextPage"> > </a></li>
            </ul>
        </nav>

        <!-- Bootstrap & jQuery for Pagination -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                let rowsPerPage = 10; // Number of rows per page
                let rows = $("#orderTable tr");
                let totalRows = rows.length;
                let currentPage = 0;

                function showPage(page) {
                    rows.hide();
                    rows.slice(page * rowsPerPage, (page + 1) * rowsPerPage).show();
                }

                $("#nextPage").click(function(e) {
                    e.preventDefault();
                    if ((currentPage + 1) * rowsPerPage < totalRows) {
                        currentPage++;
                        showPage(currentPage);
                    }
                });

                $("#prevPage").click(function(e) {
                    e.preventDefault();
                    if (currentPage > 0) {
                        currentPage--;
                        showPage(currentPage);
                    }
                });


                // Search Functionality
                $("#searchInput").on("keyup", function() {
                    let value = $(this).val().toLowerCase();
                    rows.each(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });

                // Show first page initially
                showPage(0);
            });
        </script>


        <script>
            $(document).ready(function() {
                $(".viewDetails").click(function() {
                    let id = $(this).data("id");
                    let email = $(this).data("email");
                    let state = $(this).data("state");
                    let sku = $(this).data("sku");
                    let quantity = $(this).data("quantity");
                    let status = $(this).data("status");
                    let date = $(this).data("date");

                    // Fill modal with data
                    $("#modalId").text(id);
                    $("#modalEmail").text(email);
                    $("#modalState").text(state);
                    $("#modalSku").text(sku);
                    $("#modalQuantity").text(quantity);
                    $("#modalStatus").text(status);
                    $("#modalDate").text(date);
                });
            });
        </script>



    </div>
</main>






<?php

include("includes/footer.php");

?>