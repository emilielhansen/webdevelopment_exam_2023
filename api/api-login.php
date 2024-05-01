<?php
// Include master file
require_once __DIR__.'/../_.php';

try {
    // Validate user email and password
    _validate_user_email();
    _validate_user_password();

    // Connect to the database
    $db = _db();

    // Prepare and execute SQL query to retrieve user by email
    $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->execute();
    
    // Fetch the user from the database
    $user = $q->fetch();
    
    // Check if user exists
    if (!$user) {
        throw new Exception('User does not exist', 400);
    }

    // Check if user account is deleted
    if ($user['user_deleted_at'] > 0) {
        throw new Exception('User account is deleted', 400);
    }
    
    // Check if the found user has a valid password
    if (!password_verify($_POST['user_password'], $user['user_password'])) {
        throw new Exception('Email and password dont match', 400);
    }
    
    // Start a new session and store user information
    session_start();
    unset($user['user_password']);
    $_SESSION['user'] = $user;
    
    // Return the user information as JSON
    echo json_encode($_SESSION['user']);
} catch (Exception $e) {
    // Handle exceptions, set appropriate HTTP response code, and return error information as JSON
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
?>
    