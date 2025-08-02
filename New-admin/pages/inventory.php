<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("Starting inventory.php");
?>
<div class="container mt-4">
    <button class="btn btn-success mb-3 float-end" data-bs-toggle="modal" data-bs-target="#addInventoryModal">Add New Inventory</button>
    <h2 class="mb-3">Inventory Items</h2>
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
                <!-- Rows will be populated dynamically via JavaScript -->
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>
</div>

<!-- Modal for Confirming Deletion -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="productName"></strong> (ID: <span id="productId"></span>)?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding New Inventory -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inventoryForm">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="inventoryNumber" class="form-label">Inventory Number</label>
                            <input type="text" class="form-control" id="inventoryNumber" name="inventoryNumber" readonly>
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
                            <input type="text" class="form-control" id="billingNumber" name="billingNumber" required>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
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
                            <tbody id="inventoryTableBody">
                                <tr>
                                    <td>
                                        <select class="form-select" name="productId" required>
                                            <option value="">Select Product</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="customBatchName"></td>
                                    <td><input type="number" class="form-control" name="mrp" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="discount" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="sellingPrice" step="0.01" readonly></td>
                                    <td><input type="number" class="form-control" name="stockQuantity" required></td>
                                    <td>
                                        <input type="text" class="form-control" name="packaging">
                                        <select class="form-select" name="packagingUnit" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="manufacturingDate" required></td>
                                    <td><input type="date" class="form-control" name="expirationDate" required></td>
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

<!-- Modal for Editing Inventory -->
<div class="modal fade" id="editInventoryModal" tabindex="-1" aria-labelledby="editInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 95%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInventoryModalLabel">Edit Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editInventoryForm">
                    <input type="hidden" id="editInventoryId" name="id">
                    <input type="hidden" id="editProductId" name="productId">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="editInventoryNumber" class="form-label">Inventory Number</label>
                            <input type="text" class="form-control" id="editInventoryNumber" name="inventoryNumber" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="editInventoryDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="editInventoryDate" name="inventoryDate" required>
                        </div>
                        <div class="col-md-3">
                            <label for="editPartyName" class="form-label">Party Name</label>
                            <select class="form-select" id="editPartyName" name="partyName" required>
                                <option value="">Select Party</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="editBillingNumber" class="form-label">Billing Number</label>
                            <input type="text" class="form-control" id="editBillingNumber" name="billingNumber" required>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Custom Batch Name</th>
                                    <th>MRP</th>
                                    <th>Discount (%)</th>
                                    <th>Selling Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Unit (gm/kg)</th>
                                    <th>Manufacturing Date</th>
                                    <th>Expiration Date</th>
                                </tr>
                            </thead>
                            <tbody id="editInventoryTableBody">
                                <tr>
                                    <td>
                                        <select class="form-select" name="productId" required disabled>
                                            <option value="">Select Product</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="customBatchName"></td>
                                    <td><input type="number" class="form-control" name="mrp" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="discount" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                                    <td><input type="number" class="form-control" name="sellingPrice" step="0.01" readonly></td>
                                    <td><input type="number" class="form-control" name="stockQuantity" required></td>
                                    <td>
                                        <input type="text" class="form-control" name="packaging">
                                        <select class="form-select" name="packagingUnit" required>
                                            <option value="">Select Unit</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="manufacturingDate" required></td>
                                    <td><input type="date" class="form-control" name="expirationDate" required></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditInventory">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('Document ready, initializing inventory page');

        // Initialize Select2 for party name dropdowns
        $('#partyName, #editPartyName').select2({
            placeholder: "Select Party",
            allowClear: true
        });
        console.log('Select2 initialized for party name dropdowns');

        // Fetch inventory data and populate table
        function loadInventoryData() {
            console.log('Fetching inventory data');
            $.ajax({
                url: 'config/get_inventory.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Inventory data response:', data);
                    const tbody = $('#showingInventory');
                    tbody.empty();
                    if (data.success && data.inventory && data.inventory.length > 0) {
                        console.log(`Received ${data.inventory.length} inventory items`);
                        data.inventory.forEach(row => {
                            const packagingParts = (row.packagingwithunit || '').split(' ', 2);
                            const packaging = packagingParts[0] || '';
                            const packagingUnit = packagingParts[1] || '';
                            const rowHtml = `
                            <tr>
                                <td>${row.product_category ? escapeHtml(row.product_category) : 'N/A'}</td>
                                <td>${row.product_name ? escapeHtml(row.product_name) : 'N/A'}</td>
                                <td>${escapeHtml(row.custom_batch_name)}</td>
                                <td>${escapeHtml(row.mrp)}</td>
                                <td>${escapeHtml(row.discount)}</td>
                                <td>${escapeHtml(row.selling_price)}</td>
                                <td>${escapeHtml(row.stock_quantity)}</td>
                                <td>${escapeHtml(row.packagingwithunit)}</td>
                                <td>${escapeHtml(row.manufacturing_date)}</td>
                                <td>${escapeHtml(row.expiration_date)}</td>
                                <td>
                                    <button class='btn btn-sm btn-info' data-bs-toggle='modal' data-bs-target='#editInventoryModal' 
                                        data-id='${escapeHtml(row.id)}' 
                                        data-inventory-number='${escapeHtml(row.inventory_number)}' 
                                        data-product-id='${escapeHtml(row.product_id)}' 
                                        data-product-name='${escapeHtml(row.product_name || '')}' 
                                        data-custom-batch-name='${escapeHtml(row.custom_batch_name)}' 
                                        data-mrp='${escapeHtml(row.mrp)}' 
                                        data-discount='${escapeHtml(row.discount)}' 
                                        data-selling-price='${escapeHtml(row.selling_price)}' 
                                        data-stock-quantity='${escapeHtml(row.stock_quantity)}' 
                                        data-packaging='${escapeHtml(packaging)}' 
                                        data-packaging-unit='${escapeHtml(packagingUnit)}' 
                                        data-manufacturing-date='${escapeHtml(row.manufacturing_date)}' 
                                        data-expiration-date='${escapeHtml(row.expiration_date)}' 
                                        title='Edit'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#confirmDeleteModal' 
                                        data-product-id='${escapeHtml(row.id)}' 
                                        data-product-name='${escapeHtml(row.product_name || '')}' title='Delete'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </td>
                            </tr>`;
                            tbody.append(rowHtml);
                        });
                        displayTable(1); // Initialize pagination
                    } else if (!data.success) {
                        console.error('Inventory fetch error:', data.message);
                        tbody.append(`<tr><td colspan='11' class='text-center text-danger'>Error: ${escapeHtml(data.message)}</td></tr>`);
                    } else {
                        console.log('No inventory items found');
                        tbody.append("<tr><td colspan='11' class='text-center'>No inventory items found.</td></tr>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Inventory AJAX error:', status, error, xhr.responseText);
                    $('#showingInventory').append(`<tr><td colspan='11' class='text-center text-danger'>Error fetching inventory: ${escapeHtml(error)}</td></tr>`);
                }
            });
        }

        // HTML escape function to prevent XSS
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Fetch inventory number for add modal
        function fetchInventoryNumber(modalId, inputId) {
            console.log('Fetching inventory number for modal:', modalId);
            $.ajax({
                url: 'config/get_inventory_number.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Inventory number response:', data);
                    if (data.success) {
                        $(inputId).val(data.inventoryNumber);
                    } else {
                        console.error('Failed to fetch inventory number:', data.message);
                        alert(data.message || 'Failed to fetch inventory number.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Inventory number AJAX error:', status, error, xhr.responseText);
                    alert('Error fetching inventory number: ' + error);
                }
            });
        }

        // Load inventory number when add modal is shown
        $('#addInventoryModal').on('show.bs.modal', function() {
            console.log('Add inventory modal shown');
            fetchInventoryNumber('#addInventoryModal', '#inventoryNumber');
        });

        // Load data when edit modal is shown
        $('#editInventoryModal').on('show.bs.modal', function(event) {
            console.log('Edit inventory modal shown');
            const button = $(event.relatedTarget);
            const data = {
                id: button.data('id'),
                inventoryNumber: button.data('inventory-number'),
                productId: button.data('product-id'),
                productName: button.data('product-name'),
                customBatchName: button.data('custom-batch-name'),
                mrp: button.data('mrp'),
                discount: button.data('discount'),
                sellingPrice: button.data('selling-price'),
                stockQuantity: button.data('stock-quantity'),
                packaging: button.data('packaging'),
                packagingUnit: button.data('packaging-unit'),
                manufacturingDate: button.data('manufacturing-date'),
                expirationDate: button.data('expiration-date')
            };
            console.log('Edit modal data:', data);

            $('#editInventoryId').val(data.id);
            $('#editProductId').val(data.productId);
            $('#editInventoryNumber').val(data.inventoryNumber);
            $('#editInventoryDate').val(data.manufacturingDate);
            $('#editPartyName').val('').trigger('change');
            $('#editBillingNumber').val('BILL' + data.productId);
            const row = $('#editInventoryTableBody tr');
            row.find('[name="productId"]').val(data.productId);
            row.find('[name="productId"]').find(`option[value="${data.productId}"]`).prop('selected', true);
            row.find('[name="customBatchName"]').val(data.customBatchName);
            row.find('[name="mrp"]').val(data.mrp);
            row.find('[name="discount"]').val(data.discount);
            row.find('[name="sellingPrice"]').val(data.sellingPrice);
            row.find('[name="stockQuantity"]').val(data.stockQuantity);
            row.find('[name="packaging"]').val(data.packaging);
            row.find('[name="packagingUnit"]').val(data.packagingUnit);
            row.find('[name="manufacturingDate"]').val(data.manufacturingDate);
            row.find('[name="expirationDate"]').val(data.expirationDate);
        });

        // Fetch party names for both modals
        console.log('Fetching party names');
        $.ajax({
            url: 'config/get-party-names.php',
            dataType: 'json',
            success: function(data) {
                console.log('Party names response:', data);
                const selectors = ['#partyName', '#editPartyName'];
                selectors.forEach(selector => {
                    const select = $(selector);
                    data.forEach(party => {
                        select.append(`<option value="${party.party_name}">${party.party_name}</option>`);
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error('Party names AJAX error:', status, error, xhr.responseText);
                alert('Error fetching party names: ' + error);
            }
        });

        // Load products and units for both modals
        console.log('Loading products and units for modals');
        loadProducts('#inventoryTableBody');
        loadUnits('#inventoryTableBody');
        loadProducts('#editInventoryTableBody');
        loadUnits('#editInventoryTableBody');
        validateDates('#inventoryTableBody');
        validateDates('#editInventoryTableBody');

        // Pagination
        const rowsPerPage = 10;
        let currentPage = 1;
        console.log('Initializing pagination with rows per page:', rowsPerPage);

        function displayTable(page) {
            console.log(`Displaying table page: ${page}`);
            const rows = $('#showingInventory tr');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            console.log(`Total rows: ${totalRows}, Total pages: ${totalPages}`);
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
                console.log(`Pagination clicked, switching to page: ${currentPage}`);
                displayTable(currentPage);
            });
        }

        // Load inventory data on page load
        loadInventoryData();

        // Delete modal handling
        $('#confirmDeleteModal').on('show.bs.modal', function(event) {
            console.log('Delete modal shown');
            const button = $(event.relatedTarget);
            const productId = button.data('product-id');
            const productName = button.data('product-name');
            console.log(`Delete modal data: productId=${productId}, productName=${productName}`);
            $(this).find('#productName').text(productName || 'N/A');
            $(this).find('#productId').text(productId || 'N/A');
            $('#confirmDeleteButton').off('click').on('click', function() {
                console.log('Confirm delete button clicked');
                if (!productId) {
                    console.error('Product ID is missing');
                    alert('Product ID is missing.');
                    return;
                }
                $.ajax({
                    url: 'config/delete_inventory.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id: productId
                    }),
                    dataType: 'json',
                    success: function(response) {
                        console.log('Delete response:', response);
                        if (response.success) {
                            alert(response.message || 'Product deleted successfully.');
                            $('#confirmDeleteModal').modal('hide');
                            loadInventoryData(); // Refresh table
                        } else {
                            console.error('Delete error:', response.message);
                            alert(response.message || 'Error deleting product.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete AJAX error:', status, error, xhr.responseText);
                        alert('Error deleting the product: ' + error);
                    }
                });
            });
        });

        // Calculate selling price
        window.calculateSellingPrice = function(input) {
            console.log('Calculating selling price');
            const row = input.closest('tr');
            const mrp = parseFloat(row.querySelector('[name="mrp"]').value) || 0;
            const discount = parseFloat(row.querySelector('[name="discount"]').value) || 0;
            console.log(`MRP: ${mrp}, Discount: ${discount}`);

            if (mrp < 0) {
                console.error('Negative MRP detected');
                alert('MRP cannot be negative.');
                row.querySelector('[name="mrp"]').value = 0;
                return;
            }
            if (discount < 0 || discount > 100) {
                console.error('Invalid discount:', discount);
                alert('Discount must be between 0% and 100%.');
                row.querySelector('[name="discount"]').value = 0;
                return;
            }

            const sellingPrice = mrp * (1 - discount / 100);
            row.querySelector('[name="sellingPrice"]').value = sellingPrice.toFixed(2);
            console.log(`Selling price set to: ${sellingPrice.toFixed(2)}`);
        };

        // Validate stock quantity
        $('#inventoryTableBody, #editInventoryTableBody').on('change', '[name="stockQuantity"]', function() {
            console.log('Stock quantity changed:', this.value);
            if (parseInt(this.value) < 0) {
                console.error('Negative stock quantity detected');
                alert('Stock quantity cannot be negative.');
                this.value = 0;
            }
        });

        // Save new inventory
        $('#saveInventory').on('click', function() {
            console.log('Save inventory button clicked');
            const form = document.getElementById('inventoryForm');
            if (!form.checkValidity()) {
                console.error('Form validation failed');
                form.reportValidity();
                return;
            }

            const inventoryData = [];
            const headerData = {
                inventoryNumber: $('#inventoryNumber').val(),
                inventoryDate: $('#inventoryDate').val(),
                partyName: $('#partyName').val(),
                billingNumber: $('#billingNumber').val()
            };
            console.log('Header data:', headerData);

            if (!headerData.inventoryNumber || !headerData.inventoryDate || !headerData.partyName || !headerData.billingNumber) {
                console.error('Missing header fields');
                alert('Please fill all required header fields.');
                return;
            }

            let isValid = true;
            $('#inventoryTableBody tr').each(function(index) {
                console.log(`Processing row ${index + 1}`);
                const row = $(this);
                const rowData = {
                    productId: row.find('[name="productId"]').val() || null, 
                    // Ensure productId is included, default to null if empty
                    customBatchName: row.find('[name="customBatchName"]').val(),
                    mrp: parseFloat(row.find('[name="mrp"]').val()) || 0,
                    discount: parseFloat(row.find('[name="discount"]').val()) || 0,
                    sellingPrice: parseFloat(row.find('[name="sellingPrice"]').val()) || 0,
                    stockQuantity: parseInt(row.find('[name="stockQuantity"]').val()) || 0,
                    packaging: row.find('[name="packaging"]').val(),
                    packagingUnit: row.find('[name="packagingUnit"]').val(),
                    manufacturingDate: row.find('[name="manufacturingDate"]').val(),
                    expirationDate: row.find('[name="expirationDate"]').val()
                };
                rowData.packagingwithunit = rowData.packaging && rowData.packagingUnit ? `${rowData.packaging} ${rowData.packagingUnit}` : '';
                console.log(`Row ${index + 1} data:`, rowData);

                const missingFields = [];
                if (!rowData.productId) missingFields.push('Product ID');
                if (!rowData.mrp) missingFields.push('MRP');
                if (!rowData.discount) missingFields.push('Discount');
                if (!rowData.stockQuantity) missingFields.push('Stock Quantity');
                if (!rowData.packagingUnit) missingFields.push('Packaging Unit');
                if (!rowData.manufacturingDate) missingFields.push('Manufacturing Date');
                if (!rowData.expirationDate) missingFields.push('Expiration Date');

                if (missingFields.length > 0) {
                    console.error(`Row ${index + 1} missing fields:`, missingFields);
                    alert(`Row ${index + 1}: Please fill all required fields: ${missingFields.join(', ')}`);
                    isValid = false;
                    return false;
                }
                inventoryData.push({
                    ...headerData,
                    ...rowData
                });
            });

            if (!isValid || inventoryData.length === 0) {
                console.error('No valid inventory items to save');
                alert('Please add at least one valid inventory item.');
                return;
            }

            console.log('Sending inventory data:', JSON.stringify(inventoryData));
            $.ajax({
                url: 'config/save_inventory.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(inventoryData),
                dataType: 'json',
                success: function(data) {
                    console.log('Save inventory response:', data);
                    if (data.success) {
                        alert(data.message || 'Inventory added successfully.');
                        $('#inventoryForm')[0].reset();
                        $('#addInventoryModal').modal('hide');
                        loadInventoryData(); // Refresh table
                    } else {
                        console.error('Save inventory error:', data.message);
                        alert(data.message || 'Error adding inventory.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Save inventory AJAX error:', status, error, xhr.responseText);
                    alert('An error occurred while saving the inventory: ' + error);
                }
            });
        });



        // Save edited inventory
        $('#saveEditInventory').on('click', function() {
            console.log('Save edit inventory button clicked');
            const form = document.getElementById('editInventoryForm');
            if (!form.checkValidity()) {
                console.error('Edit form validation failed');
                form.reportValidity();
                return;
            }

            const row = $('#editInventoryTableBody tr');
            const inventoryData = {
                id: $('#editInventoryId').val(),
                productId: $('#editProductId').val(),
                inventoryNumber: $('#editInventoryNumber').val(),
                inventoryDate: $('#editInventoryDate').val(),
                partyName: $('#editPartyName').val(),
                billingNumber: $('#editBillingNumber').val(),
                customBatchName: row.find('[name="customBatchName"]').val(),
                mrp: parseFloat(row.find('[name="mrp"]').val()) || 0,
                discount: parseFloat(row.find('[name="discount"]').val()) || 0,
                sellingPrice: parseFloat(row.find('[name="sellingPrice"]').val()) || 0,
                stockQuantity: parseInt(row.find('[name="stockQuantity"]').val()) || 0,
                packaging: row.find('[name="packaging"]').val(),
                packagingUnit: row.find('[name="packagingUnit"]').val(),
                manufacturingDate: row.find('[name="manufacturingDate"]').val(),
                expirationDate: row.find('[name="expirationDate"]').val()
            };
            inventoryData.packagingwithunit = inventoryData.packaging && inventoryData.packagingUnit ? `${inventoryData.packaging} ${inventoryData.packagingUnit}` : '';
            console.log('Edit inventory data:', inventoryData);

            const missingFields = [];
            if (!inventoryData.id) missingFields.push('Inventory ID');
            if (!inventoryData.productId) missingFields.push('Product ID');
            if (!inventoryData.inventoryNumber) missingFields.push('Inventory Number');
            if (!inventoryData.inventoryDate) missingFields.push('Inventory Date');
            if (!inventoryData.partyName) missingFields.push('Party Name');
            if (!inventoryData.billingNumber) missingFields.push('Billing Number');
            if (!inventoryData.mrp) missingFields.push('MRP');
            if (!inventoryData.discount) missingFields.push('Discount');
            if (!inventoryData.stockQuantity) missingFields.push('Stock Quantity');
            if (!inventoryData.packagingUnit) missingFields.push('Packaging Unit');
            if (!inventoryData.manufacturingDate) missingFields.push('Manufacturing Date');
            if (!inventoryData.expirationDate) missingFields.push('Expiration Date');

            if (missingFields.length > 0) {
                console.error('Missing fields in edit form:', missingFields);
                alert('Please fill all required fields: ' + missingFields.join(', '));
                return;
            }

            console.log('Sending edit inventory data');
            $.ajax({
                url: 'config/update_inventory.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(inventoryData),
                dataType: 'json',
                success: function(data) {
                    console.log('Update inventory response:', data);
                    if (data.success) {
                        alert(data.message || 'Inventory updated successfully.');
                        $('#editInventoryForm')[0].reset();
                        $('#editInventoryModal').modal('hide');
                        loadInventoryData(); // Refresh table
                    } else {
                        console.error('Update inventory error:', data.message);
                        alert(data.message || 'Error updating inventory.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Update inventory AJAX error:', status, error, xhr.responseText);
                    alert('An error occurred while updating the inventory: ' + error);
                }
            });
        });

        // Add new item row (for add modal)
        $('#addNewItem').on('click', function() {
            console.log('Add new item button clicked');
            const newRow = `
            <tr>
                <td><select class="form-select" name="productId" required><option value="">Select Product</option></select></td>
                <td><input type="text" class="form-control" name="customBatchName"></td>
                <td><input type="number" class="form-control" name="mrp" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                <td><input type="number" class="form-control" name="discount" step="0.01" required oninput="calculateSellingPrice(this)"></td>
                <td><input type="number" class="form-control" name="sellingPrice" step="0.01" readonly></td>
                <td><input type="number" class="form-control" name="stockQuantity" required></td>
                <td>
                    <input type="text" class="form-control" name="packaging">
                    <select class="form-select" name="packagingUnit" required><option value="">Select Unit</option></select>
                </td>
                <td><input type="date" class="form-control" name="manufacturingDate" required></td>
                <td><input type="date" class="form-control" name="expirationDate" required></td>
                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
            </tr>`;
            $('#inventoryTableBody').append(newRow);
            console.log('New row added to inventoryTableBody');
            loadProductsForRow('#inventoryTableBody tr:last');
            loadUnitsForRow('#inventoryTableBody tr:last');
            validateDatesForRow('#inventoryTableBody tr:last');
        });

        // Remove row (for add modal)
        $('#inventoryTableBody').on('click', '.remove-row', function() {
            console.log('Remove row button clicked');
            if ($('#inventoryTableBody tr').length > 1) {
                $(this).closest('tr').remove();
                console.log('Row removed');
            } else {
                console.error('Cannot remove last row');
                alert('At least one row is required.');
            }
        });

        // Load products
        function loadProducts(tableBodySelector) {
            console.log('Loading products for:', tableBodySelector);
            $.ajax({
                url: 'config/get_products.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Products response:', data);
                    $(`${tableBodySelector} [name="productId"]`).each(function() {
                        const select = $(this);
                        select.empty().append('<option value="">Select Product</option>');
                        data.products.forEach(product => {
                            select.append(`<option value="${product.product_id}">${product.product_name}</option>`);
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Products AJAX error:', status, error, xhr.responseText);
                    alert('Failed to load products: ' + error);
                }
            });
        }

        // Load products for a specific row
        function loadProductsForRow(rowSelector) {
            console.log('Loading products for row:', rowSelector);
            $.ajax({
                url: 'config/get_products.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Products response for row:', data);
                    const select = $(rowSelector).find('[name="productId"]');
                    select.empty().append('<option value="">Select Product</option>');
                    data.products.forEach(product => {
                        select.append(`<option value="${product.product_id}">${product.product_name}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Products AJAX error for row:', status, error, xhr.responseText);
                    alert('Failed to load products for new row: ' + error);
                }
            });
        }

        // Load units
        function loadUnits(tableBodySelector) {
            console.log('Loading units for:', tableBodySelector);
            $.ajax({
                url: 'config/get-units.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Units response:', data);
                    $(`${tableBodySelector} [name="packagingUnit"]`).each(function() {
                        const select = $(this);
                        select.empty().append('<option value="">Select Unit</option>');
                        data.forEach(unit => {
                            select.append(`<option value="${unit.unit}">${unit.unit}</option>`);
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Units AJAX error:', status, error, xhr.responseText);
                    alert('Failed to load units: ' + error);
                }
            });
        }

        // Load units for a specific row
        function loadUnitsForRow(rowSelector) {
            console.log('Loading units for row:', rowSelector);
            $.ajax({
                url: 'config/get-units.php',
                dataType: 'json',
                success: function(data) {
                    console.log('Units response for row:', data);
                    const select = $(rowSelector).find('[name="packagingUnit"]');
                    select.empty().append('<option value="">Select Unit</option>');
                    data.forEach(unit => {
                        select.append(`<option value="${unit.unit}">${unit.unit}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Units AJAX error for row:', status, error, xhr.responseText);
                    alert('Failed to load units for new row: ' + error);
                }
            });
        }

        // Validate dates
        function validateDates(tableBodySelector) {
            console.log('Validating dates for:', tableBodySelector);
            $(`${tableBodySelector} tr`).each(function() {
                validateDatesForRow(this);
            });
        }

        function validateDatesForRow(rowSelector) {
            console.log('Validating dates for row:', rowSelector);
            const row = $(rowSelector);
            const manufacturing = row.find('[name="manufacturingDate"]');
            const expiration = row.find('[name="expirationDate"]');

            manufacturing.on('change', function() {
                const mDate = new Date(this.value);
                const eDate = new Date(expiration.val());
                console.log(`Manufacturing date changed: ${this.value}, Expiration date: ${expiration.val()}`);
                if (mDate > eDate && expiration.val()) {
                    console.error('Manufacturing date later than expiration');
                    alert('Manufacturing date cannot be later than expiration date.');
                    this.value = '';
                }
            });

            expiration.on('change', function() {
                const mDate = new Date(manufacturing.val());
                const eDate = new Date(this.value);
                console.log(`Expiration date changed: ${this.value}, Manufacturing date: ${manufacturing.val()}`);
                if (mDate > eDate && manufacturing.val()) {
                    console.error('Expiration date earlier than manufacturing');
                    alert('Expiration date cannot be earlier than manufacturing date.');
                    this.value = '';
                }
            });
        }
    });
</script>