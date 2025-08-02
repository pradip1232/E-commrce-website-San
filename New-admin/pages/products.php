    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-gray-800">Products</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search by Product Name..." style="width: 200px;" onkeyup="liveSearch()">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered datatable" id="productTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Enable/Disable</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'config/db_con.php';
                                    try {
                                        $sql = "SELECT p.*, i.inventory_number
                                                FROM products p
                                                LEFT JOIN inventory i ON p.product_id = i.product_id";
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . (isset($row['product_id']) ? htmlspecialchars($row['product_id']) : 'NA') . "</td>";
                                                echo "<td>" . (isset($row['images']) ? "<img src='" . htmlspecialchars($row['images']) . "' alt='Product Image' style='width:50px;'>" : 'NA') . "</td>";
                                                echo "<td>" . (isset($row['product_name']) ? htmlspecialchars($row['product_name']) : 'NA') . "</td>";
                                                echo "<td>" . (isset($row['product_category']) ? htmlspecialchars($row['product_category']) : 'NA') . "</td>";
                                                echo "<td>" . (isset($row['product_status']) ? htmlspecialchars($row['product_status']) : 'NA') . "</td>";
                                                echo "<td>
                                                        <div class='form-check form-switch'>
                                                            <input class='form-check-input toggle-status'
                                                                type='checkbox'
                                                                data-id='" . htmlspecialchars($row['product_id']) . "'
                                                                " . ($row['product_status'] == 'enabled' ? 'checked' : '') . ">
                                                        </div>
                                                      </td>";
                                                echo "<td>
                                                        <button class='btn btn-sm btn-info editProductBtn'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#editProductModal'
                                                            data-id='" . htmlspecialchars($row['product_id']) . "'
                                                            data-inventory-number='" . (isset($row['inventory_number']) ? htmlspecialchars($row['inventory_number']) : '') . "'
                                                            data-sku='" . (isset($row['product_sku']) ? htmlspecialchars($row['product_sku']) : '') . "'
                                                            data-name='" . (isset($row['product_name']) ? htmlspecialchars($row['product_name']) : '') . "'
                                                            data-category='" . (isset($row['product_category']) ? htmlspecialchars($row['product_category']) : '') . "'
                                                            data-hsn='" . (isset($row['hsn_number']) ? htmlspecialchars($row['hsn_number']) : '') . "'
                                                            data-tax-rate='" . (isset($row['tax_rate']) ? htmlspecialchars($row['tax_rate']) : '') . "'
                                                            data-key-benefits='" . (isset($row['key_benefits']) ? htmlspecialchars($row['key_benefits']) : '') . "'
                                                            data-description='" . (isset($row['description']) ? htmlspecialchars($row['description']) : '') . "'
                                                            data-benefits='" . (isset($row['product_benefits']) ? htmlspecialchars($row['product_benefits']) : '') . "'
                                                            data-usage='" . (isset($row['product_usage']) ? htmlspecialchars($row['product_usage']) : '') . "'
                                                            data-images='" . (isset($row['images']) ? htmlspecialchars($row['images']) : '') . "'
                                                            data-videos='" . (isset($row['videos']) ? htmlspecialchars($row['videos']) : '') . "'>
                                                            <i class='fas fa-edit'></i>
                                                        </button>
                                                        <button class='btn btn-sm btn-danger deleteProductBtn'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#deleteProductModal'
                                                            data-id='" . htmlspecialchars($row['product_id']) . "'
                                                            data-name='" . (isset($row['product_name']) ? htmlspecialchars($row['product_name']) : '') . "'>
                                                            <i class='fas fa-trash'></i>
                                                        </button>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center'>No products found in your database.</td></tr>";
                                        }
                                        mysqli_close($conn);
                                    } catch (Exception $e) {
                                        echo "<tr><td colspan='7' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:95%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product SKU</th>
                                            <th>Product Name</th>
                                            <th>Product Category</th>
                                            <th>HSN Number</th>
                                            <th>Tax Rate</th>
                                            <th>Key Benefits</th>
                                            <th>Description</th>
                                            <th>Ingredient</th>
                                            <th>Product Usage</th>
                                            <th>Images</th>
                                            <th>Videos</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productRows">
                                        <tr>
                                            <td><input type="text" class="form-control" name="productId" readonly></td>
                                            <td><input type="text" class="form-control" name="productSku" readonly></td>
                                            <td><input type="text" class="form-control" name="productName" required></td>
                                            <td>
                                                <select class="form-select" name="productCategory" required>
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    include 'config/db_con.php';
                                                    $result = $conn->query("SELECT sub_category_name FROM categories");
                                                    if ($result) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['sub_category_name']) . '">' . htmlspecialchars($row['sub_category_name']) . '</option>';
                                                        }
                                                        mysqli_close($conn);
                                                    } else {
                                                        echo '<option value="">No categories available</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <!-- <input type="text" class="form-control" name="hsnNumber" required> -->
                                                <select class="form-select" name="hsnNumber" required>
                                                    <option value="">Select HSN Number</option>
                                                    <?php
                                                    include 'config/db_con.php';
                                                    $result = $conn->query("SELECT hsn_number FROM hsn_codes");
                                                    if ($result) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['hsn_number']) . '">' . htmlspecialchars($row['hsn_number']) . '</option>';
                                                        }
                                                        mysqli_close($conn);
                                                    } else {
                                                        echo '<option value="">No HSN Numbers available</option>';
                                                    }
                                                    ?>
                                                </select>


                                            </td>
                                            <td>
                                                <div class="tax-rate-container">
                                                    <select class="form-select tax-category" name="taxCategory" required>
                                                        <option value="">Select Tax Category</option>
                                                        <?php
                                                        include 'config/db_con.php';
                                                        $categoryQuery = $conn->query("SELECT DISTINCT category FROM tax_rates");
                                                        if ($categoryQuery && $categoryQuery->num_rows > 0) {
                                                            while ($row = $categoryQuery->fetch_assoc()) {
                                                                $cat = htmlspecialchars($row['category']);
                                                                echo "<option value=\"$cat\">$cat</option>";
                                                            }
                                                            mysqli_close($conn);
                                                        } else {
                                                            echo '<option value="">No categories found</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="tax-rate-value" name="taxRate">
                                                    <div class="tax-rate-display mt-2">
                                                        Tax Rate: <span class="rate-value">--</span>%
                                                        <span class="tax-loading" style="display: none;">(Loading...)</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><textarea class="form-control" name="keyBenefits" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" name="description" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" name="productBenefits" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" name="productUsage" rows="2" required></textarea></td>
                                            <td>
                                                <div class="image-upload-container">
                                                    <div class="image-upload-group">
                                                        <input type="file" class="form-control" name="productImages[]" accept="image/*" required>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-add-image btn-sm">Add New Image</button>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="productVideos" multiple accept="video/*">
                                                <small class="text-muted">Upload videos</small>
                                            </td>
                                            <td><button type="button" class="btn btn-danger remove-row btn-sm">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" id="addRow">Add New Item</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveProduct">Save Product</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product SKU</th>
                                            <th>Inventory Number</th>
                                            <th>Product Name</th>
                                            <th>Product Category</th>
                                            <th>HSN Number</th>
                                            <th>Tax Rate</th>
                                            <th>Key Benefits</th>
                                            <th>Description</th>
                                            <th>Ingredient</th>
                                            <th>Product Usage</th>
                                            <th>Images</th>
                                            <th>Videos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" id="editProductId" name="productId" readonly></td>
                                            <td><input type="text" class="form-control" id="editProductSku" name="productSku" readonly></td>
                                            <td><input type="text" class="form-control" id="editInventoryNumber" name="inventoryNumber" readonly></td>
                                            <td><input type="text" class="form-control" id="editProductName" name="productName" required></td>
                                            <td>
                                                <select class="form-select" id="editProductCategory" name="productCategory" required>
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    include 'config/db_con.php';
                                                    $result = $conn->query("SELECT sub_category_name FROM categories");
                                                    if ($result) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . htmlspecialchars($row['sub_category_name']) . '">' . htmlspecialchars($row['sub_category_name']) . '</option>';
                                                        }
                                                        mysqli_close($conn);
                                                    } else {
                                                        echo '<option value="">No categories available</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" id="editHsnNumber" name="hsnNumber" required></td>
                                            <td>
                                                <div class="tax-rate-container">
                                                    <select class="form-select tax-category" id="editTaxCategory" name="taxCategory" required>
                                                        <option value="">Select Tax Category</option>
                                                        <?php
                                                        include 'config/db_con.php';
                                                        $categoryQuery = $conn->query("SELECT DISTINCT category FROM tax_rates");
                                                        if ($categoryQuery && $categoryQuery->num_rows > 0) {
                                                            while ($row = $categoryQuery->fetch_assoc()) {
                                                                $cat = htmlspecialchars($row['category']);
                                                                echo "<option value=\"$cat\">$cat</option>";
                                                            }
                                                            mysqli_close($conn);
                                                        } else {
                                                            echo '<option value="">No categories found</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="tax-rate-value" id="editTaxRate" name="taxRate">
                                                    <div class="tax-rate-display mt-2">
                                                        Tax Rate: <span class="rate-value">--</span>%
                                                        <span class="tax-loading" style="display: none;">(Loading...)</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><textarea class="form-control" id="editKeyBenefits" name="keyBenefits" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" id="editDescription" name="description" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" id="editProductBenefits" name="productBenefits" rows="2" required></textarea></td>
                                            <td><textarea class="form-control" id="editProductUsage" name="productUsage" rows="2" required></textarea></td>
                                            <td>
                                                <div class="image-upload-container">
                                                    <div class="image-upload-group">
                                                        <input type="file" class="form-control" name="productImages[]" accept="image/*">
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-add-image btn-sm">Add New Image</button>
                                                    <div class="current-images mt-2"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="productVideos" multiple accept="video/*">
                                                <small class="text-muted">Upload videos</small>
                                                <div class="current-videos mt-2"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveEditProduct">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="deleteProductForm">
                            <input type="hidden" id="deleteProductId" name="productId">
                            Are you sure you want to delete <strong id="deleteProductName"></strong>? (<span id="deleteProductIds"></span>)
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="confirmDeleteProduct">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pagination
            const rowsPerPage = 8;
            let currentPage = 1;

            function displayTable(page) {
                const rows = $('#productTable tbody tr');
                const totalRows = rows.length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.hide().slice(start, end).show();
                $('#pagination').empty();
                for (let i = 1; i <= totalPages; i++) {
                    $('#pagination').append(`
                        <li class="page-item ${i === page ? 'active' : ''}">
                            <a class="page-link" href="#">${i}</a>
                        </li>
                    `);
                }
                $('#pagination .page-link').on('click', function(e) {
                    e.preventDefault();
                    currentPage = parseInt($(this).text());
                    displayTable(currentPage);
                });
            }
            displayTable(currentPage);

            // Live Search
            $('#searchInput').on('keyup', function() {
                const input = $(this).val().toLowerCase();
                $('#productTable tbody tr').each(function() {
                    const productName = $(this).find('td').eq(2).text().toLowerCase();
                    $(this).toggle(productName.includes(input));
                });
                displayTable(1); // Reset to first page
            });

            // Toggle Product Status
            $('.toggle-status').on('change', function() {
                const productId = $(this).data('id');
                const newStatus = this.checked ? 'enabled' : 'disabled';
                $.ajax({
                    url: 'config/update_product_status.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: productId,
                        status: newStatus
                    }),
                    success: function(data) {
                        if (!data.success) {
                            alert('Failed to update product status.');
                        }
                    },
                    error: function() {
                        alert('Error updating product status.');
                    }
                });
            });

            // Generate Product ID and SKU
            function generateProductId() {
                return 'PRD' + Date.now().toString().slice(-13);
            }

            function generateSku() {
                return 'SKU' + Math.random().toString().slice(2, 15);
            }

            // Fetch Tax Rate
            function fetchTaxRate(category, container) {
                const rateDisplay = container.find('.rate-value');
                const loadingDisplay = container.find('.tax-loading');
                const taxRateInput = container.find('.tax-rate-value');

                if (!category) {
                    rateDisplay.text('--');
                    taxRateInput.val('');
                    return;
                }

                loadingDisplay.show();
                rateDisplay.text('--');

                $.ajax({
                    url: `config/get-latest-tax-rate.php?category=${encodeURIComponent(category)}`,
                    dataType: 'json',
                    success: function(data) {
                        loadingDisplay.hide();
                        if (data.success) {
                            rateDisplay.text(data.tax_rate);
                            taxRateInput.val(data.tax_rate);
                        } else {
                            rateDisplay.text('--');
                            taxRateInput.val('');
                            alert(data.error || 'No tax rate found for this category');
                        }
                    },
                    error: function() {
                        loadingDisplay.hide();
                        rateDisplay.text('--');
                        taxRateInput.val('');
                        alert('Error fetching tax rate');
                    }
                });
            }

            // Add Product Modal - Initialize
            $('#addProductModal').on('show.bs.modal', function() {
                $('#productRows').html(`
                    <tr>
                        <td><input type="text" class="form-control" name="productId" value="${generateProductId()}" readonly></td>
                        <td><input type="text" class="form-control" name="productSku" value="${generateSku()}" readonly></td>
                        <td><input type="text" class="form-control" name="productName" required></td>
                        <td>
                            <select class="form-select" name="productCategory" required>
                                <option value="">Select Category</option>
                                <?php
                                include 'config/db_con.php';
                                $result = $conn->query("SELECT sub_category_name FROM categories");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['sub_category_name']) . '">' . htmlspecialchars($row['sub_category_name']) . '</option>';
                                    }
                                    mysqli_close($conn);
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>

                        <select class="form-select" name="hsnNumber" required>
                                <option value="">Select HSN Number</option>
                                <?php
                                include 'config/db_con.php';
                                $result = $conn->query("SELECT hsn_number FROM hsn_codes");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['hsn_number']) . '">' . htmlspecialchars($row['hsn_number']) . '</option>';
                                    }
                                    mysqli_close($conn);
                                } else {
                                    echo '<option value="">No HSN Numbers available</option>';
                                }
                                ?>
                            </select>



                        </td>
                        <td>
                            <div class="tax-rate-container">
                                <select class="form-select tax-category" name="taxCategory" required>
                                    <option value="">Select Tax Category</option>
                                    <?php
                                    include 'config/db_con.php';
                                    $categoryQuery = $conn->query("SELECT DISTINCT category FROM tax_rates");
                                    if ($categoryQuery && $categoryQuery->num_rows > 0) {
                                        while ($row = $categoryQuery->fetch_assoc()) {
                                            $cat = htmlspecialchars($row['category']);
                                            echo "<option value=\"$cat\">$cat</option>";
                                        }
                                        mysqli_close($conn);
                                    } else {
                                        echo '<option value="">No categories found</option>';
                                    }
                                    ?>
                                </select>
                                <input type="hidden" class="tax-rate-value" name="taxRate">
                                <div class="tax-rate-display mt-2">
                                    Tax Rate: <span class="rate-value">--</span>%
                                    <span class="tax-loading" style="display: none;">(Loading...)</span>
                                </div>
                            </div>
                        </td>
                        <td><textarea class="form-control" name="keyBenefits" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="description" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="productBenefits" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="productUsage" rows="2" required></textarea></td>
                        <td>
                            <div class="image-upload-container">
                                <div class="image-upload-group">
                                    <input type="file" class="form-control" name="productImages[]" accept="image/*" required>
                                </div>
                                <button type="button" class="btn btn-primary btn-add-image btn-sm">Add New Image</button>
                            </div>
                        </td>
                        <td>
                            <input type="file" class="form-control" name="productVideos" multiple accept="video/*">
                            <small class="text-muted">Upload videos</small>
                        </td>
                        <td><button type="button" class="btn btn-danger remove-row btn-sm">Remove</button></td>
                    </tr>
                `);
                $('#productRows .tax-category').on('change', function() {
                    fetchTaxRate($(this).val(), $(this).closest('.tax-rate-container'));
                });
            });

            // Add New Row
            $('#addRow').on('click', function() {
                const newRow = `
                    <tr>
                        <td><input type="text" class="form-control" name="productId" value="${generateProductId()}" readonly></td>
                        <td><input type="text" class="form-control" name="productSku" value="${generateSku()}" readonly></td>
                        <td><input type="text" class="form-control" name="productName" required></td>
                        <td>
                            <select class="form-select" name="productCategory" required>
                                <option value="">Select Category</option>
                                <?php
                                include 'config/db_con.php';
                                $result = $conn->query("SELECT sub_category_name FROM categories");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['sub_category_name']) . '">' . htmlspecialchars($row['sub_category_name']) . '</option>';
                                    }
                                    mysqli_close($conn);
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                        
                         <select class="form-select" name="hsnNumber" required>
                                <option value="">Select HSN Number</option>
                                <?php
                                include 'config/db_con.php';
                                $result = $conn->query("SELECT hsn_number FROM hsn_codes");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row['hsn_number']) . '">' . htmlspecialchars($row['hsn_number']) . '</option>';
                                    }
                                    mysqli_close($conn);
                                } else {
                                    echo '<option value="">No HSN Numbers available</option>';
                                }
                                ?>
                            </select>
                        
                        </td>
                        <td>
                            <div class="tax-rate-container">
                                <select class="form-select tax-category" name="taxCategory" required>
                                    <option value="">Select Tax Category</option>
                                    <?php
                                    include 'config/db_con.php';
                                    $categoryQuery = $conn->query("SELECT DISTINCT category FROM tax_rates");
                                    if ($categoryQuery && $categoryQuery->num_rows > 0) {
                                        while ($row = $categoryQuery->fetch_assoc()) {
                                            $cat = htmlspecialchars($row['category']);
                                            echo "<option value=\"$cat\">$cat</option>";
                                        }
                                        mysqli_close($conn);
                                    } else {
                                        echo '<option value="">No categories found</option>';
                                    }
                                    ?>
                                </select>
                                <input type="hidden" class="tax-rate-value" name="taxRate">
                                <div class="tax-rate-display mt-2">
                                    Tax Rate: <span class="rate-value">--</span>%
                                    <span class="tax-loading" style="display: none;">(Loading...)</span>
                                </div>
                            </div>
                        </td>
                        <td><textarea class="form-control" name="keyBenefits" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="description" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="productBenefits" rows="2" required></textarea></td>
                        <td><textarea class="form-control" name="productUsage" rows="2" required></textarea></td>
                        <td>
                            <div class="image-upload-container">
                                <div class="image-upload-group">
                                    <input type="file" class="form-control" name="productImages[]" accept="image/*" required>
                                </div>
                                <button type="button" class="btn btn-primary btn-add-image btn-sm">Add New Image</button>
                            </div>
                        </td>
                        <td>
                            <input type="file" class="form-control" name="productVideos" multiple accept="video/*">
                            <small class="text-muted">Upload videos</small>
                        </td>
                        <td><button type="button" class="btn btn-danger remove-row btn-sm">Remove</button></td>
                    </tr>
                `;
                $('#productRows').append(newRow);
                $('#productRows .tax-category').last().on('change', function() {
                    fetchTaxRate($(this).val(), $(this).closest('.tax-rate-container'));
                });
            });

            // Remove Row
            $('#productRows').on('click', '.remove-row', function() {
                if ($('#productRows tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('At least one row is required.');
                }
            });

            // Add New Image Input
            $('#productRows, #editProductModal').on('click', '.btn-add-image', function() {
                const container = $(this).closest('.image-upload-container');
                container.find('.image-upload-group').last().after('<div class="image-upload-group"><input type="file" class="form-control" name="productImages[]" accept="image/*"></div>');
            });

            // Save Product
            $('#saveProduct').on('click', function() {
                const form = $('#addProductForm')[0];
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = new FormData();
                const products = [];

                $('#productRows tr').each(function() {
                    const row = $(this);
                    const imageInputs = row.find('input[name="productImages[]"]');
                    const videoInput = row.find('input[name="productVideos"]');

                    const product = {
                        product_id: row.find('input[name="productId"]').val(),
                        product_sku: row.find('input[name="productSku"]').val(),
                        product_name: row.find('input[name="productName"]').val(),
                        product_category: row.find('select[name="productCategory"]').val(),
                        hsn_number: row.find('input[name="hsnNumber"]').val(),
                        tax_rate: row.find('input[name="taxRate"]').val(),
                        key_benefits: row.find('textarea[name="keyBenefits"]').val(),
                        description: row.find('textarea[name="description"]').val(),
                        product_benefits: row.find('textarea[name="productBenefits"]').val(),
                        product_usage: row.find('textarea[name="productUsage"]').val()
                    };

                    if (!product.product_id || !product.product_name || !product.product_category || !product.hsn_number || !product.tax_rate || !product.key_benefits || !product.description || !product.product_benefits || !product.product_usage) {
                        alert('Please fill all required fields.');
                        return false;
                    }

                    // Append images to FormData
                    imageInputs.each(function(index, input) {
                        if (input.files[0]) {
                            formData.append('productImages[]', input.files[0]);
                        }
                    });

                    // Append videos to FormData
                    if (videoInput[0].files[0]) {
                        Array.from(videoInput[0].files).forEach(file => {
                            formData.append('productVideos[]', file);
                        });
                    }

                    products.push(product);
                });

                if (products.length === 0) {
                    alert('Please add at least one valid product.');
                    return;
                }

                // Append JSON data to FormData
                formData.append('data', JSON.stringify(products));

                $.ajax({
                    url: 'config/save_products.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status === 'success') {
                            alert(data.message || 'Products added successfully.');
                            $('#addProductModal').modal('hide');
                            location.reload();
                        } else {
                            alert(data.message || 'Error adding products.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while saving the products.');
                    }
                });
            });



            // Edit Product Modal - Populate
            $('#editProductModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const data = {
                    id: button.data('id'),
                    inventoryNumber: button.data('inventory-number'),
                    sku: button.data('sku'),
                    name: button.data('name'),
                    category: button.data('category'),
                    hsn: button.data('hsn'),
                    taxRate: button.data('tax-rate'),
                    keyBenefits: button.data('key-benefits'),
                    description: button.data('description'),
                    benefits: button.data('benefits'),
                    usage: button.data('usage'),
                    images: button.data('images') ? button.data('images').split(',') : [],
                    videos: button.data('videos') ? button.data('videos').split(',') : []
                };

                $('#editProductId').val(data.id);
                $('#editProductSku').val(data.sku);
                $('#editInventoryNumber').val(data.inventoryNumber || '');
                $('#editProductName').val(data.name);
                $('#editProductCategory').val(data.category);
                $('#editHsnNumber').val(data.hsn);
                $('#editTaxCategory').val(data.taxRate ? data.taxRate : '').trigger('change');
                $('#editKeyBenefits').val(data.keyBenefits);
                $('#editDescription').val(data.description);
                $('#editProductBenefits').val(data.benefits);
                $('#editProductUsage').val(data.usage);
                const imageContainer = $('#editProductModal .current-images');
                imageContainer.empty();
                if (data.images.length > 0) {
                    data.images.forEach(img => {
                        imageContainer.append(`<div><img src="${img}" alt="Current Image" style="width:50px; margin-right:5px;"></div>`);
                    });
                }
                const videoContainer = $('#editProductModal .current-videos');
                videoContainer.empty();
                if (data.videos.length > 0) {
                    data.videos.forEach(video => {
                        videoContainer.append(`<div><a href="${video}" target="_blank">${video}</a></div>`);
                    });
                }

                // Fetch tax rate for the selected category
                fetchTaxRate(data.taxRate, $('#editTaxCategory').closest('.tax-rate-container'));
            });

            // Save Edited Product
            $('#saveEditProduct').on('click', function() {
                const form = $('#editProductForm')[0];
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const imageFiles = Array.from($('input[name="productImages[]"]').get().flatMap(input => Array.from(input.files).map(file => file.name)));
                const videoFiles = Array.from($('input[name="productVideos"]').prop('files')).map(file => file.name);

                const product = {
                    product_id: $('#editProductId').val(),
                    product_sku: $('#editProductSku').val(),
                    product_name: $('#editProductName').val(),
                    product_category: $('#editProductCategory').val(),
                    hsn_number: $('#editHsnNumber').val(),
                    tax_rate: $('#editTaxRate').val(),
                    key_benefits: $('#editKeyBenefits').val(),
                    description: $('#editDescription').val(),
                    product_benefits: $('#editProductBenefits').val(),
                    product_usage: $('#editProductUsage').val(),
                    images: imageFiles.length > 0 ? imageFiles : $('#editProductModal .current-images img').map(function() {
                        return $(this).attr('src');
                    }).get(),
                    videos: videoFiles.length > 0 ? videoFiles : $('#editProductModal .current-videos a').map(function() {
                        return $(this).attr('href');
                    }).get()
                };

                if (!product.product_id || !product.product_name || !product.product_category || !product.hsn_number || !product.tax_rate || !product.key_benefits || !product.description || !product.product_benefits || !product.product_usage) {
                    alert('Please fill all required fields.');
                    return;
                }

                $.ajax({
                    url: 'config/update_product.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(product),
                    success: function(data) {
                        if (data.success) {
                            alert(data.message || 'Product updated successfully.');
                            $('#editProductModal').modal('hide');
                            location.reload();
                        } else {
                            alert(data.message || 'Error updating product.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the product.');
                    }
                });
            });

            // Delete Product Modal
            $('#deleteProductModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                $('#deleteProductId').val(button.data('id'));
                $('#deleteProductName').text(button.data('name') || 'N/A');
                $('#deleteProductIds').text(button.data('id') || 'N/A');
            });

            $('#confirmDeleteProduct').on('click', function() {
                const productId = $('#deleteProductId').val();
                $.ajax({
                    url: 'config/delete_product.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: productId
                    }),
                    success: function(data) {
                        if (data.success) {
                            alert(data.message || 'Product deleted successfully.');
                            $('#deleteProductModal').modal('hide');
                            location.reload();
                        } else {
                            alert(data.message || 'Error deleting product.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the product.');
                    }
                });
            });

            // Tax Rate Handler for Edit Modal
            $('#editTaxCategory').on('change', function() {
                fetchTaxRate($(this).val(), $(this).closest('.tax-rate-container'));
            });
        });
    </script>