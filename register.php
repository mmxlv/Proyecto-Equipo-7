<?php include_once ("header.php") ?>
      <section>
        <div class="register-form-div">
          <form class="register-form" action="dbregister.php" method="post">
            <label for="nombre-register">Nombre</label><br>
            <input type="text" name="nombre-register" value=""><br>
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value=""><br>
            <label for="register-pass">Contraseña</label><br>
            <input id="register-pass" type="password" name="register-pass" value=""><br>
            <input type="submit" name="register" value="Register">
          </form>
        </div>
      </section>
<?php include_once ("footer.php") ?>
