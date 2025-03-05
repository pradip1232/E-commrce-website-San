<?php
include 'conn.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["category_name"])) {
        $category_name = trim($_POST["category_name"]);
        $subcategory_name = trim($_POST["subcategory_name"]);

        // Prevent SQL Injection
        $category_name = mysqli_real_escape_string($conn, $category_name);

        // Check if category already exists
        $checkQuery = "SELECT * FROM product_categories WHERE category_name = '$subcategory_name'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo json_encode(["success" => false, "message" => "Category already exists!"]);
        } else {
            // Insert category into DB
            $insertQuery = "INSERT INTO product_categories  (category_name , sub_category_name) VALUES ('$category_name','$subcategory_name')";
            if (mysqli_query($conn, $insertQuery)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Category name is required!"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

mysqli_close($conn);
