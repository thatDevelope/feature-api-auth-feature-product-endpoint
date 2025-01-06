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
    // Get JSON data from request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract form data
    $firstName = $data['User']['first_name'] ?? '';
    $lastName = $data['User']['last_name'] ?? '';
    $email = $data['User']['email'] ?? '';
    $mobileNo = $data['User']['mobile_no'] ?? '';
    $address = $data['User']['address'] ?? '';
    $referenceName = $data['User']['reference_name'] ?? '';

    // Validate required fields (you can add more validation as needed)
    if (empty($firstName) || empty($lastName) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'First name, last name, and email are required.']);
        exit();
    }

    // Dummy data to simulate a successful update (this would be replaced by a database query)
    $updatedUser = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'mobile_no' => $mobileNo,
        'address' => $address,
        'reference_name' => $referenceName
    ];

    // Assume successful update (you would update the database here)
    echo json_encode([
        'status' => 'success',
        'message' => 'User information updated successfully.',
        'data' => $updatedUser
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
