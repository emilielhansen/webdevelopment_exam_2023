<?php

ini_set('display_errors', 1);

/**
 * @return PDO Returns a PDO object representing a connection to the database.
 * @throws Exception Throws an exception if the connection to the database fails.
 **/

// Connect to database
function _db() {
  try {
      $user_name = "root"; // Database username
      $user_password = ""; // Database password
      $db_connection = 'sqlite:' . __DIR__ . '/database/company.db'; // SQLite connection string

      // PDO options configuration
      $db_options = array(
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Error mode set to Exception
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch mode set to associative array
      );

      // Establishing the PDO connection
      return new PDO($db_connection, $user_name, $user_password, $db_options);

  } catch (PDOException $e) {
      // Handling exceptions and throwing a generic exception
      throw new Exception('ups... system under maintenance', 500);
      exit();
  }
}

// VALIDATE FIRST NAME LENGTH AND IS SET
define('USER_NAME_MIN', 2);
define('USER_NAME_MAX', 20);
function _validate_user_name(){

  $error = 'user_name min '.USER_NAME_MIN.' max '.USER_NAME_MAX;

  if(!isset($_POST['user_name'])){ 
    throw new Exception($error, 400); 
  }

  $_POST['user_name'] = trim($_POST['user_name']);

  if( strlen($_POST['user_name']) < USER_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_name']) > USER_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// VALIDATE LAST NAME LENGTH AND IS SET
define('USER_LAST_NAME_MIN', 2);
define('USER_LAST_NAME_MAX', 20);
function _validate_user_last_name(){

  $error = 'user_last_name min '.USER_LAST_NAME_MIN.' max '.USER_LAST_NAME_MAX;

  if(!isset($_POST['user_last_name'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_last_name'] = trim($_POST['user_last_name']);

  if( strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX ){
    throw new Exception($error, 400);
  }
}

// VALIDATE ADRESS IS SET AND IS CORRECT LENGTH
define('USER_ADRESS_MIN', 2);
define('USER_ADRESS_MAX', 60);
function _validate_user_adress(){

  $error = 'user_adress '.USER_ADRESS_MIN.' max '.USER_ADRESS_MAX;

  if(!isset($_POST['user_adress'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_adress'] = trim($_POST['user_adress']);

  if( strlen($_POST['user_adress']) < USER_ADRESS_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_adress']) > USER_ADRESS_MAX ){
    throw new Exception($error, 400);
  }
}

// VALIDATE EMAIL IS SET
function _validate_user_email(){
  $error = 'user_email invalid';
  if(!isset($_POST['user_email'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_email'] = trim($_POST['user_email']); 
  if( ! filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) ){
    throw new Exception($error, 400); 
  }
}

// VALIDATE PASSWORD LENGTH AND IS SET
define('USER_PASSWORD_MIN', 6);
define('USER_PASSWORD_MAX', 50);
function _validate_user_password(){

  $error = 'user_password min '.USER_PASSWORD_MIN.' max '.USER_PASSWORD_MAX;

  if(!isset($_POST['user_password'])){ 
    throw new Exception($error, 400); 
  }
  $_POST['user_password'] = trim($_POST['user_password']);

  if( strlen($_POST['user_password']) < USER_PASSWORD_MIN ){
    throw new Exception($error, 400);
  }

  if( strlen($_POST['user_password']) > USER_PASSWORD_MAX ){
    throw new Exception($error, 400);
  }
}