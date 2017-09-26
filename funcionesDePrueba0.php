<?php
// Persistencia de datos
$userNombre = '';
$userMail = '';
$userEdad = '';


if (isset($_POST['boton'])) {
  $arrayDeErrores = validarInformacion($_POST);
}
// reedireccionar si el formulario no tiene errores
// if ($_POST) {
//   if (count($arrayDeErrores) == 0) {
//     header("location:bienvenido.php");
//   }
// }
?>
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
/* empieza aca lo de json */
$arrayDeErrores = [];
if (count($arrayDeErrores) == 0) {
  $usuario = armarUsuario($_POST);

  guardarUsuario($usuario);
}
function armarUsuario($data) {
  return [
    "name" => $data["name"],
    "edad" => $data["edad"],
    "email" => $data["email"],
    "password" => password_hash($data["password"], PASSWORD_DEFAULT),
  ];
}

function guardarUsuario($usuario) {
  $usuarioJSON = json_encode($usuario);
  file_put_contents("nuevousuario.json", $usuarioJSON . PHP_EOL, FILE_APPEND);


}
function traerUsuarios() {
  $archivo = file_get_contents("nuevousuario.json");
  $array = explode(PHP_EOL, $archivo);
  array_pop($array);

  $arrayFinal = [];
  foreach ($array as $usuario) {
    $arrayFinal[] = json_decode($usuario, true);
  }

  return $arrayFinal;
}
function traerPorEmail($email) {
  $todos = traerUsuarios();

  foreach ($todos as $usuario) {
    if ($usuario["email"] == $email) {
      return $usuario;
    }
  }

  return NULL;
}
  ?>
