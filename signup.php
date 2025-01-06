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
    $password = $data['User']['password'] ?? '';
    $confirmPassword = $data['User']['confirm_password'] ?? '';
    $mobileNo = $data['User']['mobile_no'] ?? '';
    $referenceName = $data['User']['reference_name'] ?? '';
    $dialCode = $data['User']['dial_code'] ?? '';
    $currencyId = $data['User']['currency_id'] ?? '';
    $address = $data['User']['address'] ?? '';
    $termsAccepted = isset($data['User']['termsCondition']) ? $data['User']['termsCondition'] : false;
    $gRecaptchaResponse = $data['User']['g-recaptcha-response'] ?? ''; // For captcha validation

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($mobileNo) || empty($termsAccepted)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit();
    }

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit();
    }

    // Simple email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit();
    }

    // Validate recaptcha (for demo purposes, we skip actual Google reCAPTCHA validation)
    // You would typically verify $gRecaptchaResponse with the Google API to confirm it's valid
    if (empty($gRecaptchaResponse)) {
        echo json_encode(['status' => 'error', 'message' => 'Captcha verification failed.']);
        exit();
    }

    // This is a dummy response. Replace with database code when the actual database is available.
    $dummyUserData = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'mobile_no' => $mobileNo,
        'reference_name' => $referenceName,
        'dial_code' => $dialCode,
        'currency_id' => $currencyId,
        'address' => $address,
        'terms_accepted' => $termsAccepted,
    ];

    // Return a success response
    echo json_encode([
        'status' => 'success',
        'message' => 'User registered successfully. This is a dummy response.',
        'data' => $dummyUserData
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
