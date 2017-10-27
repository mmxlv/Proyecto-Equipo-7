<?php

include_once("db.php");
include_once("usuario.php");

class dbJSON extends db {
  public function traerTodos() {
    $archivo = file_get_contents("usuarios.json");
    $array = explode(PHP_EOL, $archivo);
    array_pop($array);
    $arrayFinal = [];
    foreach ($array as $usuario) {
      $arrayFinal[] = json_decode($usuario, true);
    }
    return $arrayFinal;
  }
  public function traerPorEmail($email) {
    $todos = traerTodos();
    foreach ($todos as $usuario) {
      if ($usuario["email"] == $email) {
        return $usuario;
      }
    }
    return NULL;
  }
  public function guardarUsuario($usuario) {
    $usuarioJSON = json_encode($usuario);
    file_put_contents("usuarios.json", $usuarioJSON . PHP_EOL, FILE_APPEND);
  }
}

?>
