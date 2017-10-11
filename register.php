<?php
$arrayErrores = [];
$userName = '';
$userEmail = '';
$mode = 'mysql';
require_once('funciones.php');

// Validacion de datos
if ($_POST) {

  $userName = $_POST['username'];
  $userEmail = $_POST['email'];
  $arrayErrores = validarInformacion($_POST);
  if (count($arrayErrores) == 0) {
    if ($mode == 'mysql') {
      var_dump($_POST);
      crearUsuarioMysql($_POST);
    }
    elseif ($mode == 'json') {
      $nuevoUser = crearUsuario($_POST);
      guardarUsuario($nuevoUser);
    }
    header('location:index.php');
    exit;
  }
}

include_once ("header.php");

if (count($arrayErrores) > 0) : ?>
  <ul style="color:red">
    <?php foreach($arrayErrores as $error) : ?>
      <li><?=$error?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

      <section>
        <div class="register-form-div">
          <form class="register-form" action="register.php" method="post" enctype="multipart/form-data">
            <label for="username">Nombre</label><br>
            <input  id="username" type="text" name="username" value="<?=$userName?>"><br>
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value="<?=$userEmail?>"><br>
            <label for="register-pass">Contraseña:</label><br>
            <input id="register-pass" type="password" name="password" value=""><br>
            <label for="cpassword">Repetir contraseña:</label><br>
            <input id="cpassword" type="password" name="cpassword" value=""><br>
            <label for="">Foto de Perfil</label><br>
            <input type="file" name="imgprofile" value=""><br>
            <input type="submit" name="" value="Register">
          </form>
        </div>
      </section>
<?php include_once ("footer.php") ?>
