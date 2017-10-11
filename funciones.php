<?php

session_start();

if (!isset($_SESSION["usuarioLogueado"]) && isset($_COOKIE["usuarioLogueado"])) {
    $_SESSION["usuarioLogueado"] = $_COOKIE["usuarioLogueado"];
}

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
function crearDbMysql(){
  $dsn = 'mysql:host=localhost;dbname=register;charset=utf8mb4;port=3306';

}
function crearUsuarioMysql($data){
  $dsn = 'mysql:host=localhost;dbname=register;charset=utf8mb4;port=3306';
  $db_user = 'root';
  $db_pass = '';
  $passhash = password_hash($data['password'], PASSWORD_DEFAULT);
  $username = $data['username'];
  $email = $data['email'];
  try {
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->beginTransaction();
    $query = $db->prepare('INSERT INTO register (nombre, password, email) VALUES (:username, :password, :email)');
    $query->bindValue(':username', $username);
    $query->bindValue(':password', $passhash);
    $query->bindValue(':email', $email);
    $query->execute();
    $db->commit();
  } catch (PDOException $e) {
      $db->rollBack();
      return $e->getMessage();
  }
  $db = NULL;
}

function loginUserMysql($data){
  $dsn = 'mysql:host=localhost;dbname=register;charset=utf8mb4;port=3306';
  $db_user = 'root';
  $db_pass = '';

  try {
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->beginTransaction();
    $query = $db->prepare('SELECT * FROM register WHERE email LIKE :userLogin');
    $query->bindValue(':userLogin', $data['email']);
    $query->execute();
    $db->commit();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $db->rollBack();
    echo $e->getMessage();
  }
  $db = NULL;
  $error = [];
  $user = $result[0];
  if (password_verify($data['password'], $user['password']) != true) {
    $error['pass'] = 'hay un problema';
  }
  if ($data['email'] != $user['email']) {
    $error['email'] = 'hay un problema';
  }
  if(count($error) == 0){
    $_SESSION['id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['nombre'] = $user['nombre'];
  }
}

function crearUsuario($data){
  return [
          "username" => $data["username"],
          "email" => $data["email"],
          "password" => password_hash($data["password"], PASSWORD_DEFAULT),
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
  if ($datos['username'] != $server['username']) {
    $errores['username'] = 'Nombre Invalido';
  }
  $_SESSION['email'] = $datos['email'];
  return $errores;
}

function validarLogin($informacion){
  $controlDeErrores=[];

  if (strlen($informacion["email"])==0){
    $controlDeErrores["email"] = "Falta ingresar email";
  }

  if (filter_var($informacion["email"],FILTER_VALIDATE_EMAIL) == false){
    $controlDeErrores["email"] = "Email invalido";
  }

  if(traerPorEmail ($informacion["email"])== NULL){
    $controlDeErrores["email"] = "El usuario no existe";

  }
  $usuario = traerPorEmail($informacion['email']);
  if (password_verify($informacion['password'], $usuario['password']) != true) {
    $controlDeErrores['password'] = "La contraseña no verifica";
  }
  return $controlDeErrores;
}

function Loguear ($email){
  $_SESSION ["usuarioLogueado"]= $email;
}

function estaLogueado(){
  if(isset($_SESSION ["usuarioLogueado"])){
    return true;
  }else{
    return false;
  }
}

function usuarioLogueado(){
  if (estaLogueado()){
    return traerPorEmail ($_SESSION ["usuarioLogueado"]);
  }else {
    return NULL;
  }
}

function recordarUsuario ($email){
  setcookie ("usuarioLogueado", $email, time() + 60*60*24*3);
}

?>
