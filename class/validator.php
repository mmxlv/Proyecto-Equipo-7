<?php

include_once 'db.php';

class Validator {
  public function validarInformacion($informacion, db $db) {
    $arrayDeErrores = [];

    foreach ($informacion as $key => $value) {
      $informacion[$key] = trim($value);
    }

    if(strlen($informacion["username"]) < 3 || strlen($informacion["username"]) > 20) {
      $arrayDeErrores["username"] = "Nombre de usuario Invalido";
    }

    if (strlen($informacion["email"]) == 0) {
      $arrayDeErrores["email"] = "Email Invalido";
    }
    else if(filter_var($informacion["email"], FILTER_VALIDATE_EMAIL) == false) {
      $arrayDeErrores["email"] = "Email Invalido";
    }
    else if ($db->traerPorEmail($informacion["email"]) != NULL) {
      $arrayDeErrores["email"] = "El usuario ya existe";
    }

    if (strlen($informacion["password"]) < 6) {
      $arrayDeErrores["password"] = "La contraseña tiene que tener al menos 6 caracteres";
    } else if ($informacion["password"] != $informacion["cpassword"]) {
      $arrayDeErrores["password"] = "Las Contraseñas no son iguales";
    }

    $errorDeLaFoto = $_FILES["imgprofile"]["error"];
    $nombreDeLaFoto = $_FILES["imgprofile"]["name"];
    $extension = pathinfo($nombreDeLaFoto, PATHINFO_EXTENSION);

    if ($errorDeLaFoto != UPLOAD_ERR_OK) {
      $arrayDeErrores["foto-perfil"] = "Hubo un error al cargar la foto";
    }
    else if ($extension != "jpg" && $extension != "jpeg" && $extension != "png" && $extension != "gif") {
      $arrayDeErrores["foto-perfil"] = "Tipo de archivo invalido";
    }

    return $arrayDeErrores;
  }

  public function validarLogin($informacion, db $db) {
    $arrayDeErrores = [];

    if (strlen($informacion["email"]) == 0) {
      $arrayDeErrores["email"] = "Email incorrecto";
    }
    else if(filter_var($informacion["email"], FILTER_VALIDATE_EMAIL) == false) {
      $arrayDeErrores["email"] = "Email incorrecto";
    }
    else if ($db->traerPorEmail($informacion["email"]) == NULL) {
      $arrayDeErrores["email"] = "El usuario no existe";
    } else {
      $usuario = $db->traerPorEmail($informacion["email"]);
      if (password_verify($informacion["password"], $usuario->getPassword()) == false) {
        $arrayDeErrores["password"] = "Contraseña invalida";
      }
    }

    return $arrayDeErrores;
  }
  public function validarNewPassword($info, db $db) {
    $listDeError = [];

    if (strlen($info['username']) == 0) {
      $listDeError['username'] = 'Datos Invalidos';
    }
    if (strlen($info['email']) == 0) {
      $listDeError['email'] = 'Datos Invalidos';
    }
    else if (filter_var($info['email'], FILTER_VALIDATE_EMAIL) == false) {
      $listDeError['email'] = 'Datos Invalidos';
    }
    else if ($db->traerPorEmail($info['email']) == NULL) {
      $listDeError['email'] = 'Datos Invalidos';
    }
    else {
      $user = $db->traerPorEmail($info['email']);
      if ($info['username'] != $user->getUsername()) {
        $listDeError = 'Datos Invalidos';
      }
    }
    return $listDeError;
  }
  public function checkNewPassword($info) {
    $checklist = [];

    if ($info['password'] != $info['cpassword']) {
      $checklist['password'] = 'Datos Invalidos desigual';
    }
    if (strlen($info['password']) < 7) {
      $checklist['password'] = 'Datos Invalidos menor';
    }else if (strlen($info['password']) > 20){
      $checklist['password'] = 'Datos Invalidos mayor';
    }
    return $checklist;
  }
}

?>
