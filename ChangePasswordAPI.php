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
    $currentPassword = $data['User']['current_password'] ?? '';
    $newPassword = $data['User']['new_password'] ?? '';
    $confirmPassword = $data['User']['confirm_password'] ?? '';

    // Validate required fields
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Current password, new password, and confirmation are required.']);
        exit();
    }

    // Check if new password matches confirmation
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'New password and confirmation do not match.']);
        exit();
    }

    // Dummy check for current password (this would be replaced with database verification)
    $dummyUser = [
        'email' => 'john.doe@example.com',
        'password' => 'password123'  // In practice, you'd hash this password
    ];

    if ($currentPassword === $dummyUser['password']) {
        // Assume password change is successful (here you'd update the password in the database)
        echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
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
