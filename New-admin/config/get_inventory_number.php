
<?php
header('Content-Type: application/json');
include 'db_con.php';

try {
    if (isset($_GET['id'])) {
        // Fetch existing inventory_number for edit modal
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT inventory_number FROM inventory WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'inventoryNumber' => $row['inventory_number']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Inventory item not found']);
        }
        $stmt->close();
    } else {
        // Generate new inventory_number for add modal
        $sql = "SELECT COUNT(*) as count FROM inventory";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'] + 1;
        $inventoryNumber = 'INV' . str_pad($count, 6, '0', STR_PAD_LEFT); // e.g., INV000001
        echo json_encode(['success' => true, 'inventoryNumber' => $inventoryNumber]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error generating inventory number: ' . $e->getMessage()]);
}

$conn->close();
?>