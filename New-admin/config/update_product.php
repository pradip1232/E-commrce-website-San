
<?php
header('Content-Type: application/json');
include 'db_con.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input or missing product ID']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE products SET product_sku = ?, product_name = ?, product_category = ?, hsn_number = ?, tax_rate = ?, key_benefits = ?, description = ?, product_benefits = ?, product_usage = ?, images = ?, videos = ? WHERE product_id = ?");
    $images = implode(',', $input['images']);
    $videos = implode(',', $input['videos']);
    $stmt->bind_param(
        'ssssssssssss',
        $input['product_sku'],
        $input['product_name'],
        $input['product_category'],
        $input['hsn_number'],
        $input['tax_rate'],
        $input['key_benefits'],
        $input['description'],
        $input['product_benefits'],
        $input['product_usage'],
        $images,
        $videos,
        $input['product_id']
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update product']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error updating product: ' . $e->getMessage()]);
}

$conn->close();
?>