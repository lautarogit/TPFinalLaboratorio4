<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title></title>
     <link rel="stylesheet" type="text/css" href="views/assets/layouts/styles/style.css">
          

</head>

<?php 
$_SESSION['loggedUser']=null;  ?>

<body>
     <nav class="">
          <span class="l-n">
             <img src="views/assets/img/movie pass.png">
          </span>
          <ul class="">
               <li class="l-n">
                    <a class="nav-link" href="<?php //echo  FRONT_ROOT."CellPhone/ShowAddView "?>">Listar Facturas</a>
               </li>

               <li class="l-n">
                    <a class="nav-link" href="<?php //echo  FRONT_ROOT."CellPhone/ShowListView "?>">Agregar Facturas</a>
               </li>

               <?php if($_SESSION['loggedUser']) { ?>
               <li class="l-n">
                    <a href="<?php echo  FRONT_ROOT."Home/Logout "?>">LOGOUT</a>
               </li>
               <?php }else{ ?>
               <li class="l-n">
                    <a href="<?php echo  FRONT_ROOT."Home/Login "?>">LOGIN</a>
               </li>
               <?php } ?>
          </ul>
     </nav>
</body>
</html>