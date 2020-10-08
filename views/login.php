
<?php 
     require_once("header.php"); 
     require_once("nav.php");
?>

<head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="<?php echo CSS_PATH."style.css"; ?>">
</head>

<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <form action="<?php echo FRONT_ROOT."Home/login";?>" method="post" class="login-form bg-dark-alpha p-5 text-white">
               <div class="form-group">
                    <label for="username">Usuario</label>
                    <input class="form-control form-control-lg" type="text" name="userName" placeholder="Ingresar usuario">
               </div>
               <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input class="form-control form-control-lg" type="text" name="password" placeholder="Ingresar constraseña">
               </div>
               <button class="btn btn-dark btn-block btn-lg" type="submit">Iniciar Sesión</button>
          </form>
     </div>
</main>

