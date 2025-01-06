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
    // Response data
    $response = [
        "status" => "success",
        "message" => "Terms and Conditions page is working perfectly!",
        "data" => [
            "title" => "Terms and Conditions",
            "content" => "These Terms and Conditions govern your use of our services and website. By accessing or using our platform, you agree to these terms."
        ]
    ];

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
