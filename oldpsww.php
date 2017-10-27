<?php
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
