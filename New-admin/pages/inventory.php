<?php
include 'config/db_con.php'; ?>
<button class="btn btn-success mb-3 float-right text-right" data-bs-toggle="modal" data-bs-target="#addInventoryModal">Add New Inventory</button>

<!-- showing the data -->
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="inventoryTable">
        <thead>
            <tr>
                <th>Product Category</th>
                <th>Product Name</th>
                <th>Custom Batch Name</th>
                <th>MRP</th>
                <th>Discount (%)</th>
                <th>Selling Price</th>
                <th>Stock Quantity</th>
                <th>Unit (gm/kg)</th>
                <th>Manufacturing Date</th>
                <th>Expiration Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="showingInventory">
            <?php
            // Fetch inventory items with product category from the database
            $sql = "SELECT i.product_id, i.product_name, i.custom_batch_name, i.mrp, i.discount, i.selling_price, i.stock_quantity, i.packagingwithunit, i.manufacturing_date, i.expiration_date, p.product_category 
                    FROM inventory i 
                    LEFT JOIN products p ON i.product_id = p.product_id";
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . (isset($row['product_category']) ? htmlspecialchars($row['product_category']) : 'N/A') . "</td>
                        <td>" . htmlspecialchars($row['product_name']) . "</td>
                        <td>" . htmlspecialchars($row['custom_batch_name']) . "</td>
                        <td>" . htmlspecialchars($row['mrp']) . "</td>
                        <td>" . htmlspecialchars($row['discount']) . "</td>
                        <td>" . htmlspecialchars($row['selling_price']) . "</td>
                        <td>" . htmlspecialchars($row['stock_quantity']) . "</td>
                        <td>" . htmlspecialchars($row['packagingwithunit']) . "</td>
                        <td>" . htmlspecialchars($row['manufacturing_date']) . "</td>
                        <td>" . htmlspecialchars($row['expiration_date']) . "</td>
                        <td>
                            <button class='btn btn-sm btn-info'>
                                <i class='fas fa-eye'></i>
                            </button>
                            <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#confirmDeleteModal' data-product-id='" . htmlspecialchars($row['product_id']) . "' data-product-name='" . htmlspecialchars($row['product_name']) . "'>
                                <i class='fas fa-trash'></i>
                            </button>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='11' class='text-center'>No inventory items found.</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inventoryTable = document.getElementById('inventoryTable');
        const pagination = document.getElementById('pagination');
        const rowsPerPage = 10; // Set to 10 rows per page
        let currentPage = 1;

        function displayTable(page) {
            const rows = inventoryTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Show/hide rows based on current page
            for (let i = 0; i < totalRows; i++) {
                rows[i].style.display = (i >= start && i < end) ? '' : 'none';
            }

            // Generate pagination controls
            pagination.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item' + (i === page ? ' active' : '');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    displayTable(currentPage);
                });
                pagination.appendChild(li);
            }
        }

        // Initialize table display
        displayTable(currentPage);
    });
</script>

<!-- Modal for Confirming Deletion -->
<div class='modal fade' id='confirmDeleteModal' tabindex='-1' aria-labelledby='confirmDeleteModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='confirmDeleteModalLabel'>Confirm Deletion</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                Are you sure you want to delete <strong id='productName'></strong> (ID: <span id='productId'></span>)?
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-danger' id='confirmDeleteButton'>Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    // jQuery to handle the modal and delete action
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var productId = button.data('product-id'); // Extract info from data-* attributes
        var productName = button.data('product-name');
        var modal = $(this);
        modal.find('#productName').text(productName);
        modal.find('#productId').text(productId);
        modal.find('#confirmDeleteButton').off('click').on('click', function() {
            if (!productId) {
                alert('Product ID is missing. Cannot proceed with deletion.');
                return;
            }
            $.ajax({
                url: 'config/delete_inventory.php', // URL to your delete script
                type: 'POST',
                data: {
                    id: productId,
                    name: productName
                },
                success: function(response) {
                    // Display server response message
                    alert(response.message);
                    // Hide the modal
                    $('#confirmDeleteModal').modal('hide');
                    // Reload the page to see changes
                    // location.reload();
                },
                error: function() {
                    // Handle error response
                    alert('Error deleting the product.');
                }
            });
        });
    });
</script>

<!-- Modal for Adding new Inventory -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inventoryForm">
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="inventoryNumber" class="form-label">Inventory Number</label>
                                <input type="text" class="form-control" id="inventoryNumber" name="inventoryNumber" readonly value="INV123456">
                            </div>
                            <div class="col-md-3">
                                <label for="inventoryDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="inventoryDate" name="inventoryDate" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label for="partyName" class="form-label">Party Name</label>
                                <select class="form-select" id="partyName" name="partyName" required>
                                    <option value="">Select Party</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="billingNumber" class="form-label">Billing Number</label>
                                <input type="text" class="form-control" id="billingNumber" name="billingNumber" >
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Custom Batch Name</th>
                                    <th>MRP</th>
                                    <th>Discount (%)</th>
                                    <th>Selling Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Unit(gm/kg)</th>
                                    <th>Manufacturing Date</th>
                                    <th>Expiration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="inventoryTableBody">
                                <tr>
                                    <td>
                                        <select class="form-select" name="productId" required>
                                            <option value="">Select Product</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="customBatchName" id="customBatchName"></td>
                                    <td><input type="number" class="form-control" name="mrp" id="mrp" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="discount" id="discount" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="sellingPrice" id="sellingPrice" readonly></td>
                                    <td><input type="number" class="form-control" name="stockQuantity" id="stockQuantity" required></td>
                                    <td>
                                        <input type="text" class="form-control" name="packaging" id="packaging">
                                        <select class="form-select" name="packagingUnit" id="packagingUnit" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="manufacturingDate" id="manufacturingDate" required></td>
                                    <td><input type="date" class="form-control" name="expirationDate" id="expirationDate" required></td>
                                    <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary" id="addNewItem">Add New Item</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveInventory">Save Inventory</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch party names for dropdown
        fetch('config/get-party-names.php')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('partyName');
                data.forEach(party => {
                    const option = document.createElement('option');
                    option.value = party.party_name;
                    option.textContent = party.party_name;
                    select.appendChild(option);
                });

                // Activate select2 on the dropdown
                $('#partyName').select2({
                    placeholder: "Select Party",
                    allowClear: true
                });
            })
            .catch(error => console.error('Error fetching party names:', error));

        // Load products and units
        loadProducts();
        loadUnits();
        validateDates();

        // Validate stock quantity
        document.getElementById('inventoryTableBody').addEventListener('change', function(e) {
            if (e.target.name === 'stockQuantity') {
                const stockQuantity = parseInt(e.target.value);
                if (stockQuantity < 0) {
                    alert('Stock quantity cannot be negative.');
                    e.target.value = 0;
                }
            }
        });

        // Calculate selling price based on MRP and discount
        window.calculateSellingPrice = function(input) {
            const row = input.closest('tr');
            const mrp = parseFloat(row.querySelector('input[name="mrp"]').value) || 0;
            const discount = parseFloat(row.querySelector('input[name="discount"]').value) || 0;

            // Validate MRP and discount
            if (mrp < 0) {
                alert("MRP cannot be negative.");
                row.querySelector('input[name="mrp"]').value = 0;
                return;
            }
            if (discount < 0 || discount > 100) {
                alert("Discount must be between 0% and 100%.");
                row.querySelector('input[name="discount"]').value = 0;
                return;
            }

            const sellingPrice = mrp - (mrp * (discount / 100));
            row.querySelector('input[name="sellingPrice"]').value = Math.round(sellingPrice * 100) / 100;
        };

        // Save inventory
        document.getElementById('saveInventory').addEventListener('click', function() {
            const form = document.getElementById('inventoryForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const inventoryRows = document.querySelectorAll('#inventoryTableBody tr');
            const inventoryData = [];
            const inventoryNumber = document.getElementById('inventoryNumber').value;
            const inventoryDate = document.getElementById('inventoryDate').value;
            const partyName = document.getElementById('partyName').value;
            const billingNumber = document.getElementById('billingNumber').value;

            // Validate header fields
            if (!inventoryNumber || !inventoryDate || !partyName || !billingNumber) {
                alert('Please fill all required header fields (Inventory Number, Date, Party Name, Billing Number).');
                return;
            }

            let isValid = true;
            inventoryRows.forEach((row, index) => {
                const productId = row.querySelector('select[name="productId"]').value;
                const customBatchName = row.querySelector('input[name="customBatchName"]').value;
                const mrp = row.querySelector('input[name="mrp"]').value;
                const discount = row.querySelector('input[name="discount"]').value;
                const sellingPrice = row.querySelector('input[name="sellingPrice"]').value;
                const stockQuantity = row.querySelector('input[name="stockQuantity"]').value;
                const packaging = row.querySelector('input[name="packaging"]').value;
                const packagingUnit = row.querySelector('select[name="packagingUnit"]').value;
                const manufacturingDate = row.querySelector('input[name="manufacturingDate"]').value;
                const expirationDate = row.querySelector('input[name="expirationDate"]').value;
                const packagingwithunit = packaging && packagingUnit ? `${packaging} ${packagingUnit}` : '';

                // Validate required fields
                if (!productId || !mrp || !discount || !stockQuantity || !packagingUnit || !manufacturingDate || !expirationDate) {
                    alert(`Row ${index + 1}: Please fill all required fields.`);
                    isValid = false;
                    return;
                }

                // Log data for debugging
                console.log(`Row ${index + 1} Data:`, {
                    inventoryNumber,
                    inventoryDate,
                    partyName,
                    billingNumber,
                    productId,
                    customBatchName,
                    mrp,
                    discount,
                    sellingPrice,
                    stockQuantity,
                    packagingwithunit,
                    manufacturingDate,
                    expirationDate
                });

                inventoryData.push({
                    inventoryNumber,
                    inventoryDate,
                    partyName,
                    billingNumber,
                    productId,
                    customBatchName,
                    mrp: parseFloat(mrp),
                    discount: parseFloat(discount),
                    sellingPrice: parseFloat(sellingPrice),
                    stockQuantity: parseInt(stockQuantity),
                    packagingwithunit,
                    manufacturingDate,
                    expirationDate
                });
            });

            if (!isValid || inventoryData.length === 0) {
                alert('Please add at least one valid inventory item.');
                return;
            }

            // Send the collected data to the server
            fetch('config/save_inventory.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(inventoryData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message || 'Inventory added successfully.');
                        document.getElementById('inventoryForm').reset();
                        $('#addInventoryModal').modal('hide');
                        // Optionally reload the page or update the table
                        // location.reload();
                    } else {
                        alert(data.message || 'Error adding inventory.');
                    }
                })
                .catch(error => {
                    console.error('Error saving inventory:', error);
                    alert('An error occurred while saving the inventory.');
                });
        });

        // Add new item row functionality
        document.getElementById('addNewItem').addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select class="form-select" name="productId" required>
                        <option value="">Select Product</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" name="customBatchName" id="customBatchName"></td>
                <td><input type="number" class="form-control" name="mrp" id="mrp" required oninput="calculateSellingPrice(this)"></td>
                <td><input type="number" class="form-control" name="discount" id="discount" required oninput="calculateSellingPrice(this)"></td>
                <td><input type="number" class="form-control" name="sellingPrice" id="sellingPrice" readonly></td>
                <td><input type="number" class="form-control" name="stockQuantity" id="stockQuantity" required></td>
                <td>
                    <input type="text" class="form-control" name="packaging" id="packaging">
                    <select class="form-select" name="packagingUnit" id="packagingUnit" required>
                        <option value="">Select Unit</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" name="manufacturingDate" id="manufacturingDate" required></td>
                <td><input type="date" class="form-control" name="expirationDate" id="expirationDate" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            `;
            document.getElementById('inventoryTableBody').appendChild(newRow);
            loadProductsForRow(newRow);
            loadUnitsForRow(newRow);
            validateDatesForRow(newRow);
        });

        // Remove row functionality
        document.getElementById('inventoryTableBody').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    });

    // Load products to populate the product ID dropdown
    function loadProducts() {
        fetch('config/get_products.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const productSelects = document.querySelectorAll('select[name="productId"]');
                productSelects.forEach(select => {
                    // Clear existing options except the default
                    select.innerHTML = '<option value="">Select Product</option>';
                    // Populate options
                    data.products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.product_id; // Use product_id as value
                        option.textContent = product.product_name;
                        select.appendChild(option);
                    });
                });
            })
            .catch(error => {
                console.error('Error loading products:', error);
                alert('Failed to load products. Please check the server.');
            });
    }

    // Load products for a specific row
    function loadProductsForRow(row) {
        fetch('config/get_products.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const select = row.querySelector('select[name="productId"]');
                select.innerHTML = '<option value="">Select Product</option>';
                data.products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.product_id;
                    option.textContent = product.product_name;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading products:', error);
                alert('Failed to load products for new row.');
            });
    }

    // Load units for all packagingUnit dropdowns
    function loadUnits() {
        fetch('config/get-units.php')
            .then(response => response.json())
            .then(data => {
                const unitSelects = document.querySelectorAll('select[name="packagingUnit"]');
                unitSelects.forEach(select => {
                    select.innerHTML = '<option value="">Select Unit</option>';
                    data.forEach(unit => {
                        const option = document.createElement('option');
                        option.value = unit.unit;
                        option.textContent = unit.unit;
                        select.appendChild(option);
                    });
                });
            })
            .catch(error => console.error('Error fetching units:', error));
    }

    // Load units for a specific row
    function loadUnitsForRow(row) {
        fetch('config/get-units.php')
            .then(response => response.json())
            .then(data => {
                const select = row.querySelector('select[name="packagingUnit"]');
                select.innerHTML = '<option value="">Select Unit</option>';
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.unit;
                    option.textContent = unit.unit;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching units:', error));
    }

    // Validate manufacturing and expiration dates
    function validateDates() {
        const rows = document.querySelectorAll('#inventoryTableBody tr');
        rows.forEach(row => validateDatesForRow(row));
    }

    function validateDatesForRow(row) {
        const manufacturingDateInput = row.querySelector('input[name="manufacturingDate"]');
        const expirationDateInput = row.querySelector('input[name="expirationDate"]');

        manufacturingDateInput.addEventListener('change', function() {
            const manufacturingDate = new Date(this.value);
            const expirationDate = new Date(expirationDateInput.value);
            if (manufacturingDate > expirationDate && expirationDateInput.value) {
                alert('Manufacturing date cannot be greater than expiration date.');
                this.value = '';
            }
        });

        expirationDateInput.addEventListener('change', function() {
            const manufacturingDate = new Date(manufacturingDateInput.value);
            const expirationDate = new Date(this.value);
            if (manufacturingDate > expirationDate && manufacturingDateInput.value) {
                alert('Expiration date cannot be earlier than manufacturing date.');
                this.value = '';
            }
        });
    }
</script>