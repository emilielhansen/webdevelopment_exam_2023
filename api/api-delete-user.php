<?php

// Import master file
require_once __DIR__.'/../_.php';

try {
    // Start the session
    session_start();

    // Get user ID from the session
    $user_id = $_SESSION['user']['user_id'];

    // Connect to the database
    $db = _db();

    // Prepare and execute the UPDATE query to mark the user as deleted
    $q_update_time = $db->prepare('
        UPDATE users
        SET user_deleted_at = :time
        WHERE user_id = :user_id
    ');

    $q_update_time->bindValue(':time', time());
    $q_update_time->bindValue(':user_id', $user_id);
    $q_update_time->execute();

} catch (Exception $e) {
    // Handle exceptions, log them, or send an appropriate response
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}

?>