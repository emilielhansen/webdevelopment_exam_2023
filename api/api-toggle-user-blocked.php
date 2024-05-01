<?php

// Include the master file
require_once __DIR__.'/../_.php';

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Get user_id and is_blocked from the GET parameters
    $user_id = $_GET['user_id'];
    $user_is_blocked = $_GET['is_blocked'];
    // Determine the new value for user_is_blocked based on the current value
    $check_if_blocked = $user_is_blocked == 0 ? 1 : 0;

    // Establish a database connection
    $db = _db();

    // Prepare the SQL statement for updating user_is_blocked
    $q = $db->prepare("
        UPDATE users 
        SET user_is_blocked = :user_is_blocked 
        WHERE user_id = :user_id; 
    ");
    // Bind values to parameters in the prepared statement
    $q->bindValue(':user_id', $user_id);
    $q->bindValue(':user_is_blocked', $check_if_blocked);
    // Execute the prepared statement
    $q->execute();

    // Return a JSON response indicating success
    echo json_encode(['info'=>'user updated']);

} catch(Exception $e){
    // Handle exceptions, set appropriate HTTP status code, and return error message as JSON
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
}
?>