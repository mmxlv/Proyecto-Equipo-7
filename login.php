<?php
include_once 'soporte.php';

$emailDefault = "";
$passwordDefault = "";
if ($auth->estaLogueado() == true) {
  header('location:index.php');
}

$listadoErrores = [];

if (isset($_POST['Login'])){

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

  // if (isset($_POST["password"])){
  //   $passwordDefault = $_POST["password"];
  // }
  if (isset($_POST["remember"])){
    $checkboxDefault = $_POST["remember"];
  }

}
if (isset($_POST['preset'])) {
  $validar = $validator->validarNewPassword($_POST, $db);
  $_SESSION['email'] = $_POST['email'];
  if (count($validar)==0) {
    $_POST['next'] = '1';
  }else {
    var_dump($validar);
  }
}
if (isset($_POST['npassword'])) {
  $validar = $validator->checkNewPassword($_POST);
  if (count($validar)==0) {
    $_POST['email'] = $_SESSION['email'];
    $db->updatePassword($_POST);
  }else {
    var_dump($validar);
  }
}


require_once 'header.php'; ?>

<?php if (isset($_POST['next'])): ?>
  <div class="login-form-div">
    <form class="" action="login.php" method="post">
      <label for="">Contraseña:</label><br>
      <input type="password" name="password" value=""><br>
      <label for="">Repetir Contraseña:</label><br>
      <input type="password" name="cpassword" value=""><br>
      <input type="submit" name="npassword" value="Enviar">
    </form>
  </div>
<?php endif; ?>

<?php if (isset($_GET['ref'])): ?>
  <div class="login-form-div">
    <form class="" action="login.php" method="post">
      <label for="">Nombre:</label><br>
      <input type="text" name="username" value=""><br>
      <label for="">Email:</label><br>
      <input type="text" name="email" value=""><br>
      <input type="submit" name="preset" value="Siguiente">
    </form>
  </div>
<?php endif; ?>

<?php if (empty($_GET) && empty($_POST)): ?>
<?php if (isset($listadoErrores) && count($listadoErrores) > 0) : ?>
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
<?php endif; ?>
<?php include_once ("footer.php"); ?>
