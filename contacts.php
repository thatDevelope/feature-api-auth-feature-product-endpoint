<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'vendor/autoload.php';

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow POST and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow specific headers

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
    $fullName = $data['ContactForm']['full_name'] ?? 'No Name';
    $email = $data['ContactForm']['email'] ?? 'no-email@example.com';
    $subject = $data['ContactForm']['subject'] ?? 'No Subject';
    $body = $data['ContactForm']['body'] ?? 'No Body';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.booknest.com.ng'; // Your SMTP server
        $mail->SMTPAuth = true; 
        $mail->Username = 'support@booknest.com.ng'; // Your email address
        $mail->Password = 'U5E)%v.;R_X8'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL
        $mail->Port = 465; // SSL port

        // Recipients
        $mail->setFrom('support@booknest.com.ng', 'Booknest Support');
        $mail->addAddress('tsirchi@gmail.com', 'Recipient Name'); // Add a recipient
        $mail->addReplyTo($email, $fullName);

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "
            <html>
            <head>
                <title>$subject</title>
            </head>
            <body>
                <h3>$subject</h3>
                <p><strong>Name:</strong> $fullName</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Message:</strong><br>$body</p>
            </body>
            </html>
        ";

        // Send the email
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
}
