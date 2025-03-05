<?php
require "conn.php"; // Database connection file

// Allow cross-origin requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_POST['product_id'] ?? '';
    $batch_number = $_POST['batch_number'] ?? '';
    $sku = $_POST['sku'] ?? '';

    if (empty($product_id) || empty($batch_number) || empty($sku)) {
        echo json_encode(["success" => false, "message" => "Missing required parameters"]);
        exit;
    }

    // Fetch existing product details where product_id and sku match
    $stmt = $conn->prepare("SELECT product_details FROM products WHERE product_id = ? AND product_sku = ?");
    $stmt->bind_param("ss", $product_id, $sku);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Product with given ID and SKU not found"]);
        exit;
    }

    $product = $result->fetch_assoc();
    $stmt->close();

    // Decode JSON product details
    $productDetails = json_decode($product['product_details'], true);

    // Debugging: Print all available batches
    // echo "Available Batches: " . json_encode($productDetails);
    // Convert all batch keys to lowercase for comparison
    $batchKeys = array_map('strtolower', array_keys($productDetails));
    $batchNumberLower = strtolower($batch_number);

    $matchingKey = array_search($batchNumberLower, $batchKeys);

    if ($matchingKey === false) {
        echo json_encode(["success" => false, "message" => "Batch not found"]);
        exit;
    }

    // Get the actual batch key (original case)
    $actualBatchKey = array_keys($productDetails)[$matchingKey];

    // Remove the batch using the original key
    unset($productDetails[$actualBatchKey]);

    // Update database with new JSON data
    $updatedProductDetails = json_encode($productDetails);
    $updateStmt = $conn->prepare("UPDATE products SET product_details = ? WHERE product_id = ?");
    $updateStmt->bind_param("ss", $updatedProductDetails, $product_id);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Batch deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update product details"]);
    }

    $updateStmt->close();
    $conn->close();
}
