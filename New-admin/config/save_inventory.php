<?php
include 'db_con.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !is_array($data)) {
    echo json_encode(['success' => false, 'message' => 'Invalid or empty data received.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO inventory (inventory_number, date_uploaded, party_name, billing_number, product_id, custom_batch_name, mrp, discount, selling_price, stock_quantity, packagingwithunit, manufacturing_date, expiration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: (' . $conn->errno . ') ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssssssdidsiss", $inventory_number, $date_uploaded, $party_name, $billing_number, $productId, $customBatchName, $mrp, $discount, $sellingPrice, $stockQuantity, $packagingwithunit, $manufacturingDate, $expirationDate);

foreach ($data as $item) {
    $productId = $item['productId'] ?? null;
    $customBatchName = $item['customBatchName'] ?? '';
    $mrp = $item['mrp'] ?? 0;
    $discount = $item['discount'] ?? 0;
    $sellingPrice = $item['sellingPrice'] ?? 0;
    $stockQuantity = $item['stockQuantity'] ?? 0;
    $packagingwithunit = $item['packagingwithunit'] ?? '';
    $manufacturingDate = $item['manufacturingDate'] ?? null;
    $expirationDate = $item['expirationDate'] ?? null;
    $inventory_number = $item['inventoryNumber'] ?? null;
    $date_uploaded = $item['inventoryDate'] ?? null;
    $party_name = $item['partyName'] ?? null;
    $billing_number = $item['billingNumber'] ?? null;

    if (!$productId || !$inventory_number || !$date_uploaded || !$party_name || !$billing_number || !$mrp || !$discount || !$stockQuantity || !$packagingwithunit || !$manufacturingDate || !$expirationDate) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields in item data.']);
        exit;
    }

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
        exit;
    }
}

$stmt->close();
$conn->close();
echo json_encode(['success' => true, 'message' => 'Inventory saved successfully.']);
