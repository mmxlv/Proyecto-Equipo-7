<?php
require_once 'header.php';
$listErrores = [];

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
    require_once 'footer.php';
    exit;
  }else {
    echo "Algo salio mal al actualizar la contraseña!";
    require_once 'footer.php';
    exit;
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
  require_once 'footer.php';
  exit;
}
//carga el form para validar al usuario
if (isset($_GET['ref'])) { ?>

    <div class="refon">
      <form class="" action="login.php" method="post">
        <label for="">Email:</label><br>
        <input type="email" name="email" value=""><br>
        <label for="">Edad:</label><br>
        <input type="text" name="edad" value=""><br>
        <input type="submit" name="valid" value="Siguiente">
      </form>
    </div>

<?php
require_once 'footer.php';
exit;
} ?>
      <section>
        <div class="login-form-div">
          <form class="login-form" action="" method="post">
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value=""><br>
            <label for="login-pass">Contraseña</label><br>
            <input id="login-pass" type="password" name="login-pass" value=""><br>
            <a href="login.php?ref=1">¿Olvido su contraseña?</a><br>
            <input id="remember-box" type="checkbox" name="remember" value="">
            <label for="remember-box">Recordarme</label><br>
            <input type="submit" name="Login" value="Login">
          </form>
        </div>
      </section>
<?php include_once ("footer.php") ?>
