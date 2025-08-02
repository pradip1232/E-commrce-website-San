<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
require 'db_con.php';
error_log("Starting save_inventory.php");

$data = json_decode(file_get_contents('php://input'), true);
error_log("Received data: " . json_encode($data));

if (!$data || !is_array($data) || empty($data)) {
    error_log("Invalid or empty data received");
    echo json_encode(['success' => false, 'message' => 'Invalid or empty data received']);
    exit;
}

try {
    $conn->begin_transaction(); // Start transaction for atomicity
    error_log("Transaction started");

    $stmt = $conn->prepare("INSERT INTO inventory (inventory_number, date_uploaded, party_name, billing_number, product_id, custom_batch_name, mrp, discount, selling_price, stock_quantity, packagingwithunit, manufacturing_date, expiration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        $conn->rollback();
        exit;
    }

    $stmt->bind_param(
        "ssssssdddisss",
        $inventory_number,
        $inventory_date,
        $party_name,
        $billing_number,
        $product_id,
        $custom_batch_name,
        $mrp,
        $discount,
        $selling_price,
        $stock_quantity,
        $packagingwithunit,
        $manufacturing_date,
        $expiration_date
    );

    foreach ($data as $index => $item) {
        // Extract and validate fields
        $inventory_number = isset($item['inventoryNumber']) ? (string)$item['inventoryNumber'] : '';
        $inventory_date = isset($item['inventoryDate']) ? (string)$item['inventoryDate'] : '';
        $party_name = isset($item['partyName']) ? (string)$item['partyName'] : '';
        $billing_number = isset($item['billingNumber']) ? (string)$item['billingNumber'] : '';
        $product_id = isset($item['productId']) ? (string)$item['productId'] : ''; // Changed to string
        $custom_batch_name = isset($item['customBatchName']) ? (string)$item['customBatchName'] : '';
        $mrp = isset($item['mrp']) ? floatval($item['mrp']) : 0.0;
        $discount = isset($item['discount']) ? floatval($item['discount']) : 0.0;
        $selling_price = isset($item['sellingPrice']) ? floatval($item['sellingPrice']) : 0.0;
        $stock_quantity = isset($item['stockQuantity']) ? intval($item['stockQuantity']) : 0;
        $packagingwithunit = isset($item['packagingwithunit']) ? (string)$item['packagingwithunit'] : '';
        $manufacturing_date = isset($item['manufacturingDate']) ? (string)$item['manufacturingDate'] : '';
        $expiration_date = isset($item['expirationDate']) ? (string)$item['expirationDate'] : '';

        // Validate required fields
        $missing_fields = [];
        if (empty($inventory_number)) $missing_fields[] = 'Inventory Number';
        if (empty($inventory_date)) $missing_fields[] = 'Inventory Date';
        if (empty($party_name)) $missing_fields[] = 'Party Name';
        if (empty($billing_number)) $missing_fields[] = 'Billing Number';
        if ($mrp <= 0) $missing_fields[] = 'MRP';
        if ($discount < 0 || $discount > 100) $missing_fields[] = 'Discount';
        if ($selling_price < 0) $missing_fields[] = 'Selling Price';
        if ($stock_quantity < 0) $missing_fields[] = 'Stock Quantity';
        if (empty($packagingwithunit)) $missing_fields[] = 'Packaging with Unit';
        if (empty($manufacturing_date)) $missing_fields[] = 'Manufacturing Date';
        if (empty($expiration_date)) $missing_fields[] = 'Expiration Date';

        if (!empty($missing_fields)) {
            error_log("Missing or invalid fields in item $index: " . implode(', ', $missing_fields));
            echo json_encode(['success' => false, 'message' => "Missing or invalid fields in item " . ($index + 1) . ": " . implode(', ', $missing_fields)]);
            $conn->rollback();
            exit;
        }

        // Validate date logic
        $mDate = new DateTime($manufacturing_date);
        $eDate = new DateTime($expiration_date);
        if ($mDate > $eDate) {
            error_log("Invalid dates in item $index: Manufacturing date ($manufacturing_date) is after Expiration date ($expiration_date)");
            echo json_encode(['success' => false, 'message' => "Invalid dates in item " . ($index + 1) . ": Manufacturing date cannot be later than expiration date"]);
            $conn->rollback();
            exit;
        }

        // Validate selling price (optional, based on MRP and discount)
        $expected_selling_price = $mrp * (1 - $discount / 100);
        if (abs($selling_price - $expected_selling_price) > 0.01) {
            error_log("Selling price mismatch in item $index: provided=$selling_price, expected=$expected_selling_price");
            echo json_encode(['success' => false, 'message' => "Selling price mismatch in item " . ($index + 1) . ": Provided $selling_price, expected approximately $expected_selling_price"]);
            $conn->rollback();
            exit;
        }

        error_log("Executing insert for item $index: product_id=$product_id");
        if (!$stmt->execute()) {
            error_log("Insert failed for item $index: " . $stmt->error);
            echo json_encode(['success' => false, 'message' => "Insert failed for item " . ($index + 1) . ": " . $stmt->error]);
            $conn->rollback();
            exit;
        }
    }

    $stmt->close();
    $conn->commit();
    error_log("Transaction committed successfully");
    echo json_encode(['success' => true, 'message' => 'Inventory saved successfully']);
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
    $conn->rollback();
} finally {
    $conn->close();
    error_log("Database connection closed");
}
