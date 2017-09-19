<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/accordion.css">
    <script>
    function showDropdown(){
      document.getElementById("main-drop").style.display="block";
    }
    </script>
    <title>Home</title>
  </head>
  <body>
    <div class="login-head">
      <!-- login form va por aca en algun lado  //-->
      <span>EMAIL</span>
      <span>SEARCH</span>
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
            <!-- agregar links a panel de usuario y desactivar login y register si el user esta logieado -->
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
                <!-- lo mismo que en el nav de escritorio -->
              </div>
            </li>
          </ul>
        </nav>
      </header>
