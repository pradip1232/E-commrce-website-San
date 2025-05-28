<?php
require 'db_con.php'; // adjust if needed

header('Content-Type: application/json');

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];

    // Sanitize input
    $category = $conn->real_escape_string($category);

    // Debug SQL
    $sql = "SELECT tax_rate FROM tax_rates WHERE category = '$category' ORDER BY from_date DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'tax_rate' => $row['tax_rate'],
            'category' => $category
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No data found for category',
            'query' => $sql
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Category not provided'
    ]);
}
