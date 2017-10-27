<?php
include_once 'soporte.php';

$emailDefault = "";
$passwordDefault = "";
if ($auth->estaLogueado() == true) {
  header('location:index.php');
}

$listadoErrores = [];

if ($_POST){

$listadoErrores = $validator->validarLogin($_POST, $db);

  if(count($listadoErrores)==0){
    $auth->loguear($_POST["email"]);

    if (isset($_POST["remember"])){
      $auth->recordarUsuario($_POST["email"]);
    }
    header("Location:index.php");
    exit;
  }
  // PERSISTENCIA DE DATOS

  if (isset($_POST["email"])){
    $emailDefault = $_POST["email"];
  }

  if (isset($_POST["password"])){
    $passwordDefault = $_POST["password"];
  }
  if (isset($_POST["remember"])){
    $checkboxDefault = $_POST["remember"];
  }

}
require_once 'header.php';

if (isset($listadoErrores) && count($listadoErrores) > 0) : ?>
  <ul style="color:red">
<?php foreach($listadoErrores as $error) : ?>
      <li><?=$error?></li><br>
<?php endforeach; ?>
  </ul>
<?php endif; ?>
  <section>
    <div class="login-form-div">
      <form class="login-form" action="login.php" method="post">
        <label for="email">Email</label><br>
        <input id="email" type="email" name="email" value="<?=$emailDefault?>"><br>
        <label for="login-pass">Contraseña</label><br>
        <input id="login-pass" type="password" name="password" value="<?=$passwordDefault?>"><br>
        <a href="login.php?ref=1">¿Olvido su contraseña?</a><br>
        <input id="remember-box" type="checkbox" name="remember" value="<?=$checkboxDefault?>">
        <label for="remember-box">Recordarme</label><br>
        <input id="submit-loggin" type="submit" name="Login" value="Login">
      </form>
    </div>
  </section>
<?php include_once ("footer.php"); ?>
