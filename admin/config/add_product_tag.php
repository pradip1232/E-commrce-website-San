<?php
header("Content-Type: application/json");

include("conn.php");

// Retrieve Data from AJAX Request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tagName = trim($_POST["tagname"]);

    if (empty($tagName)) {
        echo json_encode(["success" => false, "error" => "Tag name cannot be empty!"]);
        exit;
    }

    // Check if Tag Already Exists
    $stmt = $conn->prepare("SELECT id FROM product_tags WHERE tag_name = ?");
    $stmt->bind_param("s", $tagName);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo json_encode(["success" => false, "error" => "Tag already exists!"]);
        exit;
    }
    $stmt->close();

    // Insert New Tag
    $stmt = $conn->prepare("INSERT INTO product_tags (tag_name) VALUES (?)");
    $stmt->bind_param("s", $tagName);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Database error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
