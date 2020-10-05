<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title></title>
     <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH."style.css"; ?>">
</head>

<?php $_SESSION['loggedUser']=null; ?>

<body>
     <nav class="">
          <span class="l-n">
             <img src="views/assets/img/movie pass.png">
          </span>
          <ul class="">
               <?php if($_SESSION['loggedUser']) { ?>
               <li class="l-n">
                    <a href="<?php echo FRONT_ROOT."Home/Logout"?>">LOGOUT</a>
               </li>
               <?php }else{ ?>
               <li class="l-n">
                    <a href="<?php echo "views/login.php" ?>">LOGIN</a> 
               </li>
               <?php } ?>
               hola
          </ul>
     </nav>
</body>
</html>