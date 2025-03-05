<?php

session_start();
include "includes/header.php";
include "includes/sidebar.php";
?>






<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <div class="container-fluid py-2">

        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Products</h6>
                            <button class="btn btn-primary text-capitalize me-3" data-bs-toggle="modal" data-bs-target="#productModal">Add New Product</button>
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
                <form id="productForm" enctype="multipart/form-data">


                    <!-- Tag Search and Selected Tags Section -->
                    <!-- <div class="form-group position-relative">
                        <label for="productID" class="form-label">Select Tags</label>

                        <input type="text" id="tagSearch" class="form-control" placeholder="Search tags">

                        <div id="tagButtons" class="mt-2"></div>

                        <input type="hidden" id="selectedTagsInput" name="selectedTags">
                    </div>

                    <div class="mt-3" id="selectedTags"></div> -->










                    <!-- Product ID and SKU -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productID" class="form-label">Product ID</label>
                            <input type="text" class="form-control" id="productID" name="productID" placeholder="Auto-generated ID" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productSKU" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="productSKU" name="productSKU" placeholder="Auto-generated SKU" readonly>
                        </div>
                    </div>

                    <!-- Product Name and Category -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="productCategory" class="form-label">Category</label>
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
                                    <div class="col-md-3">
                                        <label for="productQuantity" class="form-label">Quantity (S,M,L)</label>
                                        <select class="form-control" name="productQuantity[]" required>
                                            <option value="">Select Quantity</option>
                                            <option value="s">S</option>
                                            <option value="m">M</option>
                                            <option value="L">L</option>
                                            <option value="xl">XL</option>
                                            <option value="xxl">XXL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="productcolor" class="form-label">Colors</label>
                                        <select class="form-control" name="productcolor[]" required>
                                            <option value="">Select Quantity</option>
                                            <option value="red">Red</option>
                                            <option value="green">Green</option>
                                            <option value="blue">Blue</option>
                                            <option value="yellow">Yellow</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="quantityPrice" class="form-label">Price for Selected Quantity</label>
                                        <input type="number" class="form-control" name="quantityPrice[]" placeholder="Enter price for selected quantity" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="productStock" class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" name="productStock[]" placeholder="Enter stock quantity" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-secondary add-quantity" title="Add more quantity">+</button>
                        </div>
                    </div>

                    <!-- Key Benefits with Dynamic Addition -->
                    <!-- <div class="row mb-3">
                        <label class="form-label">Key Benefits</label>
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
                    </div> -->

                    <!-- Text Areas for Product Details -->
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Product Description</label>
                        <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Enter product description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productBenefits" class="form-label">Product Benefits</label>
                        <textarea class="form-control" id="productBenefits" name="productBenefits" rows="3" placeholder="Enter product benefits"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productUsage" class="form-label">Product Usage</label>
                        <textarea class="form-control" id="productUsage" name="productUsage" rows="3" placeholder="Enter product usage" required></textarea>
                    </div>

                    <!-- Image Upload with Dynamic Addition -->
                    <div class="row mb-3">
                        <div class="col-md-10">
                            <div id="imageUploadContainer">
                                <div class="row image-upload-row mb-2">
                                    <div class="col-md-10">
                                        <label for="productImg" class="form-label">Product Images</label>
                                        <input type="file" class="form-control" name="productImg[]" required>
                                    </div>
                                </div>
                            </div>
                            <div id="imageUploadContainer">
                                <div class="row image-upload-row mb-2">
                                    <div class="col-md-10">
                                        <label for="productImg" class="form-label">Product Images</label>
                                        <input type="file" class="form-control" name="productImg[]" required>
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
        fetch('config/product2.php', {
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