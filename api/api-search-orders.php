<?php

// Import master file
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Connect to the database
    $db = _db();

    // Check if the search term is not empty
    if (!empty($_POST['query'])) {
        // Prepare the SQL query to retrieve order information
        $query = $_POST['query'];
        $q = $db->prepare('
            SELECT order_id, order_created_by_user_fk, order_created_at 
            FROM orders
            WHERE 
                order_id = :query
        ');

        // Bind the value to the parameter in the query
        $q->bindValue(':query', $query, PDO::PARAM_STR);

        // Execute the query
        $q->execute();

        // Fetch all rows from the result set
        $orders = $q->fetchAll(PDO::FETCH_ASSOC);

        // Return the result as JSON
        echo json_encode($orders);
    } else {
        // If the search term is empty, return an empty JSON array
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // Handle database errors, log them, or send an appropriate response
    echo json_encode(['error' => 'Database error']);
}
?>
