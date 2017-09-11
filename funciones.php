<?php
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
?>
