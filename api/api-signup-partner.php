<?php

// Include master file
require_once __DIR__.'/../_.php';

try {
    // Validation of signup, from validator.js
    _validate_user_name();
    _validate_user_last_name();
    _validate_user_email();
    _validate_user_password();

    //Make DB connection
    $db = _db();

    // Prepare the query
    $q = $db->prepare('
        INSERT INTO users 
        VALUES (
            :user_id, :user_name, :user_last_name, 
            :user_email, :user_password, :user_address, :user_role, :user_tag_color,
            :user_created_at, :user_updated_at, :user_deleted_at, :user_is_blocked)'
    );

    // Set default values
    $user_updated_at = 0;
    $user_deleted_at = 0;
    $user_is_blocked = 0;
    $user_tag_color = "#0ea5e9";

    // Set user role and creation timestamp
    $user_role = 'partner';
    $user_created_at = time();

    // Bind values to parameters in the prepared statement
    $q->bindValue(':user_id', bin2hex(random_bytes(16)));
    $q->bindValue(':user_name', $_POST['user_name']);
    $q->bindValue(':user_last_name', $_POST['user_last_name']);
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->bindValue(':user_password', password_hash($_POST['user_password'], PASSWORD_DEFAULT));
    $q->bindParam(':user_address', $_POST['user_address']);
    $q->bindParam(':user_role', $user_role);
    $q->bindParam(':user_tag_color', $user_tag_color);
    $q->bindParam(':user_created_at', $user_created_at);
    $q->bindParam(':user_updated_at', $user_updated_at);
    $q->bindParam(':user_deleted_at', $user_deleted_at);
    $q->bindParam(':user_is_blocked', $user_is_blocked);                   

    // Execute the prepared statement
    $q->execute();
    $counter = $q->rowCount();

    // Check if the row was successfully inserted
    if ($counter != 1) {
        throw new Exception('Error occurred during user insertion.', 500);
    }

} catch (Exception $e) {
    // Handle exceptions, set appropriate HTTP status code, and return error message as JSON
    $status_code = !ctype_digit($e->getCode()) ? 400 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
?>