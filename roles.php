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
    // Dummy roles and permissions data
    $userRolesAndPermissions = [
        'roles' => [
            'Admin',
            'Editor',
            'Viewer'
        ],
        'permissions' => [
            'edit_posts',
            'view_posts',
            'delete_posts',
            'create_posts'
        ]
    ];

    // Response data
    echo json_encode([
        'status' => 'success',
        'message' => 'Roles and permissions fetched successfully.',
        'data' => $userRolesAndPermissions
    ]);

} else {
    // If not GET, return method not allowed
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Only GET requests are allowed.'
    ]);
}
?>
