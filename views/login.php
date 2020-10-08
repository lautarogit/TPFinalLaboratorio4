
<?php 
     require_once("header.php"); 
     require_once("nav.php");
?>
<head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="<?php echo CSS_PATH."style.css"; ?>">
</head>

<div>
     <form action="<?php echo FRONT_ROOT."Home/showLogin";?>" method="post">
          <div>
               <label for="username">Usuario</label>
               <input type="text" name="userName" class="form-control form-control-lg" placeholder="Ingresar usuario">
          </div>
          <div>
               <label for="password">Contraseña</label>
               <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
          </div>
          <button type="submit" name="send">Iniciar Sesión</button>
     </form>
     <?php 
     var_dump($_SESSION["loggedUser"]); ?>
</div>
