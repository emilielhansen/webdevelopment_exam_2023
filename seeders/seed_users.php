<?php
require_once __DIR__.'/../_.php';
require_once __DIR__ . '/Faker/autoload.php';
$faker = Faker\Factory::create();

try{

  $db = _db();
  $q = $db->prepare('DROP TABLE IF EXISTS users');
  $q->execute();

  // Get roles to assign to users
  $q = $db->prepare('SELECT role_name FROM roles');
  $q->execute();
  $roles = $q->fetchAll(PDO::FETCH_COLUMN); // ["admin","partner","customer"]

  $q = $db->prepare('
    CREATE TABLE users(
      user_id           TEXT,
      user_name         TEXT,
      user_last_name    TEXT,
      user_email        TEXT UNIQUE,
      user_password     TEXT,
      user_address      TEXT,
      user_role_name    TEXT,
      user_tag_color    TEXT,
      user_created_at   TEXT,
      user_updated_at   TEXT,
      user_deleted_at   TEXT,
      user_is_blocked   BOOLEAN,
      PRIMARY KEY (user_id)
    )
  ');
  $q->execute();

  $values = '';
  // Admin roles

  $admin_password = password_hash('password', PASSWORD_DEFAULT);
  $admin_created_at = time();
  $admin_updated_at = 0;
  $admin_deleted_at = 0;  
  $values .= "('64474be79ad54b2b8f62164d97ff7ef1', 'Admin', 'Admin', 'admin@company.com', 
  '$admin_password', 'Admin address', 'admin', '#0ea5e9', $admin_created_at, $admin_updated_at, $admin_deleted_at),";


  $user_password = password_hash('password', PASSWORD_DEFAULT); // too long time in loop
  for($i = 0; $i < 100; $i++){
    $user_id = bin2hex(random_bytes(16));
    $user_name = str_replace("'", "''", $faker->firstName);
    $user_last_name = str_replace("'", "''", $faker->lastName);
    $user_email = $faker->unique->email;
    $user_address = str_replace("'", "''", $faker->address);
    $user_role_name = $roles[array_rand($roles)];
    $user_tag_color = $faker->hexcolor;
    $user_created_at = time();
    $user_updated_at = 0;
    $user_deleted_at = 0;
    $values .= "('$user_id', '$user_name', '$user_last_name', '$user_email', '$user_password', 
    '$user_address', '$user_role_name', '$user_tag_color', $user_created_at, $user_updated_at, $user_deleted_at),";
  }
  $values = rtrim($values, ',');  
  $q = $db->prepare("INSERT INTO users VALUES $values");
  $q->execute();

  echo "+ users".PHP_EOL;
}catch(Exception $e){
  echo $e;
}









