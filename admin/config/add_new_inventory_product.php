<?php


require "conn.php"; // Database connection file

// Allow cross-origin requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $product_sku = $_POST['product_sku'];
    $product_id = $_POST['product_id'];
    $cost_price = $_POST['cost_price'];
    $discount = $_POST['discount'];
    $selling_price = $_POST['selling_price'];
    $mrp = $_POST['mrp'];
    $stock_quantity = $_POST['stock_quantity'];
    $packaging = $_POST['packaging_details'];
    $product_offers = $_POST['product_offers'];

    // Check if the product exists
    $check_query = "SELECT product_details FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch existing product details
        $stmt->bind_result($existing_details);
        $stmt->fetch();
        $stmt->close();

        // Decode existing JSON data safely
        $existing_data = !empty($existing_details) ? json_decode($existing_details, true) : [];

        if (!is_array($existing_data)) {
            $existing_data = []; // Ensure it's an array
        }

        // Check for JSON errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON format in database"]);
            exit;
        }

        // Generate new batch number
        $batch_number = 1;
        while (isset($existing_data["batch$batch_number"])) {
            $batch_number++;
        }

        // Prepare new batch data
        $existing_data["batch$batch_number"] = [
            "cost_price" => $cost_price,
            "discount" => $discount,
            "selling_price" => $selling_price,
            "mrp" => $mrp,
            "stock_quantity" => $stock_quantity,
            "packaging" => $packaging,
            "product_offers" => $product_offers
        ];

        // Convert updated data to JSON
        $updated_product_details = json_encode($existing_data, JSON_PRETTY_PRINT);

        // Update query
        $update_query = "UPDATE products SET product_details = ? WHERE product_sku = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $updated_product_details, $product_sku);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Batch added", "batch" => "batch$batch_number"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found"]);
    }

    $conn->close();
}



// {
//     "batch1": {
//         "cost_price": "68",
//         "discount": "68",
//         "selling_price": "21.76",
//         "mrp": "768",
//         "stock_quantity": "76",
//         "packaging": "87 gm"
//     },
//     "batch2": {
//         "cost_price": "4423423",
//         "discount": "43",
//         "selling_price": "2521351.11",
//         "mrp": "3434",
//         "stock_quantity": "34",
//         "packaging": "43 gm"
//     },
//     "batch3": {
//         "cost_price": "4534534",
//         "discount": "44",
//         "selling_price": "2539339.04",
//         "mrp": "343",
//         "stock_quantity": "43",
//         "packaging": "43 gm"
//     },
//     "batch4": {
//         "cost_price": "4534534",
//         "discount": "44",
//         "selling_price": "2539339.04",
//         "mrp": "343",
//         "stock_quantity": "43",
//         "packaging": "43 gm"
//     }
// }