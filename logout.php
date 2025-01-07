<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Preflight request OK
    exit();
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dummy logout process (In practice, you would destroy the session or invalidate the token)
    
    // Assuming session is being used, you would call session_destroy() here:
    // session_start();
    // session_destroy();

    echo json_encode([
        'status' => 'success',
        'message' => 'Logged out successfully.'
    ]);

} else {
    // If not POST, return method not allowed
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
?>
