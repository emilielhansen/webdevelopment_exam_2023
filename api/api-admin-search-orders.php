<?php

// Import master file
require_once __DIR__.'/../_.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Connect to the database
    $db = _db();

    // Prepare and execute the SELECT query with a parameterized search
    $query = "%{$_POST['query']}%";
    $q = $db->prepare('
        SELECT order_id, order_created_by_user_fk, order_created_at 
        FROM orders
        WHERE 
            order_id LIKE :query 
            OR order_created_by_user_fk LIKE :query 
            OR order_created_at LIKE :query
    ');
    $q->bindValue(':query', $query, PDO::PARAM_STR);
    $q->execute();

    // Fetch and encode the results as JSON
    $orders = $q->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($orders);

} catch (PDOException $e) {
    // Handle database errors, log them, or send an appropriate response
    echo json_encode(['error' => 'Database error']);
}

?>
