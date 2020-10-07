<?php 
     require_once("header.php");
     
?>

<body>
     <nav>
          <span class="l-n">
             <img src="<?php echo IMG_PATH."moviepass.png"; ?>">
          </span>
          <ul class="l-n">
               <?php if($_SESSION['loggedUser']){ ?>
               <li class="l-n">
                    <a href="<?php echo FRONT_ROOT."Home/logout"?>">LOGOUT</a>
               </li>
               <?php }else{ ?>
               <li class="l-n">
                    <a href="<?php echo FRONT_ROOT."Home/showLogin";?>">LOGIN</a> 
               </li>
               <?php } ?>
          </ul>
     </nav>
</body>
</html>