<?php
header('Content-Type: application/json');
include 'conn.php';

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$sku = $data['sku'];

if (!$sku) {
    echo json_encode(['success' => false, 'message' => 'SKU is missing.']);
    exit;
}

// First, check if the product exists
$query = "SELECT * FROM products_new WHERE sku = '$sku'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found.']);
    exit;
}

// Now, delete the product using direct SQL
$deleteQuery = "DELETE FROM products_new WHERE sku = '$sku'";
if (mysqli_query($conn, $deleteQuery)) {
    echo json_encode(['success' => true, 'message' => 'Product Deleted']);
} else {
    echo json_encode(['error' => false, 'message' => 'Failed to delete the product.']);
}
?>
