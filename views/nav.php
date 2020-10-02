<body>
     <nav class="">
          <span class="">
               <strong>Movie Pass</strong>
          </span>
          <ul class="">
               <li class="">
                    <a class="nav-link" href="<?php //echo  FRONT_ROOT."CellPhone/ShowAddView "?>">Listar Facturas</a>
               </li>

               <li class="">
                    <a class="nav-link" href="<?php //echo  FRONT_ROOT."CellPhone/ShowListView "?>">Agregar Facturas</a>
               </li>

               <?php if($_SESSION['loggedUser']){ ?>
               <li class="">
                    <a href="<?php echo  FRONT_ROOT."Home/Logout "?>">LOGOUT</a>
               </li>
               <?php }else{ ?>
               <li class="">
                    <a href="<?php echo  FRONT_ROOT."Home/Login "?>">LOGIN</a>
               </li>
               <?php } ?>
          </ul>
     </nav>
</body>
