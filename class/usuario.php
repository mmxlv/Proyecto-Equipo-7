<?php

class Usuario {
  private $id;
  private $username;
  private $email;
  private $password;

  public function __construct($username, $email, $password, $id = NULL){
    if ($id == NULL) {
      $this->password = password_hash($password, PASSWORD_DEFAULT);
    } else {
      $this->password = $password;
    }

    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
  }

  public function getId(){
    return $this->id;
  }
  public function setId($id){
    $this->id = $id;
  }
  public function getUsername(){
    return $this->username;
  }
  public function setUsername($username){
    $this->username = $username;
  }
  public function getEmail(){
    return $this->email;
  }
  public function setEmail($email){
    $this->email = $email;
  }
  public function getPassword(){
    return $this->password;
  }
  public function setPassword($password){
    $this->password = $password;
  }

}

 ?>
