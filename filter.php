<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Preflight request OK
    exit();
}

// Dummy product data for Sodemart content
$products = [
    [
        "id" => 1,
        "name" => "Smartwatch",
        "category" => "Electronics",
        "price" => 150.00,
        "brand" => "BrandX",
        "description" => "A smartwatch with fitness tracking features.",
        "image_url" => "https://example.com/images/smartwatch.jpg"
    ],
    [
        "id" => 2,
        "name" => "Laptop",
        "category" => "Electronics",
        "price" => 800.00,
        "brand" => "BrandY",
        "description" => "High-performance laptop for work and gaming.",
        "image_url" => "https://example.com/images/laptop.jpg"
    ],
    [
        "id" => 3,
        "name" => "Leather Jacket",
        "category" => "Fashion",
        "price" => 200.00,
        "brand" => "BrandZ",
        "description" => "Premium quality leather jacket for men.",
        "image_url" => "https://example.com/images/jacket.jpg"
    ],
    [
        "id" => 4,
        "name" => "Headphones",
        "category" => "Electronics",
        "price" => 120.00,
        "brand" => "BrandX",
        "description" => "Noise-canceling headphones for a superior audio experience.",
        "image_url" => "https://example.com/images/headphones.jpg"
    ],
    [
        "id" => 5,
        "name" => "Running Shoes",
        "category" => "Fashion",
        "price" => 80.00,
        "brand" => "BrandA",
        "description" => "Comfortable running shoes designed for athletes.",
        "image_url" => "https://example.com/images/shoes.jpg"
    ]
];

// Handle filtering parameters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$priceMinFilter = isset($_GET['price_min']) ? floatval($_GET['price_min']) : null;
$priceMaxFilter = isset($_GET['price_max']) ? floatval($_GET['price_max']) : null;
$brandFilter = isset($_GET['brand']) ? $_GET['brand'] : null;

// Filter the products based on the parameters
$filteredProducts = array_filter($products, function ($product) use ($categoryFilter, $priceMinFilter, $priceMaxFilter, $brandFilter) {
    $isValid = true;

    if ($categoryFilter && $product['category'] !== $categoryFilter) {
        $isValid = false;
    }

    if ($priceMinFilter && $product['price'] < $priceMinFilter) {
        $isValid = false;
    }

    if ($priceMaxFilter && $product['price'] > $priceMaxFilter) {
        $isValid = false;
    }

    if ($brandFilter && $product['brand'] !== $brandFilter) {
        $isValid = false;
    }

    return $isValid;
});

// Response data
$response = [
    "status" => "success",
    "message" => "Products fetched successfully.",
    "data" => array_values($filteredProducts) // Reset array keys to 0-based index
];

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);



//filter by price_min or price_max or both,brand,category,

