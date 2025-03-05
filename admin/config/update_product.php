<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Database configuration
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Retrieve product data
$productName = $_POST['productName'] ?? null;
$productSKU = $_POST['sku'] ?? null;
$productID = $_POST['productIdEdit'] ?? null;
$productCategory = $_POST['category'] ?? null;
$productDescription = $_POST['description'] ?? null;
$productBenefits = $_POST['benefits'] ?? null;
$productUsage = $_POST['productUsage'] ?? null;
$selectedTags = $_POST['selectedTags'] ?? null;
$keyBenefitsArray = $_POST['keyBenefits'] ?? [];
$keyBenefitsJson = json_encode($keyBenefitsArray);

// Image upload configuration
$uploadDir = 'uploads/';
$uploadedFileNames = [];
$errors = [];

// Function to handle file uploads
function uploadFiles($files, $uploadDir, &$errors)
{
    $uploadedFiles = [];
    foreach ($files['name'] as $index => $originalFileName) {
        if (!empty($originalFileName)) {
            $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

            // Check allowed file types
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'mkv'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                $errors[] = "Unsupported file type: $originalFileName";
                continue;
            }

            // Generate unique file name
            $newFileName = $fileName . '.' . $fileExtension;
            $counter = 1;
            while (file_exists($uploadDir . $newFileName)) {
                $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
                $counter++;
            }

            // Move uploaded file
            if (move_uploaded_file($files['tmp_name'][$index], $uploadDir . $newFileName)) {
                $uploadedFiles[] = $newFileName;
            } else {
                $errors[] = "Failed to upload file: $originalFileName";
            }
        }
    }
    return $uploadedFiles;
}

// Process uploaded files
if (!empty($_FILES['productMedia']['name'][0])) {
    $uploadedFileNames = uploadFiles($_FILES['productMedia'], $uploadDir, $errors);
}
$imagePathsJson = json_encode($uploadedFileNames);

// Process variant data
$variantsArray = [];
$productQuantities = $_POST['productQuantity'] ?? [];
$productPrices = $_POST['quantityPrice'] ?? [];
$productStocks = $_POST['productStock'] ?? [];
$sellingPrices = $_POST['sellingPrice'] ?? [];
$productTaxes = $_POST['productTax'] ?? [];
$discounts = $_POST['discount'] ?? [];

foreach ($productQuantities as $index => $quantity) {
    $price = $productPrices[$index] ?? 0;
    $stock = $productStocks[$index] ?? 0;
    $sellingPrice = $sellingPrices[$index] ?? 0;
    $productTax = $productTaxes[$index] ?? 0;
    $discount = $discounts[$index] ?? 0;

    $variantsArray['variant' . ($index + 1)] = [
        'quantity' => $quantity,
        'price' => $price,
        'discount' => $discount,
        'sellingPrice' => $sellingPrice,
        'stock' => $stock,
        'productTax' => $productTax,
    ];
}
$variantsJson = json_encode($variantsArray);

// Update product in database
$stmt = $conn->prepare("
    UPDATE products_new 
    SET product_name = '$productName', 
        category = '$productCategory', 
        description = '$productDescription', 
        benefits = '$productBenefits', 
        product_usage = '$productUsage', 
        key_benefits = '$keyBenefitsJson', 
        selected_tags = '$selectedTags', 
        variants = '$variantsJson', 
        image_paths = '$imagePathsJson' 
    WHERE product_id = '$productID'
");

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

// Bind parameters (updated to match query placeholders)
// $stmt->bind_param(
//     "sssssssss",
//     $productName,
//     $productCategory,
//     $productDescription,
//     $productBenefits,
//     $productUsage,
//     $keyBenefitsJson,
//     $selectedTags,
//     $variantsJson,
//     $imagePathsJson,
//     $productID
// );

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Product updated successfully',
        'uploadedFiles' => $uploadedFileNames,
        'errors' => $errors,
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
exit;
