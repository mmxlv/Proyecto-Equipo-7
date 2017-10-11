<?php

$dsn = 'mysql:host=localhost;dbname=register;charset=utf8mb4;port=3306';
$db_user = 'root';
$db_pass = '';

//password hashing
$passhash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$username = $_POST['username'];
$email = $_POST['email'];

try {
  $db = new PDO($dsn, $db_user, $db_pass);
  $query = $db->prepare('INSERT INTO register (nombre, password, email) VALUES (:username, :password, :email)');
  $query->beginTransaction();
  $query->bindValue(':username', $username);
  $query->bindValue(':password', $passhash);
  $query->bindValue(':email', $email);
  $query->exec();
  $query->commit();
} catch (PDOException $e) {
    $query->rollBack();
    echo $e->getMessage();
}

$db = NULL;
?>
