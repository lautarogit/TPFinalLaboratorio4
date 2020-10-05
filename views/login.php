<?php require 'header.php'; ?>

<main>
     <div>
          <form action="<?php echo FRONT_ROOT."Home/Login "?>" method="post">
               <div>
                    <label for="username">Usuario</label>
                    <input type="text" name="userName" class="form-control form-control-lg" placeholder="Ingresar usuario">
               </div>
               <div>
                    <label for="password">Contraseña</label>
                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
               </div>
               <button type="submit">Iniciar Sesión</button>
          </form>
     </div>
</main>

<?php require 'footer.php'; ?>