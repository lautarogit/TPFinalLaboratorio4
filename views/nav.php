<?php 
    use Models\User as User;
    use Models\Rol as Rol;
?>

<nav class="navbar navbar-expand-lg bg-dark">
     <span class="navbar-text">
          <img src="<?php echo IMG_PATH."logo.png"; ?>" style="display: inline;">
          <?php
            if($_SESSION['loggedUser'] != null)
            {
              ?>
                <h2 style="display: inline;">Bienvenido </h2>
                <h4 class="text-white" style="display: inline;"><?php echo "<strong>".$_SESSION['loggedUser']->getUserName()."</strong>"; ?></h4>
              <?php
            }
          ?>
     </span>
     <ul class="navbar-nav ml-auto">
          <?php if($_SESSION['loggedUser']){ ?>
          <li class="nav-item">
            <a class="btn btn-danger" role="button" href="<?php echo FRONT_ROOT."Home/logout"?>">Cerrar sesión</a>
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#infoModal">i</button>
          </li>
          <?php }else{ ?>
          <li class="nav-item">
            <a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Home/showLoginView"?>">Iniciar sesión</a>
          </li>
          <?php } ?>
     </ul>
</nav>

<div class="modal fade" tabindex="-1" role="dialog" id="infoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content background-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title">Información de la cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php 
          $user = new User();
          $rol = new Rol();

          $user = $_SESSION['loggedUser'];

          $rolId = $user->getRolId();
          $rol->setId($rolId);
          $rol->setRolType($rolId);
        ?>

        <p><strong>Nombre de usuario: </strong><?php echo $user->getUserName();?></p>
        <p><strong>Nombre: </strong><?php echo $user->getFirstName();?></p>
        <p><strong>Apellido: </strong><?php echo $user->getLastName();?></p>
        <p><strong>DNI: </strong><?php echo $user->getDni();?></p>
        <p><strong>Email: </strong><?php echo $user->getEmail();?></p>
        <p><strong>Rol: </strong><?php echo $rol->getRolType();?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php 
    require_once("footer.php");
?>