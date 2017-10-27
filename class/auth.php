<?php

include_once 'db.php';

class Auth {

  function __construct()
  {
    session_start();

    if (!$this->estaLogueado() && isset($_COOKIE["usuarioLogueado"])) {
      $this->loguear($_COOKIE["usuarioLogueado"]);
    }
  }

  public function loguear($email) {
    $_SESSION["usuarioLogueado"] = $email;
  }

  public function estaLogueado() {
    if (isset($_SESSION["usuarioLogueado"])) {
      return true;
    }
    else {
      return false;
    }
  }

  function usuarioLogueado(db $db) {
    if ($this->estaLogueado()) {
      return $db->traerPorEmail($_SESSION["usuarioLogueado"]);
    }
    else {
      return NULL;
    }
  }

  public function recordarUsuario($email) {
    setcookie("usuarioLogueado", $email, time() + 60*60*24*7);
  }

  public function logout() {
    session_destroy();
    setcookie("usuarioLogueado", "", -1);
  }
}

?>
