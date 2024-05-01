<?php

// Include the master file
require_once __DIR__.'/../_.php';

try {
    // Start the session to access user information
    session_start();
    
    // Get the user_id from the session
    $user_id = $_SESSION['user']['user_id'];
    
    // Establish a database connection
    $db = _db();

    // Update user_updated_at timestamp
    $q_update_time = $db->prepare('
        UPDATE users
        SET user_updated_at = :time
        WHERE user_id = :user_id
    ');

    // Bind values to parameters in the prepared statement
    $q_update_time->bindValue(':time', time());  
    $q_update_time->bindValue(':user_id', $user_id);
    // Execute the prepared statement
    $q_update_time->execute();

    // Update user_email and user_name
    $q_update_profile = $db->prepare('
        UPDATE users
        SET user_email = :user_email,
            user_name = :user_name
        WHERE user_id = :user_id
    ');

    // Bind values to parameters in the prepared statement
    $q_update_profile->bindValue(':user_email', $_POST['user_email']);
    $q_update_profile->bindValue(':user_name', $_POST['user_name']);
    $q_update_profile->bindValue(':user_id', $user_id);
    // Execute the prepared statement
    $q_update_profile->execute();

} catch (Exception $e) {
    // Handle exceptions, set appropriate HTTP status code, and return error message as JSON
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info'=>$message]);
}
?>