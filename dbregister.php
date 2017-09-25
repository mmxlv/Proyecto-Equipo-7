<?php
require_once 'funciones.php';

$link = mysqli_connect("localhost", "root", "", "register");

if($link === false){
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

//password hashing
$passhash = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

$username = mysqli_real_escape_string($link, $_REQUEST['username']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
$password = mysqli_real_escape_string($link, $passhash);


$sql = "INSERT INTO register (nombre, password, email) VALUES ('$username', '$password', '$email')";
if(mysqli_query($link, $sql)){
    include_once ("header.php"); ?>

            <div style="text-align: center; margin: 10px" class="exito">
              <span>Exito al registrarse!</span>
            </div>

<?php    include_once("footer.php");
} else{
    echo "ERROR: No se pudo insertar los datos en la base de datos."/*$sql*/  . mysqli_error($link);
}
mysqli_close($link);
exit;
?>
