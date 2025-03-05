<?php

// session_start();

include "includes/auth.php";
include "includes/header.php";
include "includes/sidebar.php";
include "config/conn.php";

?>


<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid">
        <!-- product and category card here  -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">Products</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewproduct">
                                Add New
                            </button>
                        </div>


                        <div class="table-responsive">
                            <table class="table align-middle">

                                <?php

                                // Query to fetch all products
                                // $productsql = "SELECT * FROM products";
                                // $productresult = $conn->query($productsql);

                                // $products = [];

                                // if ($productresult->num_rows > 0) {
                                //     while ($row = $productresult->fetch_assoc()) {
                                //         $products[] = $row;
                                //     }
                                //     // echo json_encode($products, JSON_PRETTY_PRINT);
                                // } else {
                                //     echo json_encode(["message" => "No products found"]);
                                // }
                                $productsql = "SELECT * FROM products";
                                $productresult = $conn->query($productsql);

                                $products = [];

                                if ($productresult->num_rows > 0) {
                                    while ($row = $productresult->fetch_assoc()) {
                                        $products[] = $row;
                                    }
                                }

                                ?>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Benefits</th>
                                        <th>Selected Tags</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($product['product_name']) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars($product['product_category']) ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary"><?= htmlspecialchars($product['product_benefits']) ?></span>
                                                </td>
                                                <td style="width: 150px; white-space: normal; word-wrap: break-word;">
                                                    <?php
                                                    $firstDecode = json_decode($product['selected_tags'], true);

                                                    if (json_last_error() === JSON_ERROR_NONE && is_string($firstDecode)) {
                                                        $selectedTags = json_decode($firstDecode, true);
                                                    } else {
                                                        $selectedTags = $firstDecode;
                                                    }

                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($selectedTags)) {
                                                        foreach ($selectedTags as $tag) {
                                                            echo "<span class='badge bg-success me-1'>" . htmlspecialchars($tag) . "</span> ";
                                                        }
                                                    } else {
                                                        echo "<span class='badge bg-warning'>No tags available</span>";
                                                    }
                                                    ?>
                                                </td>


                                                <td>Stock(1)</td>

                                                <!-- Action Column with Dropdown -->
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            ⋮ <!-- Unicode for three vertical dots -->
                                                        </button>

                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="#<?= htmlspecialchars($product['product_id']) ?>">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger delete-product" href="#" data-id="<?= htmlspecialchars($product['product_id']) ?>">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item open-modal" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addNewProductInventory"
                                                                    data-sku="<?= htmlspecialchars($product['product_sku']) ?>"
                                                                    data-name="<?= htmlspecialchars($product['product_name']) ?>"
                                                                    data-product_id="<?= htmlspecialchars($product['product_id']) ?>">
                                                                    <i class="fas fa-plus"></i> Add New Inventory
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No products found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>


                                <!-- <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><strong>Sunil Joshi</strong><br><small class="text-muted">Web Designer</small></td>
                                        <td>Elite Admin</td>
                                        <td><span class="badge bg-primary">Low</span></td>
                                        <td>$3.9</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td><strong>Andrew McDownland</strong><br><small class="text-muted">Project Manager</small></td>
                                        <td>Real Homes WP Theme</td>
                                        <td><span class="badge bg-secondary">Medium</span></td>
                                        <td>$24.5k</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td><strong>Christopher Jamil</strong><br><small class="text-muted">Project Manager</small></td>
                                        <td>MedicalPro WP Theme</td>
                                        <td><span class="badge bg-danger">High</span></td>
                                        <td>$12.8k</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td><strong>Nirav Joshi</strong><br><small class="text-muted">Frontend Engineer</small></td>
                                        <td>Hosting Press HTML</td>
                                        <td><span class="badge bg-success">Critical</span></td>
                                        <td>$2.4k</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td><strong>Tim Geroge</strong><br><small class="text-muted">Web Designer</small></td>
                                        <td>Hosting Press HTML</td>
                                        <td><span class="badge bg-purple text-white">Critical</span></td>
                                        <td>$5.4k</td>
                                    </tr>
                                </tbody> -->
                            </table>
                        </div>
                    </div>
                </div>




            </div>
        </div>

        <!-- tags and product quantity here  -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">Product Tags</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewpproducttags">
                                Add New
                            </button>
                        </div>


                        <?php

                        // Set the number of rows per page
                        $rowsPerPage = 5;

                        // Get the current page from the URL (default to 1 if not set)
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $rowsPerPage;

                        // Get the total number of rows
                        $totalQuery = "SELECT COUNT(*) AS total FROM product_tags";
                        $totalResult = mysqli_query($conn, $totalQuery);
                        $totalRows = mysqli_fetch_assoc($totalResult)['total'];

                        // Calculate the total number of pages
                        $totalPages = ceil($totalRows / $rowsPerPage);

                        // Fetch the rows for the current page
                        $query = "SELECT tag_name FROM product_tags LIMIT $offset, $rowsPerPage";
                        $result = mysqli_query($conn, $query);

                        // HTML Table
                        ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tags</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = $offset + 1; // Starting index for the current page
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $tags[] = $row;
                                        // print_r($tags);
                                    ?>
                                        <tr>
                                            <td><?php echo $index; ?></td>
                                            <td><strong><?php echo htmlspecialchars($row["tag_name"]); ?></strong></td>
                                        </tr>
                                    <?php
                                        $index++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-evenly">
                            <!-- Previous Button -->
                            <a href="?page=<?php echo $currentPage - 1; ?>" class="btn btn-secondary <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                                &laquo;
                            </a>

                            <!-- Next Button -->
                            <a href="?page=<?php echo $currentPage + 1; ?>" class="btn btn-secondary <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                                &raquo;
                            </a>
                        </div>


                    </div>
                </div>
                <!-- Upcoming Package -->
                <!-- <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">Product Packaging</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewcategory">
                                Add New
                            </button>
                        </div>


                    </div>
                </div> -->

                <!-- prouct category -->
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold">Category</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewcategory">
                                Add New
                            </button>
                        </div>

                        <?php

                        $rowsPerPage = 5;

                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $rowsPerPage;

                        $totalQuery = "SELECT COUNT(*) AS total FROM product_categories";
                        $totalResult = mysqli_query($conn, $totalQuery);
                        $totalRows = mysqli_fetch_assoc($totalResult)['total'];

                        $totalPages = ceil($totalRows / $rowsPerPage);

                        $query = "SELECT category_name ,sub_category_name FROM product_categories LIMIT $offset, $rowsPerPage";
                        $result = mysqli_query($conn, $query);

                        ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = $offset + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // print_r($row);
                                    ?>
                                        <tr>
                                            <td><?php echo $index; ?></td>
                                            <td><strong><?php echo htmlspecialchars($row["category_name"]); ?></strong></td>
                                            <td><strong><?php echo htmlspecialchars($row["sub_category_name"]); ?></strong></td>
                                        </tr>
                                    <?php
                                        $index++;
                                    }

                                    $query = "SELECT category_name ,sub_category_name FROM product_categories";
                                    $result = mysqli_query($conn, $query);

                                    $categories = [];
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // print_r(($row));
                                            $categories[] = $row;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-evenly">
                            <a href="?page=<?php echo $currentPage - 1; ?>" class="btn btn-secondary <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                                &laquo;
                            </a>
                            <a href="?page=<?php echo $currentPage + 1; ?>" class="btn btn-secondary <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                                &raquo;
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <!-- product Inventory card here  -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="fw-bold m-0">Products Inventory</h5>
                            <input type="text" id="inventorySearch" class="form-control w-25" placeholder="Search Inventory...">
                        </div>
                        <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewProductinventory">
                            + Add New
                        </button> -->



                        <div class="table-responsive">
                            <table class="table align-middle" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <!-- <th>Price</th> -->
                                        <th>Packaging</th>
                                        <th>Cost Price</th>
                                        <th>Discount(%)</th>
                                        <th>Selling Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <?php

                                // Query to fetch all products
                                // $productsql = "SELECT * FROM products";
                                // $productresult = $conn->query($productsql);

                                // $products = [];

                                // if ($productresult->num_rows > 0) {
                                //     while ($row = $productresult->fetch_assoc()) {
                                //         $products[] = $row;
                                //     }
                                //     // echo json_encode($products, JSON_PRETTY_PRINT);
                                // } else {
                                //     echo json_encode(["message" => "No products found"]);
                                // }

                                $productsql = "SELECT * FROM products";
                                $productresult = $conn->query($productsql);

                                $products = [];

                                if ($productresult->num_rows > 0) {
                                    while ($row = $productresult->fetch_assoc()) {
                                        $products[] = $row;
                                    }
                                }
                                ?>
                                <tbody>
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $index => $product): ?>
                                            <?php
                                            $productDetails = json_decode($product['product_details'], true);

                                            // Check if product_details contains valid batch data
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails) && count($productDetails) > 0):
                                                $rowspan = count($productDetails); // Number of batches
                                                $firstRow = true;

                                                foreach ($productDetails as $batch => $details): ?>
                                                    <tr>
                                                        <?php if ($firstRow): ?>
                                                            <td rowspan="<?= $rowspan ?>"><?= $index + 1 ?></td>
                                                            <td rowspan="<?= $rowspan ?>">
                                                                <strong><?= htmlspecialchars($product['product_name']) ?></strong><br>
                                                                <small class="text-muted"><?= htmlspecialchars($product['product_category']) ?></small>
                                                            </td>
                                                        <?php endif; ?>

                                                        <td><?= strtoupper($batch) ?></td> <!-- Batch Name -->
                                                        <td>₹<?= htmlspecialchars($details['cost_price']) ?></td> <!-- Cost Price -->
                                                        <td><?= htmlspecialchars($details['discount']) ?>%</td> <!-- Discount -->
                                                        <td>₹<?= htmlspecialchars($details['selling_price']) ?></td> <!-- Selling Price -->
                                                        <td>
                                                            <?php if (!empty($details['stock_quantity']) && $details['stock_quantity'] > 0): ?>
                                                                <span class="badge bg-success">In Stock (<?= $details['stock_quantity'] ?>)</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Out of Stock</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <!-- <button class="btn btn-primary btn-sm">Edit</button> -->
                                                            <a class="btn btn-danger btn-sm delete-product-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteProductInventory"
                                                                data-batch_number="<?= strtoupper($batch) ?>"
                                                                data-sku="<?= htmlspecialchars($product['product_sku']) ?>"
                                                                data-name="<?= htmlspecialchars($product['product_name']) ?>"
                                                                data-product_id="<?= htmlspecialchars($product['product_id']) ?>">
                                                                Delete
                                                            </a>

                                                        </td>
                                                    </tr>
                                            <?php
                                                    $firstRow = false;
                                                endforeach;
                                            endif;
                                            ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7">No products found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>



                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</main>


<!-- modal for deleting the batche product  -->
<!-- Delete Product Inventory Modal -->
<div class="modal fade" id="deleteProductInventory" tabindex="-1" aria-labelledby="deleteProductInventoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductInventoryLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this batch?</p>
                <p><strong>Product:</strong> <span id="delete-product-name"></span></p>
                <p><strong>Batch Number:</strong> <span id="delete-batch-number"></span></p>
                <p><strong>SKU:</strong> <span id="delete-product-sku"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let deleteProductId, deleteBatchNumber, deleteSku;

        // When delete button is clicked, transfer data to modal
        document.querySelectorAll(".delete-product-btn").forEach(button => {
            button.addEventListener("click", function() {
                deleteProductId = this.getAttribute("data-product_id");
                deleteBatchNumber = this.getAttribute("data-batch_number");
                deleteSku = this.getAttribute("data-sku");

                document.getElementById("delete-product-name").innerText = this.getAttribute("data-name");
                document.getElementById("delete-batch-number").innerText = deleteBatchNumber;
                document.getElementById("delete-product-sku").innerText = deleteSku;
            });
        });

        // Handle confirm delete button click
        document.getElementById("confirm-delete").addEventListener("click", function() {
            fetch("config/delete_inventory.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `product_id=${deleteProductId}&batch_number=${deleteBatchNumber}&sku=${deleteSku}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Batch deleted successfully!");
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
</script>















<?php
$productsql = "SELECT * FROM products";
$productresult = $conn->query($productsql);

$products = [];

if ($productresult->num_rows > 0) {
    while ($row = $productresult->fetch_assoc()) {
        $products[] = $row;
    }
}
?>


<!-- product inventory adding for modal  -->
<div class="modal fade" id="addNewProductInventory" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newaddproductinventory">

                    <input type="hidden" id="productinventorySKU" name="product_sku">
                    <input type="hidden" id="productinventoryid" name="product_id">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="productinventoryName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productinventoryName" name="product_name" readonly>
                        </div>
                    </div>

                    <!-- Pricing & Cost -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="costPrice" class="form-label">Cost Price</label>
                            <input type="number" class="form-control" id="costPrice" name="costPrice" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="discount" class="form-label">Discount (%)</label>
                            <input type="number" class="form-control" id="discount" name="discount" min="0" max="100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sellingPrice" class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="sellingPrice" name="sellingPrice" min="0" required readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="MRP" class="form-label">MRP</label>
                            <input type="number" class="form-control" id="MRP" name="MRP" min="0">
                        </div>
                    </div>

                    <!-- Stock & Inventory Management -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stockQuantity" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="stockQuantity" name="stockQuantity" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="packaging" class="form-label">Packaging</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="packaging" name="packaging" placeholder="Enter the Packaging: 10, 75">
                                <select class="form-select" id="unit" name="unit" required style="max-width: 80px;">
                                    <option value="gm">gm</option>
                                    <option value="kg">kg</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <!-- offers -->
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="offers" class="form-label">Offers % (Optional)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="offers" name="offers" placeholder="Enter the offers: 10, 15 %">
                                <select class="form-select" id="unit" name="unit" required style="max-width: 150px;">
                                    <option value="none">select one</option>
                                    <option value="Holi">Holi</option>
                                    <option value="Diwali">Diwali</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Inventory</button>
                    </div>
                </form>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const costPriceInput = document.getElementById("costPrice");
                        const discountInput = document.getElementById("discount");
                        const sellingPriceInput = document.getElementById("sellingPrice");

                        function calculateSellingPrice() {
                            let costPrice = parseFloat(costPriceInput.value) || 0;
                            let discount = parseFloat(discountInput.value) || 0;

                            if (costPrice < 0 || discount < 0) {
                                alert("Cost Price and Discount cannot be negative!");
                                costPriceInput.value = Math.max(0, costPrice);
                                discountInput.value = Math.max(0, discount);
                                return;
                            }

                            if (discount > 100) {
                                alert("Discount cannot be more than 100%");
                                discountInput.value = 100;
                                discount = 100;
                            }

                            let sellingPrice = costPrice - (costPrice * discount / 100);
                            sellingPriceInput.value = sellingPrice.toFixed(2);
                        }

                        costPriceInput.addEventListener("input", calculateSellingPrice);
                        discountInput.addEventListener("input", calculateSellingPrice);
                    });
                </script>


            </div>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".open-modal").forEach(button => {
                button.addEventListener("click", function() {
                    let sku = this.getAttribute("data-sku");
                    let name = this.getAttribute("data-name");
                    let id = this.getAttribute("data-product_id");

                    document.getElementById("productinventorySKU").value = sku;
                    document.getElementById("productinventoryName").value = name;
                    document.getElementById("productinventoryid").value = id;
                });
            });
        });
    </script>


    <!-- ajax call for add new product inventry  -->
    <script>
        $(document).ready(function() {
            $("#newaddproductinventory").on("submit", function(e) {
                e.preventDefault();

                let formData = {
                    product_sku: $("#productinventorySKU").val(),
                    product_id: $("#productinventoryid").val(),
                    product_name: $("#productinventoryName").val(),
                    cost_price: $("#costPrice").val(),
                    discount: $("#discount").val(),
                    selling_price: $("#sellingPrice").val(),
                    mrp: $("#MRP").val(),
                    stock_quantity: $("#stockQuantity").val(),
                    packaging_details: $("#packaging").val() + " " + $("#unit").val()
                };

                $.ajax({
                    url: "config/add_new_inventory_product.php", // PHP file to handle the request
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            alert("Product inventory updated successfully!");
                            // location.reload(); // Reload the page after successful update
                        } else {
                            alert("Error updating inventory: " + response.message);
                        }
                    },
                    error: function() {
                        alert("Something went wrong. Please try again.");
                    }
                });
            });
        });
    </script>
</div>

















<!-- Add products Modal -->
<div class="modal fade" id="addnewproduct" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addproductnew">
                    <!-- Tag Search and Selected Tags Section -->
                    <div class="form-group position-relative">
                        <label for="productID" class="form-label">Select Tags <span class="text-danger">*</span></label>

                        <input type="text" id="tagSearch" class="form-control" placeholder="Search tags">

                        <div id="tagButtons" class="mt-2"></div>

                        <!-- Hidden input to store selected tags as JSON -->
                        <input type="hidden" id="selectedTagsInput" name="selectedTags">
                    </div>

                    <div class="mt-3" id="selectedTags"></div>


                    <!-- Product ID and SKU -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productID" class="form-label">Product ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="productID" name="productID" placeholder="Auto-generated ID" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productSKU" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="productSKU" name="productSKU" placeholder="Auto-generated SKU" readonly>
                        </div>
                    </div>

                    <!-- Product Name and Category -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productName" class="form-label">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productCategory" class="form-label">Category <span class="text-danger">*</span> </label>
                            <select class="form-control" id="productCategory" name="productCategory" required>
                                <option value="">Select Category</option>
                                <?php
                                // Display categories and subcategories in the dropdown
                                foreach ($categories as $category) {
                                    if (!empty($category['sub_category_name'])) {
                                        echo '<option value="' . htmlspecialchars($category['sub_category_name']) . '">' . htmlspecialchars($category['category_name'] . ' - ' . $category['sub_category_name']) . '</option>';
                                    } else {
                                        echo '<option value="' . htmlspecialchars($category['category_name']) . '">' . htmlspecialchars($category['category_name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Key Benefits with Dynamic Addition -->
                    <div class="row mb-3">
                        <label class="form-label">Key Benefits <span class="text-danger">*</span></label>
                        <div id="keyBenefitsContainer" class="col-md-12">
                            <div class="mb-2">
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit">
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="addKeyBenefit" class="btn btn-sm btn-secondary mt-2">Add More Key Benefits</button>
                        </div>
                    </div>

                    <!-- Text Areas for Product Details -->
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Product Description <span class="text-danger">*</span> </label>
                        <textarea class="form-control word-limit" id="productDescription" name="productDescription" rows="3" placeholder="Enter product description" required></textarea>
                        <small class="text-muted"><span id="descCount">0</span>/200</small>
                    </div>

                    <div class="mb-3">
                        <label for="productBenefits" class="form-label">Product Benefits</label>
                        <textarea class="form-control word-limit" id="productBenefits" name="productBenefits" rows="3" placeholder="Enter product benefits"></textarea>
                        <small class="text-muted"><span id="benefitsCount">0</span>/200</small>
                    </div>

                    <div class="mb-3">
                        <label for="productUsage" class="form-label">Product Usage</label>
                        <textarea class="form-control word-limit" id="productUsage" name="productUsage" rows="3" placeholder="Enter product usage"></textarea>
                        <small class="text-muted text-end"><span id="usageCount">0</span>/200</small>
                    </div>

                    <!-- JavaScript for Live Word Count -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const textareas = document.querySelectorAll(".word-limit");

                            textareas.forEach(textarea => {
                                textarea.addEventListener("input", function() {
                                    let words = this.value.trim().split(/\s+/); // Splitting words
                                    let wordCount = words[0] === "" ? 0 : words.length;
                                    let maxWords = 200;
                                    let counter = this.nextElementSibling.querySelector("span");

                                    // If word limit exceeded, trim text
                                    if (wordCount > maxWords) {
                                        this.value = words.slice(0, maxWords).join(" ");
                                        wordCount = maxWords;
                                    }

                                    counter.textContent = wordCount;
                                });
                            });
                        });
                    </script>



                    <!-- Image Upload with Dynamic Addition -->
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <div class="row image-upload-row mb-2">
                                <div class="col-md-10">
                                    <label for="productImg" class="form-label">Product Main Images <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="productImg[]" required>
                                </div>
                            </div>
                            <div id="mediaUploadContainer">
                                <div class="row media-upload-row mb-2">
                                    <div class="col-md-10">
                                        <label for="productMedia" class="form-label">Additional Product Media (Images or Videos)</label>
                                        <input type="file" class="form-control" name="productMedia[]" accept="image/*,video/*">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-secondary add-image" title="Add new image">Add New Image</button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm" id="submitButton">Save Productt</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <!-- ajax call for adding new product in db  -->
    <script>
        $(document).ready(function() {
            $("#addproductnew").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                const formData = new FormData(this); // Collect form data

                console.log("FormData contents before submission:");
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                $.ajax({
                    url: "config/add_basic_product.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        // console.log("Server Response:", response);
                        if (response.success) {
                            alert("Product added successfully!");
                            $("#addproductnew")[0].reset();
                            $("#addnewproduct").modal("hide");
                        } else {
                            alert("Error: " + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("Failed to add product. Please check the console for details.");
                    }
                });
            });
        });
    </script>

</div>

<!-- Add products category Modal -->
<div class="modal fade" id="addnewcategory" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClientModalLabel">Add New Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addnewproductcategory">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" class="form-control" id="subcategoryname" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add Category</button>
                </form>
                <script>
                    $(document).ready(function() {
                        $("#addnewproductcategory").submit(function(e) {
                            e.preventDefault();
                            let categoryName = $("#categoryname").val();
                            let subcategoryName = $("#subcategoryname").val();

                            $.ajax({
                                url: "config/product_add_category.php",
                                type: "POST",
                                data: {
                                    category_name: categoryName,
                                    subcategory_name: subcategoryName
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.success) {
                                        alert("Category added successfully!");
                                        // location.reload();
                                        $(' #addnewproductcategory')[0].reset();
                                    } else {
                                        alert("Error: " + response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    alert(" AJAX Error: " + error);
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Tags Modal -->
<div class=" modal fade" id="addnewpproducttags" tabindex="-1" aria-labelledby="addProductTagsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductTagsModalLabel">Add New Product Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductTagForm">
                    <div class="mb-3">
                        <label class="form-label">Tag Name</label>
                        <input type="text" class="form-control" id="tagname" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add Tag</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ajax for products tags  -->
<script>
    $(document).ready(function() {
        $("#addProductTagForm").submit(function(event) {
            event.preventDefault();

            let tagName = $("#tagname").val().trim();
            if (tagName === "") {
                alert("Tag Name cannot be empty!");
                return;
            }

            $.ajax({
                url: "config/add_product_tag.php",
                type: "POST",
                data: {
                    tagname: tagName
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        alert("Tag added successfully!");
                        $("#addProductTagForm")[0].reset();
                        $("#addnewproducttags").modal("hide");
                    } else {
                        alert("Error: " + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("Failed to add tag. Please check console for errors.");
                }
            });
        });
    });
</script>


















<!-- // JavaScript to add new  rows -->
<script>
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('add-quantity')) {
            const quantityContainer = document.getElementById('quantityContainer');
            const newQuantityRow = document.querySelector('.quantity-row').cloneNode(true);

            // Clear values in the cloned row
            newQuantityRow.querySelectorAll('input, select').forEach(input => input.value = '');

            // Append the cloned row to the container
            quantityContainer.appendChild(newQuantityRow);
        }
    });

    // JavaScript to dynamically add key benefit fields
    document.getElementById('addKeyBenefit').addEventListener('click', function() {
        const keyBenefitsContainer = document.getElementById('keyBenefitsContainer');
        const newBenefitField = document.createElement('div');
        newBenefitField.classList.add('mb-2');
        newBenefitField.innerHTML = '<input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>';
        keyBenefitsContainer.appendChild(newBenefitField);
    });

    // JavaScript to add new image upload fields
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('add-image')) {
            const imageUploadContainer = document.getElementById('imageUploadContainer');
            const newImageRow = document.querySelector('.image-upload-row').cloneNode(true);

            // Clear the file input in the cloned row
            newImageRow.querySelector('input[type="file"]').value = '';

            // Append the cloned row to the container
            imageUploadContainer.appendChild(newImageRow);
        }
    });
</script>

<!-- create the id or sku  -->
<script>
    // Auto-generate SKU and Product ID when the modal is opened
    document.getElementById('addnewproduct').addEventListener('show.bs.modal', function() {
        document.getElementById('productSKU').value = generateUniqueSKU();
        document.getElementById('productID').value = generateUniqueProductID();
    });

    function generateUniqueSKU() {
        return 'SKU' + Math.floor(100000000000 + Math.random() * 900000000000);
    }

    function generateUniqueProductID() {
        return 'PROD-' + Math.floor(1000000000 + Math.random() * 9000000000);
    }
</script>


<!-- // Load tags from PHP -->
<script>
    const tags = <?php echo json_encode($tags); ?>;
    let selectedTags = []; // Array to store selected tags

    // Display all tag buttons
    function displayTagButtons(tags) {
        const tagButtons = $('#tagButtons');
        tagButtons.empty();

        tags.forEach(tag => {
            tagButtons.append(`
                            <button type="button" class="btn btn-outline-primary m-1 tag-button" data-tag="${tag.tag_name}">
                                ${tag.tag_name}
                            </button>
                        `);
        });
    }

    // Initialize with all tags
    displayTagButtons(tags);

    // Search tags and filter buttons
    $('#tagSearch').on('input', function() {
        const searchText = $(this).val().toLowerCase();
        const filteredTags = tags.filter(tag => tag.tag_name.toLowerCase().includes(searchText));
        displayTagButtons(filteredTags);
    });

    // Update hidden input with JSON string of selected tags
    function updateSelectedTagsInput() {
        $('#selectedTagsInput').val(JSON.stringify(selectedTags));
    }

    // Function to display selected tags visually
    function displaySelectedTags() {
        const selectedTagsDiv = $('#selectedTags');
        selectedTagsDiv.empty(); // Clear previous tags
        selectedTags.forEach(tag => {
            selectedTagsDiv.append(`
                                <span class="badge bg-primary tag-badge m-1" data-tag="${tag}">${tag}</span>
                            `);
        });
    }

    // Handle tag button click
    $(document).on('click', '.tag-button', function() {
        const tagName = $(this).data('tag');

        // Toggle selection state
        if ($(this).hasClass('btn-primary')) {
            // Remove tag from selectedTags
            selectedTags = selectedTags.filter(tag => tag !== tagName);
            $(this).removeClass('btn-primary').addClass('btn-outline-primary');
            $(`#selectedTags .tag-badge[data-tag="${tagName}"]`).remove();
        } else {
            // Add tag to selectedTags
            selectedTags.push(tagName);
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            $('#selectedTags').append(`
                                <span class="badge bg-primary tag-badge m-1" data-tag="${tagName}">${tagName}</span>
                            `);
        }

        // Update hidden input field
        updateSelectedTagsInput();

        // Debugging: Log selected tags to verify selection state
        console.log('Selected Tags:', selectedTags);
    });
</script>









<script>
    document.addEventListener("DOMContentLoaded", function() {
        var dropdowns = document.querySelectorAll(".dropdown-toggle");
        dropdowns.forEach(function(dropdown) {
            dropdown.addEventListener("click", function(event) {
                event.stopPropagation();
                var menu = this.nextElementSibling;
                if (menu) {
                    menu.classList.toggle("show");
                }
            });
        });

        document.addEventListener("click", function() {
            document.querySelectorAll(".dropdown-menu").forEach(function(menu) {
                menu.classList.remove("show");
            });
        });
    });
</script>

<!-- JavaScript for Search Functionality -->
<script>
    document.getElementById("inventorySearch").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#inventoryTable tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
<?php

// session_start();

include "includes/footer.php";

?>