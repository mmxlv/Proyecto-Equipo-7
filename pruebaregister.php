<?php
 require_once ("funcionesDePrueba.php"); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>formulario de prueba</title>
  </head>
  <body>
<?php if (isset($_POST['boton'])): ?>
  <?php if (count($arrayDeErrores) > 0) : ?>
      <ul style="color:red">
        <?php foreach ($arrayDeErrores as $error) :?>
          <li>
            <?=$error?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
<?php endif; ?>

    <form class="formulario" action="pruebaregister.php" method="post" enctype="multipart/form-data">
      <label for="name">Escriba su nombre:</label> <input type="text" name="name" value="<?=$userNombre?>" placeholder="Escriba su nombre"> <br> <br>
      <label for="edad">Escriba su edad: </label><input type="text" name="edad" value="<?=$userEdad?>" placeholder="Escriba su edad"> <br> <br>
      <label for="email">Escriba su email:</label><input type="email" name="email" value="<?=$userMail?>" placeholder="Escriba su e-mail"> <br> <br>
      <label for="contraseña">Escriba su contraseña:</label><input type="password" name="password" value="" placeholder="Escriba su contraseña"><br> <br>
      <label for="cpassword">Rescriba su contraseña:</label><input type="password" name="cpassword" value="" placeholder="Reescriba su contraseña"><br> <br>
      <label for="perfil">Foto de Perfil:</label><input type="file" name="perfil"><br><br><br>

      <button type="submit" value="boton" name="button">Registrarse</button>
    </form>
  </body>
</html>
