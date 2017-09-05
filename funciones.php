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
  return $arrayDeErrores;
}
?>
