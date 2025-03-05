<?php
session_start();
require 'conn.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $userEmail = $_SESSION['user_email']; // Get user email from session
    $productId = $_POST['product_id'];    // Get product ID from POST

    if ($action === 'add') {
        // Add product to wishlist
        $query = "INSERT INTO wishlist (user_email, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        
        // Bind the user email (string) and product ID (integer) parameters
        $stmt->bind_param('si', $userEmail, $productId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Product added to wishlist']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add product to wishlist: ' . $stmt->error]);
        }

    } elseif ($action === 'remove') {
        // Remove product from wishlist
        $query = "DELETE FROM wishlist WHERE user_email = ? AND product_id = ?";
        $stmt = $conn->prepare($query);

        // Bind the user email (string) and product ID (integer) parameters
        $stmt->bind_param('si', $userEmail, $productId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Product removed from wishlist']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove product from wishlist: ' . $stmt->error]);
        }
    }

    $stmt->close();
    $conn->close();
}
?>