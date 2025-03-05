<?php
// Database configuration
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = '';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve product data
    $productName = $_POST['productName'] ?? null;
    $productSKU = $_POST['productSKU'] ?? null;
    $productID = $_POST['productID'] ?? null;
    $productCategory = $_POST['productCategory'] ?? null;
    $productDescription = $_POST['productDescription'] ?? null;
    $productBenefits = $_POST['productBenefits'] ?? null;
    $productUsage = $_POST['productUsage'] ?? null;
    $selectedTags = $_POST['selectedTags'] ?? null;



    // Process key benefits into JSON format
    $keyBenefitsArray = $_POST['keyBenefits'] ?? [];
    $keyBenefitsJson = json_encode($keyBenefitsArray);

    // Image upload configuration
    $uploadDir = 'uploads/';
    $uploadedFileNames = [];

    // Handle multiple images
    foreach ($_FILES['productImg']['name'] as $index => $originalFileName) {
        if (!empty($originalFileName)) {
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
            $newFileName = $fileName . '.' . $fileExtension;
            $counter = 1;

            // Generate a unique file name if file exists
            while (file_exists($uploadDir . $newFileName)) {
                $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
                $counter++;
            }

            if (move_uploaded_file($_FILES['productImg']['tmp_name'][$index], $uploadDir . $newFileName)) {
                $uploadedFileNames[] = $newFileName;
            } else {
                echo json_encode(['success' => false, 'message' => "Failed to upload file: $originalFileName"]);
                exit;
            }
        }
    }

    // Process variant data into JSON format
    $productQuantities = $_POST['productQuantity'] ?? [];
    $productPrices = $_POST['quantityPrice'] ?? [];
    $productStocks = $_POST['productStock'] ?? [];
    $variantsArray = [];

    foreach ($productQuantities as $index => $quantity) {
        $price = $productPrices[$index] ?? 0;
        $stock = $productStocks[$index] ?? 0;
        $variantsArray[] = [
            'quantity' => $quantity,
            'price' => $price,
            'stock' => $stock
        ];
    }
    $variantsJson = json_encode($variantsArray);

    // Insert all data into the `products` table in JSON format
    $stmt = $conn->prepare("INSERT INTO products_enso (product_name, sku, product_id, category, description, benefits, product_usage,   variants, image_paths) VALUES (?, ?, ?, ?, ?, ?, ?,  ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $imagePathsJson = json_encode($uploadedFileNames);
    $stmt->bind_param("sssssssss", $productName, $productSKU, $productID, $productCategory, $productDescription, $productBenefits, $productUsage,  $variantsJson, $imagePathsJson);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
        exit;
    }

    // Success response
    echo json_encode(['success' => true, 'message' => 'Product and variants added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the connection
$conn->close();
