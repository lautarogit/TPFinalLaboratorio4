
<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
  
     <link rel="stylesheet" href="<?php CSS_PATH."style.css" ?>">
<?php require_once("header.php"); ?>
<body>
     

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
               <input type="submit" name="send" value="iniciar sesion">
          </form>
     </div>
   

</body>

</html>
<?php require 'footer.php'; ?>