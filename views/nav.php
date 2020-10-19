<?php 
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
?>

<nav class="navbar navbar-expand-lg bg-dark">
     <span class="navbar-text">
          <img src="<?php echo IMG_PATH."logo.png"; ?>">
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
          $user = $_SESSION['loggedUser']; 
        ?>

        <p><strong>Nombre de usuario: </strong><?php echo $user->getUserName();?></p>
        <p><strong>Nombre: </strong><?php echo $user->getFirstName();?></p>
        <p><strong>Apellido: </strong><?php echo $user->getLastName();?></p>
        <p><strong>DNI: </strong><?php echo $user->getDni();?></p>
        <p><strong>Email: </strong><?php echo $user->getEmail();?></p>
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