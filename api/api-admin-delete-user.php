<?php

// Import master file
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Retrieve user_id from POST data
    $user_id = $_POST['user_id'];

    // Connect to the database
    $db = _db();

    // Prepare and execute the DELETE query
    $sql = $db->prepare('DELETE FROM users WHERE user_id = :user_id');
    $sql->bindValue(':user_id', $user_id);
    $sql->execute();

    // Provide a success message in JSON format
    echo json_encode(['info' => "User with ID: $user_id deleted"]);

} catch (Exception $e) {
    // Handle errors and respond with an appropriate JSON message
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'Error - '.$e->getLine() : $e->getMessage();
    
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}

?>