<?php 
     require_once("header.php");
     $_SESSION['loggedUser'] = null;
?>

<body>
     <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
          <span class="navbar-text">
             <img src="<?php echo IMG_PATH."moviepass.png"; ?>">
          </span>
          <ul class="navbar-nav ml-auto">
               <?php if($_SESSION['loggedUser']){ ?>
               <li class="nav-item">
                    <a href="<?php echo FRONT_ROOT."Home/logout"?>">LOGOUT</a>
               </li>
               <?php }else{ ?>
               <li class="nav-item">
                    <a href="<?php echo FRONT_ROOT."Home/showLogin";?>">LOGIN</a> 
               </li>    
               <li class="nav-item">
                    <a href="<?php echo FRONT_ROOT."User/ShowSignUp";?>">Sign-Up</a> 
               </li>
               <?php } ?>
          </ul>
     </nav>
</body>
