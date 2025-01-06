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
        "message" => "Acceptable Use Policy page is working perfectly!",
        "data" => [
            "title" => "Acceptable Use Policy",
            "content" => "This Acceptable Use Policy outlines the rules and guidelines for using our services responsibly and ethically."
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
