<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <form action="<?php echo FRONT_ROOT."Home/login";?>" method="post" class="login-form bg-dark-alpha p-5 text-white">
               <div class="form-group">
                    <label for="username"><h5>Usuario</h5></label>
                    <input class="form-control form-control-lg" type="text" name="userName" placeholder="Ingresar usuario">
               </div>

               <div class="form-group">
                    <label for="password"><h5>Contraseña</h5></label>
                    <input class="form-control form-control-lg" type="text" name="password" placeholder="Ingresar constraseña">
               </div>

               <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="loggedUserCheck">
                    <label class="form-check-label" for="loggedUserCheck">Recordar datos</label>
               </div>

               <button class="btn btn-primary btn-block btn-lg background-aquamarina" type="submit">Iniciar sesion</button>
          </form>
     </div>
</main>
