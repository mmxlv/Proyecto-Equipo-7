<?php
require_once 'header.php';

$listErrores = [];
//Actualiza la pass en json
if (isset($_POST['npassword'])) {
  $listErrores = validatePassword($_POST);
  if (count($listErrores) == 0) {
    updatePassword($_POST);
    ?>
      <div style="text-align:center;margin: 10px 0 10px 0">
        <p>Exito al actualizar la contraseña!</p>
        <a href="index.php">Volver</a>
      </div>
<?php
  }else {
    echo "Algo salio mal al actualizar la contraseña!";
  }
}
//valida los datos y si son correctos carga el form para cambiar la password
if (isset($_POST['valid'])) {
  $listErrores = validarDatos($_POST);
  if (count($listErrores) > 0) : ?>
        <div class="refon">
          <p>Datos Invalidos!</p>
        </div>
<?php else : ?>
        <div class="refon">
          <form class="" action="login.php" method="post">
            <label for="">Ingrese contraseña nueva:</label><br>
            <input type="password" name="npassword" value=""><br>
            <label for="">Repetir contraseña</label><br>
            <input type="password" name="cpassword" value=""><br>
            <input type="submit" name="" value="Cambiar contraseña">
          </form>
        </div>
<?php
  endif;
}
//carga el form para validar al usuario
if (isset($_GET['ref'])) { ?>

    <div class="refon">
      <form class="" action="login.php" method="post">
        <label for="">Email:</label><br>
        <input type="email" name="email" value=""><br>
        <label for="">Nombre de Usuario:</label><br>
        <input type="text" name="username" value=""><br>
        <input type="submit" name="valid" value="Siguiente">
      </form>
    </div>

<?php
}
//Persistencia de datos
$emailDefault= "";
$passwordDefault = "";
$checkboxDefault = "";
$listadoErrores = [];

if (isset($_POST['Login'])){

$listadoErrores=loginUserMysql($_POST);
// modo json
// $listadoErrores=validarLogin($_POST);
// este if posiblemente no sirve ya que la funcion de mysql se encarga de setear casi todo respecto a la sesion
  if(count($listadoErrores)==0){
    loguear($_POST["email"]);

    if (isset($_POST["remember"])){
      recordarUsuario($_POST["email"]);
    }
    if (estaLogueado() == true) {
    header('location:index.php');
    }
    // exit; sobra(?)
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

if (isset($listadoErrores) && count($listadoErrores) > 0) : ?>
  <ul style="color:red">
<?php foreach($listadoErrores as $error) : ?>
      <li><?=$error?></li><br>
<?php endforeach; ?>
  </ul>
<?php endif;
if (empty($_GET) && empty($_POST)): ?>
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
        <input type="submit" name="Login" value="Login">
      </form>
    </div>
  </section>
<?php
endif;
include_once ("footer.php");
?>
