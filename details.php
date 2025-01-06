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
    // Dummy data for details
    $details = [
        "id" => 101,
        "name" => "John Doe",
        "email" => "john.doe@example.com",
        "phone" => "+1234567890",
        "address" => "1234 Elm Street, Springfield, USA",
        "description" => "This is a dummy detailed description for the API. It can be used by the frontend developer to display detailed information on the UI.",
        "additional_info" => [
            "company" => "Tech Solutions Inc.",
            "position" => "Software Engineer",
            "joined_date" => "2022-05-01"
        ]
    ];

    // Response data
    $response = [
        "status" => "success",
        "message" => "Details fetched successfully.",
        "data" => $details
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
