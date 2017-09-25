<?php
$userNombre = $_POST["name"];
$userMail = $_POST["email"];
$userEdad = $_POST["edad"];
$userContraseña = $_POST["password"];
$userCContraseña = $_POST["cpassword"];

$arrayDeErrores = validarInformacion($_POST);
// reedireccionar si el formulario no tiene errores
if ($_POST) {
  if (count($arrayDeErrores) == 0) {
    header("location:bienvenido.php");
  }
}
?>
<?php
//pero si hay errores, queremos decirle al usuario.. cuales
  if (count($arrayDeErrores) > 0) : ?>
    <ul style="color:red">
      <?php // para cada error en el arrayDeErrores, queremos ver el error en una lista y de rojo..
        foreach ($arrayDeErrores as $error) :?>
        <li>
          <?=$error?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php // para facilitar la escritura posterior, es conveniente realizar una funcion q aglobe los errores.
    function validarInformacion($informacion) {
      $arrayErrores = [];
     foreach ($informacion as $clave => $valor) {
       $informacion[$clave] = trim($valor);
     }
     // ponemos los if que sean nencesarios para que se coloquen los errores en el arrayErrores.
     if (strlen($informacion["name"]) < 3 || strlen($informacion["name"]) > 20) {
       $arrayErrores["name"] = "El username debe tener entre 3 y 20 letras";
     }
     if (strlen($informacion["email"]) == 0) {
       $arrayErrores["email"] = "Debes poner tu email";
     }
     //usamos filter_var para filtrar de q lo q pongan en el input email sea realmente un mail.
     elseif (filter_var($informacion["email"], FILTER_VALIDATE_EMAIL) == false) {
       $arrayErrores["email"] = "Colocaste un texto que no corresponde al formato email";
     }
     // queremos corroborar que el email que pongan en el register no exista...
        //parte del login
     //queremos que en el input edad, primero sea un numero y que sea mayor de edad.
     if (!is_numeric($informacion["edad"]) && $informacion["edad"] < 18) {
       $arrayErrores["edad"] = "Edad no válida";
     }
     //queremos que el password sea mayor de 5 caracteres y que, ademas, coincida con el "confirmar password".
     if (strlen($informacion["password"]) < 5 ) {
       $arrayErrores["password"] = "La contraseña debe tener un mínimo de 5 caracteres";
     }
     elseif ($informacion["password"] != $informacion["cpassword"]) {
       $arrayErrores["password"] = "La contraseña no verifica";
     }
     //ahora queremos que la foto de perfil del usuario, primero cargue bien en el servidor, y despues verificar si es realmente una foto.
     //las fotos y archivos subidos usan la variable global $_FILES, determinemos variables mas amigables.
     $errorDeLaFoto = $_FILES["perfil"]["error"];
     $nombreDeLaFoto = $_FILES["perfil"]["name"];
     $extension = pathinfo($nombreDeLaFoto, PATHINFO_EXTENSION);
     //vamos a usar una constante llamada UPLOAD_ERR_OK (http://php.net/manual/es/features.file-upload.errors.php) que indica si la foto subio sin errores..
     if ($errorDeLaFoto != UPLOAD_ERR_OK) {
       $arrayErrores["perfil"] = "Ocurrió un error al cargar la foto";
     }
     elseif ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "gif") {
       $arrayErrores["perfil"] = "Subiste algo que no es una foto";
     }

     return $arrayErrores;
    }
// queremos guardar la imagen q nos manda el usuario

function guardarImagen() {
  if ($_FILES["perfil"]["error"] == UPLOAD_ERR_OK) {
    $nombre = $_FILES["perfil"]["name"];
    $archivo = $_FILES["perfil"]["tmp_name"];

    $email = $_POST["email"];

    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    $miArchivo = dirname("_ _ FILE _ _") . "/pruebaimg/" . $email . $extension;

    move_uploaded_file($archivo, $miArchivo);
  }
}
  return guardarImagen();


  ?>
