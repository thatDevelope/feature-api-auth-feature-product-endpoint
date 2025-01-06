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

// Check if the request is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Dummy data for the discount zone
    $discountedItems = [
        [
            "id" => 1,
            "product_name" => "Wireless Headphones",
            "original_price" => 100.00,
            "discount_price" => 70.00,
            "discount_percentage" => 30,
            "description" => "High-quality wireless headphones with noise cancellation.",
            "image_url" => "https://example.com/images/headphones.jpg"
        ],
        [
            "id" => 2,
            "product_name" => "Smartphone",
            "original_price" => 500.00,
            "discount_price" => 450.00,
            "discount_percentage" => 10,
            "description" => "Latest model smartphone with amazing features.",
            "image_url" => "https://example.com/images/smartphone.jpg"
        ],
        [
            "id" => 3,
            "product_name" => "Electric Kettle",
            "original_price" => 50.00,
            "discount_price" => 35.00,
            "discount_percentage" => 30,
            "description" => "Fast-boil electric kettle with auto shut-off feature.",
            "image_url" => "https://example.com/images/kettle.jpg"
        ]
    ];

    // Check if an ID is provided in the query string
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id !== null) {
        // Search for the item by ID
        $filteredItem = array_filter($discountedItems, function ($item) use ($id) {
            return $item['id'] === $id;
        });

        if (!empty($filteredItem)) {
            // Return the item if found
            $response = [
                "status" => "success",
                "message" => "Item fetched successfully.",
                "data" => array_values($filteredItem)[0] // Reset array keys and return a single item
            ];
        } else {
            // Return an error if item not found
            $response = [
                "status" => "error",
                "message" => "Item with ID $id not found.",
                "data" => null
            ];
        }
    } else {
        // Return the full list if no ID is provided
        $response = [
            "status" => "success",
            "message" => "Discounted items fetched successfully.",
            "data" => $discountedItems
        ];
    }

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If not GET, return method not allowed
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only GET requests are allowed."
    ]);
}
