<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Log errors to a specific file (optional)
ini_set('error_log', __DIR__ . '/error_log.txt');

// Handle CORS headers
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed headers

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Respond OK for preflight
    exit;
}

// Log the request for debugging
$log_file = __DIR__ . '/api_debug_log.txt'; // Debug log file
$request_data = [
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI'],
    'headers' => getallheaders(),
    'query' => $_GET,
    'body' => file_get_contents('php://input'),
];
file_put_contents($log_file, json_encode($request_data, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

// Handle the actual request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Send a custom header to trigger refresh behavior
    header("X-Page-Refresh: true");
    
    // Send a simple response to inform the client
    echo json_encode([
        "status" => "success",
        "message" => "Page should refresh."
    ], JSON_PRETTY_PRINT);
    exit;
} else {
    // Handle unsupported methods
    http_response_code(405); // Method Not Allowed
    exit;
}
