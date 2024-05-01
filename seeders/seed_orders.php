<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  // Get users whos role is "customer" to assign to orders
  $user_role_name = 'customer';
  $db = _db();
  $q = $db->prepare("SELECT user_id FROM users WHERE user_role_name == '$user_role_name'");
  $q->execute();
  $users_ids = $q->fetchAll(PDO::FETCH_COLUMN);

  // Get employees assign to orders
  $user_role_name = 'employee';
  $q = $db->prepare("SELECT user_id FROM users WHERE user_role_name == '$user_role_name'");
  $q->execute();
  $employees_ids = $q->fetchAll(PDO::FETCH_COLUMN);

  // Get items_ids to assign to order
  $q = $db->prepare("SELECT item_id FROM items");
  $q->execute();
  $items_ids = $q->fetchAll(PDO::FETCH_COLUMN);

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS orders');
  $q->execute();

  $q = $db->prepare('
    CREATE TABLE orders(
      order_id                      TEXT,
      order_created_by_user_fk      TEXT,
      order_created_at              TEXT,
      order_updated_at              TEXT,
      order_deleted_at              TEXT,
      order_delivered_at            TEXT,
      order_delivered_by_user_fk    TEXT,
      PRIMARY KEY (order_id)
    )
  ');
  $q->execute();
  
  $values = '';
  for($i = 0; $i < 100; $i++){
    $order_id = bin2hex(random_bytes(16));
    $order_created_by_user_fk = $users_ids[array_rand($users_ids)];
    $order_created_at = time();
    $order_updated_at = 0;
    $order_deleted_at = 0;
    $order_delivered_at = 0;
    $order_delivered_by_user_fk = $employees_ids[array_rand($employees_ids)];

    $values .= "('$order_id', '$order_created_by_user_fk', '$order_created_at', '$order_updated_at', 
    '$order_deleted_at', '$order_delivered_at', '$order_delivered_by_user_fk'),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO orders VALUES $values");
  $q->execute();

  echo "+ orders".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









