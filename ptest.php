<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'djfounda_sanjiveeka_Newdata';
$username = 'djfounda_sanjiveeka_data';
$password = 'sanjiveeka_data@123';

$groupedProducts = [];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT `id`, `product_name`, `sku`, `product_id`, `category`, `description`, `benefits`, `product_usage`, `key_benefits`, `selected_tags`, `variants`, `image_paths`, `created_at` FROM `products_new`";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $imageFolderPath = 'admin/config/uploads/';
    $defaultImageFolderPath = '/assets/images/default_images/'; 

    $formattedProducts = [];

    $categoryImages = [];
    foreach (glob($defaultImageFolderPath . "*.{png,jpg,jpeg,webp}", GLOB_BRACE) as $file) {
        $categoryName = ucfirst(pathinfo($file, PATHINFO_FILENAME)); 
        $categoryImages[$categoryName] = $file;
    }

    foreach ($products as $product) {
        $productName = $product['product_name'];
        $category = $product['category'];
        $productId = $product['product_id'];

        // $imagePath = $categoryImages[$category] ?? $imageFolderPath . "default.png";
        $imagePath = $categoryImages[$category];

        $imagePaths = json_decode($product['image_paths'], true); 
        if (is_array($imagePaths) && !empty($imagePaths)) {
            $imagePath = $imageFolderPath . $imagePaths[0];
        }

        // Initialize total quantity and price
        $totalQuantity = 0;
        $variantPrice = null;

        $variants = json_decode($product['variants'], true); 
        if (is_array($variants)) {
            foreach ($variants as $variant) {
                $totalQuantity += $variant['quantity'];
                if ($variantPrice === null && is_numeric($variant['price'])) {
                    $variantPrice = (float)$variant['price']; 
                }
            }
        }

        $formattedProduct = [
            "id" => $product['product_id'],
            "title" => $product['product_name'],
            "sku" => $product['sku'],
            "image" => $imagePath,
            "description" => $product['description'],
            "total_quantity" => $totalQuantity,
            "price" => $variantPrice !== null ? $variantPrice : 'N/A' 
        ];

        $groupedProducts[$category][] = $formattedProduct;
    }

    $json_data = json_encode($groupedProducts, JSON_PRETTY_PRINT);
    file_put_contents('item.json', $json_data);

    echo "Product data has been successfully saved to item.json";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>