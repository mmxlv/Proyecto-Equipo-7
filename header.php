<?php require_once 'funciones.php';
if (estaLogueado()==true) {
  $TEST = traerPorEmail($_SESSION['usuarioLogueado']);
  $username = $TEST['username'];
  $id = $TEST['id'];
}
if (isset($_POST['logout'])) {
  session_destroy();
  unset($_COOKIE);
  header('location:index.php');
  exit;
}
require_once 'register-v2.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/accordion.css">
    <link rel="stylesheet" href="css/aio.css">
    <?php if (estaLogueado() == true): ?>
      <style>
        .not-logged{
          display: none;
        }
        .logged{
          display: block;
        }
      </style>
    <?php else: ?>
      <style>
        .not-logged{
          display: block;
        }
        .logged{
          display: none;
        }
      </style>
    <?php endif; ?>
    <script>
    function showDropdown(){
      document.getElementById("main-drop").style.display="block";
    }
    </script>
    <script src="js/display.js"></script>
    <title>Home</title>
  </head>
  <body>
    <div class="login-head">
      <!-- Faltan styles -->
      <div class='not-logged'>
        <button class="loginBoxBtn" type="button" name="button" onclick="registerBox()">Register</button>
        <span class="temp">Or</span>
        <button class="loginBoxBtn" type="button" name="button" onclick="loginBox()">Login</button>
      </div>
      <div class="logged">
        <div class="loginBoxBtn">
          <span class="loginBoxTxt">Bienvenido</span>
          <a class="loginBoxLnk" href="panel.php?uid=<?=$id?>"><?=$username?></a>
          <form class="loginBoxFrm" action="index.php" method="post">
            <input class="loginBoxInp" type="submit" name="logout" value="Log Out">
          </form>
        </div>
      </div>
      <!-- End -->
      <span class="temp">EMAIL</span>
      <span class="temp">SEARCH</span>
      <!-- form q simula el estado logueado -->
      <!-- <form class="" action="index.php" method="post">
        <input type="submit" name="name" value="name">
        <input type="submit" name="dname" value="dname">
      </form> -->
      <!-- end -->
    </div>
    <div class="container">

      <header class="main-head">
        <div class="logo">
          <!--<img src="" alt="Logo">//-->
          <span>E-Comerce logo</span>
        </div>
        <div>
          <!-- nav de escritorio //-->
          <ul class="nav-bar-lg">
            <li><a class="dropbtn" href="index.php">Home</a></li>
            <li><a class="dropbtn" href="login.php">Login</a></li>
            <li><a class="dropbtn" href="register.php">Register</a></li>
            <li><a class="dropbtn" href="faqs.php">FAQs</a></li>
          </ul>
        </div>
        <nav>
          <!-- nav celular y tablet -->
          <ul class="nav-bar">
            <li class="dropdown">
              <button class="dropbtn" onclick="showDropdown()">Menu</button>
              <div id="main-drop" class="dropdown-content">
                <a href="index.php">Home</a>
                <a href="faqs.php">FAQs</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
              </div>
            </li>
          </ul>
        </nav>
      </header>
