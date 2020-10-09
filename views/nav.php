<?php 
     require_once("header.php");
?>

<nav class="navbar navbar-expand-lg bg-dark">
     <span class="navbar-text">
          <img src="<?php echo IMG_PATH."logo.png"; ?>">
     </span>
     <ul class="navbar-nav ml-auto">
          <?php if($_SESSION['loggedUser']){ ?>
          <li class="nav-item">
               <a class="btn btn-danger" role="button" href="<?php echo FRONT_ROOT."Home/logout"?>">LOGOUT</a>
               <a class="btn btn-outline-primary" role="button" data-toggle="modal" data-target="#infoModal">i</a>
          </li>
          <?php }else{ ?>
          <li class="nav-item">
          <a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Home/showLoginView"?>">LOGIN</a>
          </li>
          <?php } ?>
     </ul>
</nav>

<div class="modal" tabindex="-1" role="dialog" id="infoModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>