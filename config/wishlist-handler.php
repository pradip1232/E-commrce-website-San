<?php
header('Content-Type: application/json');
include "conn.php";

session_start();
// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$productId = intval($data['productId']); // Ensure productId is an integer
$userEmail = $_SESSION['user_email']; // Assuming user email is stored in session



// Check if the product is already in the wishlist
$sql = "SELECT * FROM wishlist WHERE user_email = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $userEmail, $productId); // 'si' for string and integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product is in wishlist, remove it
    $sql = "DELETE FROM wishlist WHERE user_email = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $userEmail, $productId);
    $stmt->execute();
    $inWishlist = false;
} else {
    // Product is not in wishlist, add it
    $sql = "INSERT INTO wishlist (user_email, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $userEmail, $productId);
    $stmt->execute();
    $inWishlist = true;
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'inWishlist' => $inWishlist]);
?>
