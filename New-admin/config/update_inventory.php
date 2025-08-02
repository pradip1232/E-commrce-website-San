
<?php
header('Content-Type: application/json');
include 'db_con.php';

// Get the JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input or missing inventory ID']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE inventory SET inventory_number = ?, date_uploaded = ?, party_name = ?, billing_number = ?, product_id = ?, custom_batch_name = ?, mrp = ?, discount = ?, selling_price = ?, stock_quantity = ?, packagingwithunit = ?, manufacturing_date = ?, expiration_date = ? WHERE id = ? OR inventory_number");
    $stmt->bind_param(
        'ssssisdddisssis',
        $input['inventoryNumber'],
        $input['inventoryDate'],
        $input['partyName'],
        $input['billingNumber'],
        $input['productId'],
        $input['customBatchName'],
        $input['mrp'],
        $input['discount'],
        $input['sellingPrice'],
        $input['stockQuantity'],
        $input['packagingwithunit'],
        $input['manufacturingDate'],
        $input['expirationDate'],
        $input['id'],
        $input["inventory_number"]
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inventory updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update inventory']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating inventory: ' . $e->getMessage()]);
}

$conn->close();
?>