<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // Handle CORS preflight requests
}

require 'db_con.php';

// Start output buffering to capture debug output
ob_start();

// Debug POST and FILES data
echo "POST Data:\n";
print_r($_POST);
echo "FILES Data:\n";
print_r($_FILES);

// Get JSON data from FormData
$data = [];
if (isset($_POST['data'])) {
    $rawInput = $_POST['data'];
    echo "Raw JSON Input from POST:\n";
    echo $rawInput . "\n";
    $data = json_decode($rawInput, true);
    echo "Parsed JSON data:\n";
    print_r($data);
} else {
    echo "No JSON data provided in POST['data']\n";
    $data = [[]]; // Default to single empty row to allow file uploads
}

// Initialize arrays for file uploads
$uploadedImages = [];
$uploadedVideos = [];

// Handle image uploads
if (isset($_FILES['productImages']) && !empty($_FILES['productImages']['name'][0])) {
    echo "Processing image uploads:\n";
    print_r($_FILES['productImages']);
    $uploadDir = 'Uploads/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "Created directory: $uploadDir\n";
    } else {
        echo "Directory exists: $uploadDir\n";
    }

    foreach ($_FILES['productImages']['name'] as $key => $name) {
        echo "Processing image: $name\n";
        if ($_FILES['productImages']['error'][$key] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['productImages']['tmp_name'][$key];
            $fileName = basename($name);
            $filePath = $uploadDir . $fileName;
            $counter = 1;

            // Ensure unique file name
            while (file_exists($filePath)) {
                $filePath = $uploadDir . pathinfo($fileName, PATHINFO_FILENAME) . "_$counter." . pathinfo($fileName, PATHINFO_EXTENSION);
                $counter++;
            }
            echo "Generated file path: $filePath\n";

            if (move_uploaded_file($tmpName, $filePath)) {
                $formattedName = "img" . (count($uploadedImages) + 1) . ":" . basename($filePath);
                $uploadedImages[] = $formattedName;
                echo "Image uploaded successfully: $filePath, Formatted: $formattedName\n";
                if (file_exists($filePath)) {
                    echo "Confirmed: Image exists at $filePath\n";
                } else {
                    echo "Error: Image not found at $filePath after upload\n";
                }
            } else {
                echo "Failed to upload image: $fileName\n";
                $debugOutput = ob_get_clean();
                echo json_encode(["status" => "error", "message" => "Failed to upload image: $fileName", "debug" => $debugOutput]);
                exit;
            }
        } else {
            echo "Upload error for image: $name, Error code: " . $_FILES['productImages']['error'][$key] . "\n";
            $debugOutput = ob_get_clean();
            echo json_encode(["status" => "error", "message" => "Upload error for image: $name", "debug" => $debugOutput]);
            exit;
        }
    }
} else {
    echo "No images provided or empty image array\n";
}

// Handle video uploads
if (isset($_FILES['productVideos']) && !empty($_FILES['productVideos']['name'][0])) {
    echo "Processing video uploads:\n";
    print_r($_FILES['productVideos']);
    $uploadDir = 'Uploads/videos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
        echo "Created directory: $uploadDir\n";
    } else {
        echo "Directory exists: $uploadDir\n";
    }

    foreach ($_FILES['productVideos']['name'] as $key => $name) {
        echo "Processing video: $name\n";
        if ($_FILES['productVideos']['error'][$key] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['productVideos']['tmp_name'][$key];
            $fileName = basename($name);
            $filePath = $uploadDir . $fileName;
            $counter = 1;

            // Ensure unique file name
            while (file_exists($filePath)) {
                $filePath = $uploadDir . pathinfo($fileName, PATHINFO_FILENAME) . "_$counter." . pathinfo($fileName, PATHINFO_EXTENSION);
                $counter++;
            }
            echo "Generated file path: $filePath\n";

            if (move_uploaded_file($tmpName, $filePath)) {
                $formattedName = "vid" . (count($uploadedVideos) + 1) . ":" . basename($filePath);
                $uploadedVideos[] = $formattedName;
                echo "Video uploaded successfully: $filePath, Formatted: $formattedName\n";
                if (file_exists($filePath)) {
                    echo "Confirmed: Video exists at $filePath\n";
                } else {
                    echo "Error: Video not found at $filePath after upload\n";
                }
            } else {
                echo "Failed to upload video: $fileName\n";
                $debugOutput = ob_get_clean();
                echo json_encode(["status" => "error", "message" => "Failed to upload video: $fileName", "debug" => $debugOutput]);
                exit;
            }
        } else {
            echo "Upload error for video: $name, Error code: " . $_FILES['productVideos']['error'][$key] . "\n";
            $debugOutput = ob_get_clean();
            echo json_encode(["status" => "error", "message" => "Upload error for video: $name", "debug" => $debugOutput]);
            exit;
        }
    }
} else {
    echo "No videos provided or empty video array\n";
}

try {
    $stmt = $conn->prepare("INSERT INTO products (product_id, product_sku, product_name, product_category, hsn_number, tax_rate, key_benefits, description, product_benefits, product_usage, images, videos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Failed to prepare SQL statement: " . $conn->error . "\n";
        $debugOutput = ob_get_clean();
        echo json_encode(["status" => "error", "message" => "Failed to prepare SQL statement: " . $conn->error, "debug" => $debugOutput]);
        exit;
    }
    echo "Prepared SQL statement\n";

    // If no JSON data, use a single row with uploaded files
    if (empty($data[0])) {
        $data = [[
            'product_id' => 'PRD' . time(),
            'product_sku' => 'SKU' . time(),
            'product_name' => 'Default Product',
            'product_category' => 'Default',
            'hsn_number' => '00000',
            'tax_rate' => '0.00',
            'key_benefits' => 'None',
            'description' => 'None',
            'product_benefits' => 'None',
            'product_usage' => 'None'
        ]];
        echo "No JSON data provided; using default product row\n";
    }

    foreach ($data as $index => $row) {
        echo "Processing product row " . ($index + 1) . "\n";
        // Validate required fields
        if (
            !isset($row['product_id']) || !isset($row['product_sku']) || !isset($row['product_name']) ||
            !isset($row['product_category']) || !isset($row['hsn_number']) || !isset($row['tax_rate']) ||
            !isset($row['key_benefits']) || !isset($row['description']) || !isset($row['product_benefits']) ||
            !isset($row['product_usage'])
        ) {
            echo "Missing required fields in row " . ($index + 1) . ":\n";
            print_r($row);
            $debugOutput = ob_get_clean();
            echo json_encode(["status" => "error", "message" => "Missing required fields in row " . ($index + 1), "debug" => $debugOutput]);
            exit;
        }

        // Prepare data for insertion
        $product_id = $row['product_id'];
        $product_sku = $row['product_sku'];
        $product_name = $row['product_name'];
        $product_category = $row['product_category'];
        $hsn_number = $row['hsn_number'];
        $tax_rate = $row['tax_rate'];
        $key_benefits = $row['key_benefits'];
        $description = $row['description'];
        $product_benefits = $row['product_benefits'];
        $product_usage = $row['product_usage'];
        $images = implode(',', $uploadedImages);
        $videos = implode(',', $uploadedVideos);

        echo "Prepared data for insertion:\n";
        echo "product_id=$product_id\n";
        echo "product_sku=$product_sku\n";
        echo "product_name=$product_name\n";
        echo "product_category=$product_category\n";
        echo "hsn_number=$hsn_number\n";
        echo "tax_rate=$tax_rate\n";
        echo "key_benefits=$key_benefits\n";
        echo "description=$description\n";
        echo "product_benefits=$product_benefits\n";
        echo "product_usage=$product_usage\n";
        echo "images=$images\n";
        echo "videos=$videos\n";

        // Bind parameters
        $stmt->bind_param(
            'ssssisssssss',
            $product_id,
            $product_sku,
            $product_name,
            $product_category,
            $hsn_number,
            $tax_rate,
            $key_benefits,
            $description,
            $product_benefits,
            $product_usage,
            $images,
            $videos
        );

        // Execute the statement
        if ($stmt->execute()) {
            echo "Successfully inserted product: $product_id\n";
        } else {
            echo "Database error for product $product_id: " . $stmt->error . "\n";
            $debugOutput = ob_get_clean();
            echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error, "debug" => $debugOutput]);
            exit;
        }

        // Reset uploaded files for the next row
        $uploadedImages = [];
        $uploadedVideos = [];
        echo "Reset uploadedImages and uploadedVideos arrays\n";
    }

    $stmt->close();
    $conn->close();
    echo "Database connection closed\n";
    $debugOutput = ob_get_clean();
    echo json_encode(["status" => "success", "message" => "Products saved successfully", "debug" => $debugOutput]);
} catch (Exception $e) {
    echo "Exception occurred: " . $e->getMessage() . "\n";
    $debugOutput = ob_get_clean();
    echo json_encode(["status" => "error", "message" => "Error saving products: " . $e->getMessage(), "debug" => $debugOutput]);
    $conn->close();
    exit;
}
