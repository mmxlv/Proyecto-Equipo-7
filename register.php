<?php
include_once 'soporte.php';
$arrayErrores = [];
$userName = '';
$userEmail = '';

// Validacion de datos
if ($_POST) {

  $userName = $_POST['username'];
  $userEmail = $_POST['email'];
  $arrayErrores = $validator->validarInformacion($_POST, $db);
  if (count($arrayErrores) == 0) {
    $usuario = new Usuario($_POST['username'], $_POST['email'], $_POST['password']);
    $usuario = $db->guardarUsuario($usuario);
    header("Location:index.php");
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
            <input  class="username" type="text" name="username" value="<?=$userName?>"><br>
            <label for="email">Email</label><br>
            <input class="email" type="email" name="email" value="<?=$userEmail?>"><br>
            <label for="register-pass">Contraseña:</label><br>
            <input class="register-pass" type="password" name="password" value=""><br>
            <label for="cpassword">Repetir contraseña:</label><br>
            <input class="cpassword" type="password" name="cpassword" value=""><br>
            <label for="">Foto de Perfil</label><br>
            <input class="imgprofile" type="file" name="imgprofile" value=""><br>
            <input class="submit-register" type="submit" name="" value="Register">
          </form>
        </div>
      </section>
<?php include_once 'footer.php'; ?>
