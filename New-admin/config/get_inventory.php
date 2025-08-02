<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db_con.php';
error_log("Starting get_inventory.php");

try {
    $sql = "SELECT i.id, i.inventory_number, i.product_id, p.product_name, i.custom_batch_name, i.mrp, i.discount, i.selling_price, i.stock_quantity, i.packagingwithunit, i.manufacturing_date, i.expiration_date, p.product_category 
            FROM inventory i 
            LEFT JOIN products p ON i.product_id = p.product_id";
    error_log("Executing query: $sql");
    $result = $conn->query($sql);

    if ($result === false) {
        error_log("Query failed: " . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Query failed: ' . $conn->error]);
        exit;
    }

    $inventory = [];
    if ($result->num_rows > 0) {
        error_log("Query returned " . $result->num_rows . " rows");
        while ($row = $result->fetch_assoc()) {
            error_log("Processing row: " . json_encode($row));
            $inventory[] = $row;
        }
    } else {
        error_log("No inventory items found in database");
    }
    echo json_encode(['success' => true, 'inventory' => $inventory]);
    $result->free();
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
}
$conn->close();
error_log("Database connection closed");
