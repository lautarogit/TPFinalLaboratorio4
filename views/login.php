<?php 
     require_once("header.php"); 
     require_once("nav.php");
?>

<div>
     <form action="<?php echo FRONT_ROOT."Home/login";?>" method="post">
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
