<?php
require "conn.php"; // Database connection file

// Allow cross-origin requests from any server
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins (Change * to specific domain for security)
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests for CORS (OPTIONS method)
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get raw POST data (handles JSON payloads from fetch/AJAX)
    // Extract values with fallback
    $productID = $_POST['productID'] ?? '';
    $productSKU = $_POST['productSKU'] ?? '';
    $productName = $_POST['productName'] ?? '';
    $productCategory = $_POST['productCategory'] ?? '';
    $productDescription = $_POST['productDescription'] ?? '';
    $productBenefits = $_POST['productBenefits'] ?? '';
    $productUsage = $_POST['productUsage'] ?? '';
    $productDetails = $_POST['productDetails'] ?? '';

    // Handling arrays: Convert to JSON for storage
    $selectedTags = isset($_POST['selectedTags']) ? json_encode($_POST['selectedTags']) : json_encode([]);
    $keyBenefits = isset($_POST['keyBenefits']) ? json_encode(array_filter($_POST['keyBenefits'])) : json_encode([]);





    if (!empty($_FILES['productImg']['name'][0])) {
        $uploadDir = "uploads/";
        $uploadedFiles = [];
        foreach ($_FILES['productImg']['name'] as $key => $imgName) {
            $imgTmpName = $_FILES['productImg']['tmp_name'][$key];
            $imgSize = $_FILES['productImg']['size'][$key];
            $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            // Validate file type
            if (!in_array($imgExt, $allowedExtensions)) {
                echo json_encode(["error" => "Invalid file format: $imgName"]);
                exit;
            }

            // Validate file size (limit: 5MB)
            if ($imgSize > 10 * 1024 * 1024) {
                echo json_encode(["error" => "File $imgName exceeds 10MB limit."]);
                exit;
            }

            // Generate a unique filename
            $newImgName = time() . "_" . uniqid() . "." . $imgExt;
            $uploadPath = $uploadDir . $newImgName;

            // Move file
            if (move_uploaded_file($imgTmpName, $uploadPath)) {
                $uploadedFiles[] = $newImgName;
            } else {
                echo json_encode(["error" => "Failed to upload $imgName"]);
                exit;
            }
        }

        $jsonFileNames = json_encode($uploadedFiles);


        // echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "No image uploaded or an error occurred."]);
    }

    $productDetails2 = json_encode($productDetails);


    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO products 
        (product_id, product_sku, product_name, product_category, product_description, product_benefits, product_usage, key_benefits, selected_tags,img_name , product_details) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");

    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("sssssssssss", $productID, $productSKU, $productName, $productCategory, $productDescription, $productBenefits, $productUsage, $keyBenefits, $selectedTags, $jsonFileNames, $productDetails2);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added successfully!"]);
    } else {
        echo json_encode(["success" => false, "error" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
