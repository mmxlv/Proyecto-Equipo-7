<div id="loginBoxDiv" class="">
  <form class="aio" action="<?php //falta accion ?>" method="post">
    <label for="">Email:</label><br>
    <input type="email" name="email" value=""><br>
    <label for="">Contraseña:</label><br>
    <input type="password" name="password" value=""><br>
    <a href="#">¿Olvido su Contraseña?</a><br>
    <input type="checkbox" name="remember" value="">
    <label for="">Recordarme</label><br>
    <input type="submit" name="" value="Login">
    <button type="button" name="button" onclick="loginBox()">Cancelar</button>
  </form>
</div>
<!---->
<div id="registerBoxDiv">
  <form class="register-form" action="register.php" method="post" enctype="multipart/form-data">
    <label for="username">Nombre</label><br>
    <input  id="username" type="text" name="username" value=""><br>
    <label for="email">Email</label><br>
    <input id="email" type="email" name="email" value=""><br>
    <label for="register-pass">Contraseña:</label><br>
    <input id="register-pass" type="password" name="password" value=""><br>
    <label for="cpassword">Repetir contraseña:</label><br>
    <input id="cpassword" type="password" name="cpassword" value=""><br>
    <label for="">Foto de Perfil</label><br>
    <input type="file" name="imgprofile" value=""><br>
    <input type="submit" name="" value="Register">
    <button type="button" name="button" onclick="registerBox()">Cancel</button>
  </form>
</div>
