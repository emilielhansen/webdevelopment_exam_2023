<?php

// Include master file
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Connect to the database
    $db = _db();

    // Check if the search term is not empty
    if (!empty($_POST['query'])) {
        // Prepare the SQL query to retrieve partner users based on name and last name
        $q = $db->prepare('
            SELECT user_id, user_name, user_last_name, user_email, user_is_blocked
            FROM users
            WHERE user_role_name = "partner"
            AND (user_name LIKE :user_name COLLATE NOCASE OR user_last_name LIKE :user_last_name COLLATE NOCASE)
        ');

        // Bind the values to the parameters in the query
        $q->bindValue(':user_name', "%{$_POST['query']}%");
        $q->bindValue(':user_last_name', "%{$_POST['query']}%");

        // Execute the query
        $q->execute();

        // Fetch all rows from the result set
        $employees = $q->fetchAll();

        // Return the result as JSON
        echo json_encode($employees);
    } else {
        // If the search term is empty, return an empty JSON array
        echo json_encode([]);
    }

} catch(Exception $e) {
    // Handle exceptions, set appropriate HTTP status code, and return error message as JSON
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - '.$e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
?>