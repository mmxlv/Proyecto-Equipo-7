<?php
$arrayErrores = [];
require_once('funciones.php');

// Validacion de datos
if ($_POST) {

  $arrayErrores = validarInformacion($_POST);
  if (count($arrayErrores) == 0) {
    require_once('dbregister.php');
    //header('location:dbregister.php');
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
          <form class="register-form" action="register.php" method="post">
            <label for="username">Nombre</label><br>
            <input  id="username" type="text" name="username" value=""><br>
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value=""><br>
            <label for="register-pass">Contraseña</label><br>
            <input id="register-pass" type="password" name="password" value=""><br>
            <input type="submit" name="" value="Register">
          </form>
        </div>
      </section>
<?php include_once ("footer.php") ?>
