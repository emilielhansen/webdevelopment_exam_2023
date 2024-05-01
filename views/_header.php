<!-- HEADER TEMPLATE -->

<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $userRole = $_SESSION['user']['user_role_name'];
} else {
    $userRole = 'guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app.css">
    <title>Food Delivery App</title>
</head>
<body>

<div class="navbar flex items-center justify-between p-4 bg-neutral-900">
        <div class="logo text-white text-2xl font-bold">Food Delivery App</div>
        
        <div class="flex gap-4">
        <?php

            // Display links based on user role
            if ($userRole == 'admin') {
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/profile.php">My Profile</a>';
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/partner.php">Partners</a>';
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/user.php">Customers</a>';
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/admin_orders.php">Orders</a>';
            }

            if ($userRole == 'partner') {
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/profile.php">My Profile</a>';
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/orders.php">Orders</a>';
            }

            if ($userRole == 'customer') {
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/profile.php">My Profile</a>';
                echo '<a class="text-white px-8 py-2 mr-2" href="/views/orders.php">Orders</a>';
            }

            //Display only logout when user is not a guest/not logged in
            if ($userRole == 'guest') {
                echo '<a class="text-white px-8 py-2 mr-2 font-bold" href="/views/login.php">Login</a>';
            } else {
                echo '<button class="text-white px-8 py-2 mr-2 font-bold" onclick="logout_users()">Logout</button>';
            }
        ?>
    </div>
</div>

<?php
// Display role-specific content
switch ($userRole) {
    case 'admin':
        echo '<p class="px-4 text-4xl text-center font-bold mt-8">Admin page</p>';
        break;
    case 'customer':
        echo '<p class="px-4 text-4xl text-center font-bold mt-8">Customer page</p>';
        break;
    case 'partner':
        echo '<p class="px-4 text-4xl text-center font-bold mt-8">Partner page</p>';
        break;
}
?>


