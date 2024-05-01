<?php

// Import master file
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Validate user email format
    _validate_user_email();

    // Get user email from the POST data
    $user_email = $_POST['user_email'];

    // Connect to the database
    $db = _db();

    // Prepare and execute the SELECT query to check if the email is available
    $sqlite = $db->prepare('
        SELECT user_email 
        FROM users 
        WHERE user_email = :user_email'
    );
    $sqlite->bindValue(':user_email', $user_email);
    $sqlite->execute();
    $email = $sqlite->fetch();

    // Check if the email is available
    if (!$email) {
        echo json_encode(['info' => 'email available']);
        exit();
    }

    // If email is not available, return a 400 status code
    http_response_code(400);
    echo json_encode(['info' => 'email is not available']);

} catch (Exception $e) {
    // Handle exceptions, log them, or send an appropriate response
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}

?>