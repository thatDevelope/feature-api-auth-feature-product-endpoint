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
    // Dummy data for products and services
    $items = [
        [
            "id" => 1,
            "name" => "Web Design Services",
            "category" => "Services",
            "description" => "Professional web design services to create stunning websites.",
            "price" => 300.00
        ],
        [
            "id" => 2,
            "name" => "Wireless Headphones",
            "category" => "Electronics",
            "description" => "High-quality wireless headphones with noise cancellation.",
            "price" => 70.00
        ],
        [
            "id" => 3,
            "name" => "Smartphone",
            "category" => "Electronics",
            "description" => "Latest model smartphone with amazing features.",
            "price" => 450.00
        ],
        [
            "id" => 4,
            "name" => "Digital Marketing Services",
            "category" => "Services",
            "description" => "Boost your online presence with expert digital marketing services.",
            "price" => 500.00
        ]
    ];

    // Check if a search query is provided
    $query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

    if ($query) {
        // Filter items based on the query
        $filteredItems = array_filter($items, function ($item) use ($query) {
            return strpos(strtolower($item['name']), $query) !== false ||
                   strpos(strtolower($item['category']), $query) !== false ||
                   strpos(strtolower($item['description']), $query) !== false;
        });

        // Response if matches are found
        if (!empty($filteredItems)) {
            $response = [
                "status" => "success",
                "message" => "Search results fetched successfully.",
                "data" => array_values($filteredItems) // Reset array keys
            ];
        } else {
            // Response if no matches are found
            $response = [
                "status" => "error",
                "message" => "No results found for the query.",
                "data" => []
            ];
        }
    } else {
        // Response if no query is provided
        $response = [
            "status" => "error",
            "message" => "No search query provided.",
            "data" => []
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
