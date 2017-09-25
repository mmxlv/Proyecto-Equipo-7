<?php

session_start();

function validarInformacion($informacion){
  $arrayDeErrores = [];
   if (filter_var($informacion['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
     $arrayDeErrores['email'] = 'Email Invalido';
   }
   if (strlen($informacion['username']) < 3 || strlen($informacion['username']) > 50) {
     $arrayDeErrores['username'] = 'Nombre de Usuario Invalido';
   }
   if (strlen($informacion['password']) < 6) {
     $arrayDeErrores['password'] = 'La contraseña tiene que tener al menos 6 caracteres';
   }
   if ($informacion['password'] != $informacion['cpassword']) {
     $arrayDeErrores['password'] = 'Las contraseñas no son iguales';
   }
   if ($_FILES['imgprofile']['error'] != UPLOAD_ERR_OK) {
     $arrayDeErrores['imgprofile'] = 'Hubo un problema al subir el archivo.';
   }
   $imgname = $_FILES['imgprofile']['name'];
   $imgext = pathinfo($imgname, PATHINFO_EXTENSION);

   if ($imgext != 'jpg' && $imgext != 'png' && $imgext != 'jpeg' && $imgext != 'gif') {
     $arrayDeErrores['imgprofile'] = 'El archivo subido no es una imagen.';
   }
   $fileExist = $informacion['email'].".$imgext";

   if(file_exists("./uimg/$fileExist")){
     $arrayDeErrores['imgprofile'] = 'El archivo ya existe';
   }
   if ($_FILES['imgprofile']['error'] == UPLOAD_ERR_OK) {
     $tmpfile = $_FILES['imgprofile']['tmp_name'];
     $saveloc = dirname(__FILE__) . '/uimg/' . $informacion['email'] . ".$imgext";
     move_uploaded_file($tmpfile,$saveloc);
   }
  return $arrayDeErrores;
}
function crearUsuario($data){
  return [
          "name" => $data['name'],
          "username" => $data["username"],
          "edad" => $data["edad"],
          "email" => $data["email"],
          "password" => password_hash($data["password"], PASSWORD_DEFAULT),
          "pais" => $data["pais"]
            ];
}
function guardarUsuario($usuario) {
  $usuarioJSON = json_encode($usuario);
  file_put_contents("usuarios.json", $usuarioJSON . PHP_EOL, FILE_APPEND);
}
function traerTodos() {
  $archivo = file_get_contents("usuarios.json");
  $array = explode(PHP_EOL, $archivo);
  array_pop($array);
  $arrayFinal = [];
  foreach ($array as $usuario) {
    $arrayFinal[] = json_decode($usuario, true);
  }
  return $arrayFinal;
}
function traerPorEmail($email) {
  $todos = traerTodos();
  foreach ($todos as $usuario) {
    if ($usuario["email"] == $email) {
      return $usuario;
    }
  }
  return NULL;
}
function validatePassword($data){
  $errores = [];
  if ($data['npassword'] != $data['cpassword']) {
    $errores['cpassword'] = 'Los datos no coinciden';
  }
  if (count($data['npassword']) > 20) {
    $errores['npassword'] = 'Contraseña muy larga';
  }
  return $errores;
}
function updatePassword($data){
    $hash = password_hash($data['npassword'], PASSWORD_DEFAULT);
    $wf = traerTodos();
    unlink('usuarios.json');
    foreach ($wf as $key => $value) {
        foreach ($wf[$key] as $index => $valor) {
            if ($valor == $_SESSION['email']) {
                $wf[$key]['password'] = $hash;
            }
        }
        $user = json_encode($wf[$key]) . PHP_EOL;
        file_put_contents('usuarios.json',$user, FILE_APPEND);
    }
}
function validarDatos($datos){
  $errores = [];
  $server = traerPorEmail($_POST['email']);
  if ($datos['email'] != $server['email']) {
    $errores['email'] = 'El email es invalido';
  }
  if ($datos['edad'] != $server['edad']) {
    $errores['edad'] = 'Edad invalida';
  }
  $_SESSION['email'] = $datos['email'];
  return $errores;
}

?>
