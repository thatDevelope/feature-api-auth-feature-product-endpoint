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
    // Mock data for the blog
    $blogPosts = [
        [
            "id" => 1,
            "title" => "Understanding Web3",
            "author" => "John Doe",
            "date" => "2025-01-06",
            "content" => "Web3 is the next evolution of the internet, focusing on decentralization and blockchain-based technology.",
            "tags" => ["Web3", "Blockchain", "Technology"]
        ],
        [
            "id" => 2,
            "title" => "Tips for Better Productivity",
            "author" => "Jane Smith",
            "date" => "2025-01-05",
            "content" => "Discover how to stay productive with proven tips and tools to maximize your time.",
            "tags" => ["Productivity", "Self-Help", "Lifestyle"]
        ],
        [
            "id" => 3,
            "title" => "Exploring Artificial Intelligence",
            "author" => "Alan Turing",
            "date" => "2025-01-04",
            "content" => "AI is transforming industries. Learn more about how machine learning and AI are impacting our world.",
            "tags" => ["AI", "Machine Learning", "Innovation"]
        ]
    ];

    // Check if an ID is provided in the query string
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id']; // Convert to integer for safety

        // Search for the blog post with the given ID
        $blogPost = array_filter($blogPosts, function ($post) use ($id) {
            return $post['id'] === $id;
        });

        // If blog post is found, return it
        if (!empty($blogPost)) {
            $response = [
                "status" => "success",
                "message" => "Blog post fetched successfully.",
                "data" => array_values($blogPost)[0] // Reset array keys
            ];
        } else {
            // If no blog post is found, return an error
            $response = [
                "status" => "error",
                "message" => "Blog post not found.",
                "data" => null
            ];
        }
    } else {
        // If no ID is provided, return all blog posts
        $response = [
            "status" => "success",
            "message" => "All blog posts fetched successfully.",
            "data" => $blogPosts
        ];
    }

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
