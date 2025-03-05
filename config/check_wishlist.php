<?php
session_start();
require 'conn.php';  // Your database connection file

$u= $_SESSION['user_email'];  // Assuming user_email is stored in session
$p = $_POST['product_id'];

// Prepare the SQL statement to check if the product exists in the wishlist
$query = "SELECT * FROM wishlist WHERE user_email = '$u' AND product_id = '$p'";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $userId, $productId);  // Bind user_email (string) and product_id (int)
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['in_wishlist' => true]);  // Product is in the wishlist
} else {
    echo json_encode(['in_wishlist' => false]); // Product is not in the wishlist
}
?>
