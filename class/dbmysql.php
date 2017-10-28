<?php

include_once 'db.php';
include_once 'usuario.php';

class Myslq extends db {
  private $conn;

  public function __construct() {
    $dsn = 'mysql:host=localhost;dbname=ecommerce;charset=utf8mb4;port=3306';
    $user ="root";
    $pass = "";

    try {
      $this->conn = new PDO($dsn, $user, $pass);
    } catch (Exception $e) {
      echo "La conexion a la base de datos falló: " . $e->getMessage();
    }

  }

  public function guardarUsuario(Usuario $usuario) {
    $sql = "INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":username",$usuario->getUsername());
    $query->bindValue(":email",$usuario->getEmail());
    $query->bindValue(":password",$usuario->getPassword());

    $query->execute();

    $usuario->setId($this->conn->lastInsertId());

    return $usuario;

  }

  public function traerTodos() {
    $sql = "Select * from usuarios";

    $query = $this->conn->prepare($sql);

    $query->execute();

    $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

    $arrayFinal = [];

    foreach ($resultados as $usuario) {
      $arrayFinal[] = new Usuario($usuario["email"], $usuario["password"], $usuario["username"], $usuario["id"]);
    }

    return $arrayFinal;
  }

  public function traerPorEmail($email) {
    $sql = "Select * from usuarios where email = :email";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":email", $email);

    $query->execute();

    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
      $usuario = new Usuario($usuario["username"], $usuario["email"], $usuario["password"], $usuario["id"]);
    }

    return $usuario;

  }

  public function updatePassword($password){
    $sql = "UPDATE usuarios SET password = :password WHERE email = :email";

    $query = $this->conn->prepare($sql);

    $query->bindValue(':password', password_hash($password['password'], PASSWORD_DEFAULT));
    $query->bindValue(':email', $password['email']);
    $query->execute();

  }

}

?>
