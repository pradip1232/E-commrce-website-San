    <?php

    // session_start();

    include "includes/auth.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "config/conn.php";

    ?>






<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container-fluid py-2">

        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <?php

                            // SQL query to count rows
                            $sql = "SELECT COUNT(*) AS total_products FROM `products_new`";
                            $result = $conn->query($sql);

                            if ($result) {
                                $row = $result->fetch_assoc();
                                $total = $row['total_products'];
                            } else {
                                echo "Error: " . $conn->error;
                            }

                            ?>
                            <h6 class="text-white text-capitalize ps-3">Products (<?= $total ?>)</h6>

                            <?php
                            $button = $_SESSION['upload_access'];

                            if ($button == 1) {

                            ?>
                                <button class="btn btn-success text-capitalize me-3" data-bs-toggle="modal" data-bs-target="#productModal">Add New Product</button>
                            <?php
                            }
                            ?>
                        </div>

                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">variants</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Quantity (total)</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                // Include database connection
                                include "config/conn.php";

                                // Set number of results per page
                                $results_per_page = 8;

                                // Find out the number of results stored in database
                                $sql = "SELECT COUNT(*) AS total FROM `products_new`";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $total_results = $row['total'];

                                // Determine number of pages needed
                                $number_of_pages = ceil($total_results / $results_per_page);

                                // Determine which page number visitor is currently on
                                if (!isset($_GET['page']) || $_GET['page'] <= 0) {
                                    $page = 1;
                                } else {
                                    $page = (int)$_GET['page'];
                                }

                                // Determine the SQL LIMIT starting number for the results on the displaying page
                                $this_page_first_result = ($page - 1) * $results_per_page;


                                // SQL query
                                $sql = "SELECT `id`, `product_name`, `sku`, `product_id`, `category`, `description`, `benefits`, `product_usage`, `key_benefits`, `selected_tags`, `variants`, `image_paths`, `created_at` FROM `products_new` WHERE 1";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Initialize an array to store product data
                                    $products = [];

                                    // Fetch and parse JSON columns
                                    while ($row = $result->fetch_assoc()) {
                                        // Decode JSON columns
                                        $row['key_benefits'] = json_decode($row['key_benefits'], true);
                                        $row['variants'] = json_decode($row['variants'], true);
                                        $row['image_paths'] = json_decode($row['image_paths'], true);

                                        // Debugging: Display decoded JSON data for each column
                                        // echo "<pre>";
                                        // echo "Product Name: " . htmlspecialchars($row['product_name']) . "\n";
                                        // echo "Key Benefits:\n";
                                        // print_r($row['key_benefits']);

                                        // echo "Variants:\n";
                                        // print_r($row['variants']);

                                        // echo "Image Paths:\n";
                                        // print_r($row['image_paths']);
                                        // echo "</pre>";

                                        // Add row to products array after debugging
                                        $products[] = $row;
                                    }
                                } else {
                                    echo "No products found";
                                }
                                $conn->close();

                                ?>

                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <!-- Display first image if available -->
                                            <td>
                                                <!-- <?php if (!empty($product['image_paths'][0])): ?>
                                                    <img src="<?= htmlspecialchars($product['image_paths'][0]) ?>" alt="Product Image" style="width:50px; height:50px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?> -->
                                                <!-- Display Product Name -->
                                                <?= htmlspecialchars($product['product_name']) ?>
                                            </td>


                                            <!-- Display Status -->
                                            <td>
                                                <?php
                                                $inStock = false;

                                                // Check if any variant has stock greater than 0
                                                if (is_array($product['variants'])) {
                                                    foreach ($product['variants'] as $variant) {
                                                        if ($variant['stock'] > 0) {
                                                            $inStock = true;
                                                            break;
                                                        }
                                                    }
                                                }

                                                // Set status text and color
                                                $statusText = $inStock ? 'In Stock' : 'Out of Stock';
                                                $statusColor = $inStock ? 'green' : 'red';
                                                ?>
                                                <span style="color: <?= $statusColor ?>;"><?= $statusText ?></span>
                                            </td>

                                            <!-- Display Variants with Quantity and Price -->
                                            <td>
                                                <?php if (is_array($product['variants'])): ?>
                                                    <ul>
                                                        <?php foreach ($product['variants'] as $variant): ?>
                                                            <li>
                                                                <?= htmlspecialchars($variant['quantity']) ?> - ₹<?= htmlspecialchars($variant['price']) ?>
                                                                (Stock: <?= htmlspecialchars($variant['stock']) ?>)
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <span>N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $totalQuantity = 0;

                                                // Calculate the total quantity if variants exist
                                                if (is_array($product['variants'])) {
                                                    foreach ($product['variants'] as $variant) {
                                                        // Ensure the quantity is numeric before adding
                                                        $totalQuantity += is_numeric($variant['stock']) ? (int)$variant['stock'] : 0;
                                                    }
                                                }
                                                ?>
                                                <?= htmlspecialchars($totalQuantity) ?>
                                            </td>

                                            <td>
                                                <?php
                                                $edit = $_SESSION['edit_access'];
                                                $delete = $_SESSION['delete_access'];
                                                if ($edit == 1) {
                                                ?>
                                                    <button class="btn btn-warning btn-sm animate__animated animate__fadeIn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-id="<?= $product['product_id'] ?>"
                                                        data-name="<?= htmlspecialchars($product['product_name']) ?>"
                                                        data-sku="<?= htmlspecialchars($product['sku']) ?>"
                                                        data-category="<?= htmlspecialchars($product['category']) ?>"
                                                        data-description="<?= htmlspecialchars($product['description']) ?>"
                                                        data-benefits="<?= htmlspecialchars($product['benefits']) ?>"
                                                        data-product_usage="<?= htmlspecialchars($product['product_usage']) ?>"
                                                        data-key_benefits="<?= htmlspecialchars(json_encode($product['key_benefits'])) ?>"
                                                        data-selected_tags="<?= htmlspecialchars($product['selected_tags']) ?>"
                                                        data-variants="<?= htmlspecialchars(json_encode($product['variants'])) ?>"
                                                        data-image_paths="<?= htmlspecialchars(json_encode($product['image_paths'])) ?>">
                                                        Edit
                                                    </button>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if ($delete == 1) {
                                                ?>
                                                    <button class="btn btn-danger btn-sm animate__animated animate__fadeIn"
                                                        onclick="deleteProduct('<?= $product['sku'] ?>')"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal">
                                                        Delete
                                                    </button>
                                                <?php
                                                }
                                                ?>

                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>


                            </table>

                            <!-- Pagination controls -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination" style="display: flex;justify-content:center;">
                                    <?php for ($i = 1; $i <= $number_of_pages; $i++): ?>
                                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>









<!-- Delete Confirmation Modal -->
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product with SKU ID: <strong id="productSku"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Open Delete Modal and Set SKU ID
    function deleteProduct(sku) {
        // Display SKU in the modal
        document.getElementById('productSku').textContent = sku;

        // Attach SKU to the confirm button's data attribute
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.setAttribute('data-sku', sku);
    }

    // Handle Delete Confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const sku = this.getAttribute('data-sku');

        // AJAX request to server for deletion
        fetch('config/delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    sku: sku
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Notify success
                    alert('Product deleted successfully!');
                } else {
                    // Notify failure
                    alert(data.message || 'Failed to delete product.');
                }

                // Hide the modal
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                deleteModal.hide();

                // Optionally, refresh or remove the product from the UI
                location.reload(); // Refresh the page (or remove the product row dynamically)
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the product.');
            });
    });
</script>





















<!-- Modal for Edit Product -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="productId" name="productId">

                    <!-- Product Details -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="selectedTagsContainer" class="form-label">Selected Tags</label>
                            <div id="selectedTagsContainer" class="tags-container"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="productId" class="form-label">Product Id</label>
                            <input type="text" class="form-control" id="productIdEdit" name="productIdEdit" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" readonly required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                    </div>

                    <!-- Key Benefits section with dynamic input fields -->
                    <div class="mb-3" id="keyBenefitsContainer">
                        <label for="keyBenefits" class="form-label">Key Benefits</label>
                        <!-- Dynamic key benefits inputs will be inserted here -->
                    </div>

                    <!-- Other product-related fields -->
                    <!-- <div class="mb-3">
                        <label for="selectedTags" class="form-label">Selected Tags</label>
                        <input type="text" class="form-control" id="selectedTags" name="selectedTags">
                    </div> -->
                    <!-- Quantity, Price, and Stock Quantity with Dynamic Addition -->
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-11">
                            <div id="quantityContainer">
                                <!-- The rows will be dynamically added here -->
                            </div>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-secondary add-quantity" title="Add more quantity">+</button>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="benefits" class="form-label">Benefits</label>
                        <textarea class="form-control" id="benefits" name="benefits" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productUsage" class="form-label">Product Usage</label>
                        <textarea class="form-control" id="productUsage" name="productUsage" rows="3" required></textarea>
                    </div>





                    <!-- <div class="mb-3">
                        <label for="imagePaths" class="form-label">Image Paths</label>
                        <textarea class="form-control" id="imagePaths" name="imagePaths" rows="3"></textarea>
                    </div> -->

                    <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    console.log("12");
    // When the modal is opened, populate the fields with product data
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // Button that triggered the modal
        console.log("Modal opened");

        // Get product data from button's data attributes
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const sku = button.getAttribute('data-sku');
        const category = button.getAttribute('data-category');
        const description = button.getAttribute('data-description');
        const benefits = button.getAttribute('data-benefits');
        const productUsage = button.getAttribute('data-product_usage');
        const keyBenefitsData = button.getAttribute('data-key_benefits'); // Key benefits string
        const selectedTags = button.getAttribute('data-selected_tags');
        const variantsData = button.getAttribute('data-variants'); // Variants string
        const imagePaths = button.getAttribute('data-image_paths');

        // Debug: Log product data
        console.log('selectedTags:', selectedTags);
        console.log('Product Name:', name);
        console.log('Key Benefits Data:', keyBenefitsData);

        // Ensure modal inputs exist before trying to populate them
        const productIdField = document.getElementById('productIdEdit');
        const productNameField = document.getElementById('productName');
        const skuField = document.getElementById('sku');
        const categoryField = document.getElementById('category');
        const descriptionField = document.getElementById('description');
        const benefitsField = document.getElementById('benefits');
        const productUsageField = document.getElementById('productUsage');
        // const selectedTagsField = document.getElementById('selectedTagsedit');
        const variantsField = document.getElementById('variants');
        const imagePathsField = document.getElementById('imagePaths');

        if (productIdField) productIdField.value = id;
        if (productNameField) productNameField.value = name;
        if (skuField) skuField.value = sku;
        if (categoryField) categoryField.value = category;
        if (descriptionField) descriptionField.value = description;
        if (benefitsField) benefitsField.value = benefits;
        if (productUsageField) productUsageField.value = productUsage;
        // if (selectedTagsField) selectedTagsField.value = selectedTags;
        // if (variantsField) variantsField.value = variants;
        if (imagePathsField) imagePathsField.value = imagePaths;



        // Debug: Log the fetched tags
        console.log('Selected Tags:', selectedTags);

        // Clear previous tags
        const selectedTagsContainer = document.getElementById('selectedTagsContainer');
        selectedTagsContainer.innerHTML = '';

        if (selectedTags) {
            try {
                // Parse JSON string into an array
                const tagsArray = JSON.parse(selectedTags);

                // Create a tag element for each tag in the array
                tagsArray.forEach(tag => {
                    const tagElement = document.createElement('span');
                    tagElement.classList.add('tag', 'selected'); // Initially green
                    tagElement.textContent = tag;

                    // Handle toggle on click
                    tagElement.addEventListener('click', function() {
                        if (tagElement.classList.contains('selected')) {
                            // Deselect: Change to yellow
                            tagElement.classList.remove('selected');
                            tagElement.classList.add('unselected');
                        } else {
                            // Select: Change to green
                            tagElement.classList.remove('unselected');
                            tagElement.classList.add('selected');
                        }

                        // Send updated tag states to the server
                        // sendUpdatedTags();
                    });

                    selectedTagsContainer.appendChild(tagElement);
                });
            } catch (error) {
                console.error('Error parsing selectedTags:', error);
            }
        }






        console.log("Inputs populated");

        // Safely parse key benefits JSON
        let keyBenefits = [];
        try {
            keyBenefits = keyBenefitsData ? JSON.parse(keyBenefitsData) : [];
            console.log('Parsed Key Benefits:', keyBenefits); // Log parsed data for validation
        } catch (error) {
            console.error('Failed to parse key benefits JSON:', error);
            keyBenefits = []; // Fallback to empty array if parsing fails
        }

        // Dynamically generate input fields for Key Benefits
        const keyBenefitsContainer = document.getElementById('keyBenefitsContainer');
        keyBenefitsContainer.innerHTML = ''; // Clear existing input fields

        // Check if keyBenefits array is empty
        if (keyBenefits.length > 0) {
            keyBenefits.forEach((benefit, index) => {
                const inputWrapper = document.createElement('div');
                inputWrapper.classList.add('mb-3');

                const label = document.createElement('label');
                label.setAttribute('for', `keyBenefit${index}`);
                label.classList.add('form-label');
                label.textContent = `Key Benefit ${index + 1}`;

                const input = document.createElement('input');
                input.type = 'text';
                input.classList.add('form-control');
                input.id = `keyBenefit${index}`;
                input.name = `keyBenefits[]`; // Array format for form submission
                input.value = benefit;

                // Append label and input to the wrapper div
                inputWrapper.appendChild(label);
                inputWrapper.appendChild(input);

                // Append the wrapper div to the keyBenefitsContainer
                keyBenefitsContainer.appendChild(inputWrapper);
            });
        } else {
            // If no key benefits available, show a message
            keyBenefitsContainer.innerHTML = '<p>No key benefits available.</p>';
        }

        // Debugging the variants data
        console.log('Variants Data:', variantsData); // Check if variantsData is a string or an object

        // Safely parse the variants data
        let variants = [];
        try {
            variants = variantsData ? JSON.parse(variantsData) : [];
            console.log('Parsed Variants:', variants); // Log parsed variants for validation
        } catch (error) {
            console.error('Failed to parse variants data:', error);
            variants = []; // Fallback to empty array if parsing fails
        }

        // Convert variants object to an array for iteration
        const variantsArray = Object.values(variants);

        // Function to render the product variants dynamically
        function renderVariants(data) {
            const container = document.getElementById('quantityContainer');
            container.innerHTML = ''; // Clear previous content

            // Loop through each variant and create the form fields
            data.forEach((variant, index) => {
                console.log('Rendering variant:', variant); // Debugging each variant

                const row = document.createElement('div');
                row.classList.add('row', 'quantity-row', 'mb-3');

                // Quantity Column
                const quantityCol = document.createElement('div');
                quantityCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                quantityCol.innerHTML = `
                    <label for="productQuantity" class="form-label">Quantity</label>
                    <select class="form-control" name="productQuantity[]" required>
                        <option value="">Select Quantity</option>
                        <option value="100gm" ${variant.quantity === "100gm" ? "selected" : ""}>100 gm</option>
                        <option value="200gm" ${variant.quantity === "200gm" ? "selected" : ""}>200 gm</option>
                        <option value="500gm" ${variant.quantity === "500gm" ? "selected" : ""}>500 gm</option>
                        <option value="1kg" ${variant.quantity === "1kg" ? "selected" : ""}>1 kg</option>
                    </select>
                `;

                // MRP Price Column
                const priceCol = document.createElement('div');
                priceCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                priceCol.innerHTML = `
                    <label for="mrpPrice" class="form-label">Price (MRP)</label>
                    <input type="number" class="form-control mrp-price" name="quantityPrice[]" value="${variant.price}" placeholder="Enter MRP" required>
                `;

                // Discount Column
                const discountCol = document.createElement('div');
                discountCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                discountCol.innerHTML = `
                    <label for="discount" class="form-label">% Discount</label>
                    <input type="number" class="form-control discount" name="discount[]" value="${variant.discount}" placeholder="Enter discount %" required>
                `;

                // Selling Price Column
                const sellingPriceCol = document.createElement('div');
                sellingPriceCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                sellingPriceCol.innerHTML = `
                    <label for="sellingPrice" class="form-label">Selling Price</label>
                    <input type="number" class="form-control selling-price" name="sellingPrice[]" value="${variant.sellingPrice}" placeholder="Auto-calculated" readonly>
                `;

                // Stock Quantity Column
                const stockCol = document.createElement('div');
                stockCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                stockCol.innerHTML = `
                    <label for="productStock" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" name="productStock[]" value="${variant.stock}" placeholder="Enter stock quantity" required>
                `;

                // Tax Column
                const taxCol = document.createElement('div');
                taxCol.classList.add('col-lg-2', 'col-md-4', 'col-sm-6', 'mb-3');
                taxCol.innerHTML = `
                    <label for="productTax" class="form-label">Tax</label>
                    <select class="form-control" name="productTax[]" id="productTax" required>
                        <option value="">Select Tax</option>
                        <option value="included tax" ${variant.tax === "included tax" ? "selected" : ""}>included tax</option>
                        <option value="Excluded tax" ${variant.tax === "Excluded tax" ? "selected" : ""}>Excluded tax</option>
                       
                    </select>
                `;



                // <option value="included tax">Included tax</option>
                // <option value="Excluded tax">Excluded tax</option>




                // Append columns to the row
                row.appendChild(quantityCol);
                row.appendChild(priceCol);
                row.appendChild(discountCol);
                row.appendChild(sellingPriceCol);
                row.appendChild(stockCol);
                row.appendChild(taxCol);

                // Append row to container
                container.appendChild(row);
            });
        }

        // Render the variants
        renderVariants(variantsArray);

        console.log("Variants rendered");
    });
</script>



<!-- update server side php ajax call  -->

<script>
    // Handle form submission (example with fetch API)
    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this); // Gather form data


        // Gather all selected tags
        const selectedTags = Array.from(document.querySelectorAll('.tags-container .selected')).map(tag => tag.textContent);

        // Add selected tags to formData
        formData.append('selectedTags', JSON.stringify(selectedTags));

        // console.log('Payload to send:', payload);

        // Debug: Log the form data before submission
        console.log('Form Data:', [...formData]);

        // Send data to server via fetch (you can replace the URL with your PHP endpoint)
        fetch('config/update_product.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Product details updated successfully!');
                    location.reload(); // Reload the page after successful update
                } else {
                    alert('Failed to update product details!');
                }
            })
            .catch(error => alert('Error: ' + error));
    });
</script>












































<style>
    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }

    .tag-badge {
        display: inline-block;
        margin-right: 5px;
        margin-top: 5px;
    }
</style>




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




<!-- Full-Screen Modal Structure -->
<div class="modal fade" id="productModal" style="z-index: 1060;" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Include your database connection file
                include "config/conn.php";

                // Fetch categories and subcategories
                $sql = "SELECT `category_name`, `sub_category_name` FROM `product_categories`";
                $result = $conn->query($sql);

                $categories = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $categories[] = $row;
                    }
                }
                ?>



                <form id="productForm" enctype="multipart/form-data">


                    <?php

                    // Fetch tags from the database
                    $sql = "SELECT * FROM tags";
                    $result = $conn->query($sql);

                    $tags = [];
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tags[] = $row;
                        }
                    }

                    ?>

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

                    <!-- Quantity, Price, and Stock Quantity with Dynamic Addition -->
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-11">
                            <div id="quantityContainer">
                                <div class="row quantity-row mb-3">
                                    <!-- Quantity Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="productQuantity" class="form-label">Quantity (gm/Kg) <span class="text-danger">*</span></label>
                                        <select class="form-control" name="productQuantity[]" required>
                                            <option value="">Select Quantity</option>
                                            <option value="100gm">100 gm</option>
                                            <option value="200gm">200 gm</option>
                                            <option value="500gm">500 gm</option>
                                            <option value="1kg">1 kg</option>
                                        </select>
                                    </div>

                                    <!-- MRP Price Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="mrpPrice" class="form-label">Price (MRP) <span class="text-danger">*</span> </label>
                                        <input type="number" class="form-control mrp-price" name="quantityPrice[]" placeholder="Enter MRP" required>
                                    </div>

                                    <!-- Discount Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="discount" class="form-label">% Discount <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control discount" name="discount[]" placeholder="Enter discount %" required>
                                    </div>

                                    <!-- Selling Price Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="sellingPrice" class="form-label">Selling Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control selling-price" name="sellingPrice[]" placeholder="Auto-calculated" readonly>
                                    </div>

                                    <!-- Stock Quantity Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="productStock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="productStock[]" placeholder="Enter stock quantity" required>
                                    </div>

                                    <!-- Tax Column -->
                                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                        <label for="productTax" class="form-label">Tax <span class="text-danger">*</span></label>
                                        <select class="form-control" name="productTax[]" id="productTax" required>
                                            <option value="">Select tax</option>
                                            <option value="included tax">Included tax</option>
                                            <option value="Excluded tax">Excluded tax</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-secondary add-quantity" title="Add more quantity">+</button>
                        </div>
                    </div>



                    <!-- Key Benefits with Dynamic Addition -->
                    <div class="row mb-3">
                        <label class="form-label">Key Benefits <span class="text-danger">*</span></label>
                        <div id="keyBenefitsContainer" class="col-md-12">
                            <div class="mb-2">
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                                <input type="text" class="form-control mb-2" name="keyBenefits[]" placeholder="Enter key benefit" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="addKeyBenefit" class="btn btn-sm btn-secondary mt-2">Add More Key Benefits</button>
                        </div>
                    </div>

                    <!-- Text Areas for Product Details -->
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Product Description <span class="text-danger">*</span> </label>
                        <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Enter product description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productBenefits" class="form-label">Product Benefits <span class="text-danger">*</span> </label>
                        <textarea class="form-control" id="productBenefits" name="productBenefits" rows="3" placeholder="Enter product benefits" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productUsage" class="form-label">Product Usage <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="productUsage" name="productUsage" rows="3" placeholder="Enter product usage" required></textarea>
                    </div>

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
                                        <input type="file" class="form-control" name="productMedia[]" accept="image/*,video/*" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-secondary add-image" title="Add new image">Add New Image</button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm" id="submitButton">Save Product</button>
                    </div>
                </form>





















                <script>
                    document.addEventListener('input', function(event) {
                        if (event.target.classList.contains('mrp-price') || event.target.classList.contains('discount')) {
                            // Get the parent row
                            const row = event.target.closest('.quantity-row');

                            // Get MRP, Discount, and Selling Price input fields within this row
                            const mrpInput = row.querySelector('.mrp-price');
                            const discountInput = row.querySelector('.discount');
                            const sellingPriceInput = row.querySelector('.selling-price');

                            // Parse the values
                            const mrp = parseFloat(mrpInput.value) || 0;
                            const discount = parseFloat(discountInput.value) || 0;

                            // Calculate the selling price
                            const sellingPrice = mrp - (mrp * (discount / 100));

                            // Set the selling price in the Selling Price input
                            sellingPriceInput.value = sellingPrice.toFixed(2);
                        }
                    });
                </script>



                <script>
                    // JavaScript to add new quantity rows
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
                <script>
                    // Load tags from PHP
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
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Auto-generate SKU and Product ID when the modal is opened
    document.getElementById('productModal').addEventListener('show.bs.modal', function() {
        document.getElementById('productSKU').value = generateUniqueSKU();
        document.getElementById('productID').value = generateUniqueProductID();
    });

    // Function to generate a unique SKU
    function generateUniqueSKU() {
        return 'SKU' + Math.floor(100000000000 + Math.random() * 900000000000);
    }

    // Function to generate a unique Product ID
    function generateUniqueProductID() {
        return 'PROD-' + Math.floor(1000000000 + Math.random() * 9000000000);
    }





    // Form submission
    $('#productForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Update hidden input with final selected tags before submission
        updateSelectedTagsInput();

        const formData = new FormData(this); // FormData will include selectedTags from hidden input

        // Debugging: Log all form data to verify selectedTags
        console.log('FormData contents before submission:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Send form data to server
        fetch('config/product.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                if (data.success) {
                    alert('Product saved successfully!');
                    $('#productModal').modal('hide'); // Hide modal
                    $('#productForm')[0].reset(); // Reset form
                    selectedTags = []; // Reset selected tags
                    updateSelectedTagsInput(); // Clear hidden input
                    displaySelectedTags(); // Clear displayed tags
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error in fetch:', error);
                alert('An error occurred while saving the product.');
            })
            .finally(() => {
                $('#submitButton').prop('disabled', false); // Re-enable button after processing
            });
    });
</script>





<script>
    // Function to generate a unique SKU with 10-15 characters
    // function generateUniqueSKU() {
    //     return 'SKU' + Math.floor(100000000000 + Math.random() * 900000000000); // 12-digit unique number
    // }

    // // Function to generate a unique Product ID with 10-15 characters
    // function generateUniqueProductID() {
    //     return 'PROD-' + Math.floor(1000000000 + Math.random() * 9000000000); // 10-digit unique number
    // }

    // // Auto-generate SKU and Product ID when the modal is opened
    // document.getElementById('productModal').addEventListener('show.bs.modal', function() {
    //     document.getElementById('productSKU').value = generateUniqueSKU();
    //     document.getElementById('productID').value = generateUniqueProductID();
    // });
</script>



<?php

include "includes/footer.php";

?>