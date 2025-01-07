<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the ID document (Base64) is provided
    if (!isset($data['id_document']) || empty($data['id_document'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID document is required.']);
        exit();
    }

    // Decode Base64 file
    $base64File = $data['id_document'];
    $fileParts = explode(',', $base64File);
    $fileData = base64_decode(end($fileParts));

    // Ensure the uploads directory exists
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    // Save the decoded file
    $filePath = $uploadDir . 'mock-id.jpg';
    if (file_put_contents($filePath, $fileData)) {
        $response = [
            'status' => 'success',
            'message' => 'ID document has been successfully uploaded and verified.',
            'data' => [
                'verification_status' => 'verified',
                'uploaded_file' => $filePath
            ]
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Failed to save the ID document.'
        ];
    }

    // Return response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If not POST, return method not allowed
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only POST requests are allowed.'
    ]);
}
?>
