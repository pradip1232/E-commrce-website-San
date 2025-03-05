<?php
// Start session at the very beginning
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "conn.php";
// Set response type as JSON

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


// print_r($_POST);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $productName = $_POST["productName"];
 

    // Retrieve product data
    $selectedTags = $_POST['selectedTags'];
    $productID = $_POST['productID'];
    $productSKU = $_POST['productSKU'];
    $productCategory = $_POST['productCategory'];
    $productQuantities = $_POST['productQuantity'];
    $productPrices = $_POST['quantityPrice'];
    $discounts = $_POST['discount'];
    $sellingPrices = $_POST['sellingPrice'];
    $productStocks = $_POST['productStock'];
    $productTax = $_POST['productTax'];
    // $keyBenefitsArray = $_POST['keyBenefits'];
    $productDescription = $_POST['productDescription'];
    $productBenefits = $_POST['productBenefits'];
    $productUsage = $_POST['productUsage'];
    $img = $_FILES['productMedia']['name'] ;

    $keyBenefitsArray = $_POST['keyBenefits'] ;
    $keyBenefitsJson = json_encode($keyBenefitsArray);

  
$mainImg = $_FILES['productImg']['name'];  // Main image
$mediaFiles = $_FILES['productMedia']['name'];  // Additional product media (images or videos)
$uploadDir = 'uploads/';  // Ensure this directory exists and is writable
$uploadedFileNames = [];

// Handle the main image upload (check if it's a single or multiple file upload)
if (!empty($mainImg)) {
    if (is_array($mainImg)) {
        foreach ($mainImg as $index => $originalFileName) {
            if (!empty($originalFileName)) {
                $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

                // Check for allowed file types
                $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $allowedVideoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
                $isImage = in_array($fileExtension, $allowedImageExtensions);
                $isVideo = in_array($fileExtension, $allowedVideoExtensions);

                if (!$isImage && !$isVideo) {
                    echo json_encode(['success' => false, 'message' => "Unsupported file type: $originalFileName"]);
                    exit;
                }

                // Generate a unique file name
                $newFileName = $fileName . '.' . $fileExtension;
                $counter = 1;
                while (file_exists($uploadDir . $newFileName)) {
                    $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
                    $counter++;
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['productImg']['tmp_name'][$index], $uploadDir . $newFileName)) {
                    $uploadedFileNames[] = $newFileName;
                } else {
                    echo json_encode(['success' => false, 'message' => "Failed to upload main image: $originalFileName"]);
                    exit;
                }
            }
        }
    } else {
        $originalFileName = $mainImg;
        $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

        // Check for allowed file types
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedVideoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
        $isImage = in_array($fileExtension, $allowedImageExtensions);
        $isVideo = in_array($fileExtension, $allowedVideoExtensions);

        if (!$isImage && !$isVideo) {
            echo json_encode(['success' => false, 'message' => "Unsupported file type: $originalFileName"]);
            exit;
        }

        // Generate a unique file name
        $newFileName = $fileName . '.' . $fileExtension;
        $counter = 1;
        while (file_exists($uploadDir . $newFileName)) {
            $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
            $counter++;
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['productImg']['tmp_name'], $uploadDir . $newFileName)) {
            $uploadedFileNames[] = $newFileName;
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to upload main image: $originalFileName"]);
            exit;
        }
    }
}

// Handle the additional media upload (images or videos)
if (!empty($mediaFiles)) {
    if (is_array($mediaFiles)) {
        foreach ($mediaFiles as $index => $originalFileName) {
            if (!empty($originalFileName)) {
                $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
                $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

                // Check for allowed file types
                $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $allowedVideoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
                $isImage = in_array($fileExtension, $allowedImageExtensions);
                $isVideo = in_array($fileExtension, $allowedVideoExtensions);

                if (!$isImage && !$isVideo) {
                    echo json_encode(['success' => false, 'message' => "Unsupported file type: $originalFileName"]);
                    exit;
                }

                // Generate a unique file name
                $newFileName = $fileName . '.' . $fileExtension;
                $counter = 1;
                while (file_exists($uploadDir . $newFileName)) {
                    $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
                    $counter++;
                }

                // Move the uploaded file
                if (move_uploaded_file($_FILES['productMedia']['tmp_name'][$index], $uploadDir . $newFileName)) {
                    $uploadedFileNames[] = $newFileName;
                } else {
                    echo json_encode(['success' => false, 'message' => "Failed to upload file: $originalFileName"]);
                    exit;
                }
            }
        }
    } else {
        // Handle single media file upload
        $originalFileName = $mediaFiles;
        $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);

        // Check for allowed file types
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedVideoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
        $isImage = in_array($fileExtension, $allowedImageExtensions);
        $isVideo = in_array($fileExtension, $allowedVideoExtensions);

        if (!$isImage && !$isVideo) {
            echo json_encode(['success' => false, 'message' => "Unsupported file type: $originalFileName"]);
            exit;
        }

        // Generate a unique file name
        $newFileName = $fileName . '.' . $fileExtension;
        $counter = 1;
        while (file_exists($uploadDir . $newFileName)) {
            $newFileName = $fileName . '_' . $counter . '.' . $fileExtension;
            $counter++;
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['productMedia']['tmp_name'], $uploadDir . $newFileName)) {
            $uploadedFileNames[] = $newFileName;
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to upload file: $originalFileName"]);
            exit;
        }
    }
}

// Combine the filenames of all uploaded files into a single string (comma-separated)
$uploadedFileNamesStr = implode(',', $uploadedFileNames);

// Encode the file paths into JSON format
$imagePathsJson = json_encode($uploadedFileNamesStr);

// Return success response with the uploaded file names
echo json_encode(['success' => true, 'uploadedFiles' => $uploadedFileNamesStr]);

    // Process variant data into JSON format
    // $productQuantities = $_POST['productQuantity'] ?? [];
    // $productPrices = $_POST['quantityPrice'] ?? [];
    // $productStocks = $_POST['productStock'] ?? [];
    // $sellingPrices = $_POST['sellingPrice'] ?? [];
    // $productTax = $_POST['productTax'] ?? [];
    // $discounts = $_POST['discount'] ?? [];
    $variantsArray = [];

    foreach ($productQuantities as $index => $quantity) {
        $price = $productPrices[$index];
        $stock = $productStocks[$index];
        $sellingPrice = $sellingPrices[$index];
        $productTax = $productTax[$index];
        $discount = $discounts[$index];

        // Define each variant with a unique key like 'variant1', 'variant2', etc.
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

    // Optionally, store or print the JSON string
    // echo $variantsJson;

    // Insert all data into the `products` table in JSON format
    $stmt = $conn->prepare("INSERT INTO products_new (product_name, sku, product_id, category, description, benefits, product_usage, key_benefits, selected_tags, variants, image_paths) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

   
    $stmt->bind_param("sssssssssss", $productName, $productSKU, $productID, $productCategory, $productDescription, $productBenefits, $productUsage, $keyBenefitsJson, $selectedTags, $variantsJson, $imagePathsJson);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . $stmt->error]);
        exit;
    }

    // Success response
    echo json_encode(['success' => true, 'message' => 'Product and variants added successfully']);
    
    include "./../ptest.php";
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}


$response = [
    'success' => empty($errors),
    'uploadedFiles' => $uploadedFileNames,
    'errors' => $errors,
    'message' => empty($errors) ? 'Product and variants added successfully' : 'Some files could not be uploaded.',
];

ob_end_clean();
echo json_encode($response);
exit;
// Close the connection
$conn->close();
