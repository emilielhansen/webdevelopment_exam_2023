<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Unset all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    exit();
    
} else {
    // Provide a message if the user was not logged in
    echo "You were not logged in.";
}
?>