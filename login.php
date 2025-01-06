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
    $email = $data['User']['email'] ?? '';
    $password = $data['User']['password'] ?? '';

    // Validate required fields
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
        exit();
    }

    // Simple email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit();
    }

    // Dummy check for user authentication (this should be replaced with actual database validation)
    $dummyUser = [
        'email' => 'john.doe@example.com',
        'password' => 'password123', // In practice, you should hash passwords (use password_hash() in PHP)
    ];

    // Check if email and password match the dummy data
    if ($email === $dummyUser['email'] && $password === $dummyUser['password']) {
        // Dummy user data that would normally be fetched from the database
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $dummyUser['email'],
            'mobile_no' => '+1234567890',
            'reference_name' => 'Google',
            'address' => '123 Main Street, City, Country'
        ];

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful.',
            'data' => $userData
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    }

} else {
    // If not POST, return method not allowed
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
?>
