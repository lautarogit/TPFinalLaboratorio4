<main class="d-flex align-items-center justify-content-center height-100 transparent-box">
     <div class="content">
          <form action="<?php echo FRONT_ROOT."Home/login";?>" method="POST" class="login-form bg-dark-alpha p-2 text-white">
               <div class="form-group">
                    <i class="fas fa-user"></i><input class="login-input" type="text" name="userName" placeholder="Ingresar usuario">
               </div>

               <div class="form-group">
                    <i class="fas fa-key"></i><input class="login-input" type="password" name="password" placeholder="Ingresar constraseña">
               </div>

               <button class="btn btn-dark btn-block btn-lg" style="border-radius:7px 7px 7px 7px;" type="submit">Iniciar sesion</button>
          </form>

          <div class="text-center">
               <button class="btn btn-primary btn-lg text-center background-green" style="border-radius:7px 7px 7px 7px; width: 292px;" 
               data-toggle="modal" data-target="#signUpModal">
                    Únete ahora
               </button>
          </div>
          
          <div class="text-center m-2">
               <a class="btn btn-info btn-lg" style="border-radius:7px 7px 7px 7px; width: 292px;" rol="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>">
                    Continuar como invitado 
               </a>
          </div> 
     </div>
</main>

<?php 
     if(!empty($errorMessage) && $errorMessage)
     {
?>
          <div class="alert alert-danger alert-dismissible d-relative" style="width: 385px; top: 437px; left: 745px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Datos incorrectos. Ingrese nuevamente</strong>
          </div>
<?php      
     }   
?>

<?php 
     if(!empty($errorMessage) && !$errorMessage)
     {
?>
          <div class="alert alert-success alert-dismissible d-relative" style="width: 385px; top: 437px; left: 745px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong>Cuenta registrada con éxito.</strong>
          </div>
<?php      
     }   
?> 

<!-- Sign up Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="signUpModal">
     <div class="modal-dialog" role="document">
          <div class="modal-content background-dark text-white" style="border-radius:35px 5px 35px 5px;">
               <div class="modal-header">
                    <h5 class="modal-title">Crear cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
               </button>
               </div>

               <div class="modal-body">
                    <div class="content d-flex" style="justify-content: center;"> 
                         <form action="<?php echo FRONT_ROOT."Home/signUp";?>" method="POST" class="login-form bg-dark-alpha p-5 text-white">
                              <div class="form-group">
                                   <label for="firstName">Nombre (3-25 caracteres)</label>
                                   <input class="form-control form-control-lg" type="text" name="firstName" placeholder="Nombre" required>
                              </div>

                              <div class="form-group">
                                   <label for="lastName">Apellido (3-25 caracteres)</label>
                                   <input class="form-control form-control-lg" type="text" name="lastName" placeholder="Apellido" required>
                              </div>

                              <div class="form-group">
                                   <label for="userName">Nombre de usuario (4-16 caracteres)</label>
                                   <input class="form-control form-control-lg" type="text" name="userName" placeholder="Nombre de usuario" required>
                              </div>

                              <div class="form-group">
                              <label for="email">E-mail (10-40 caracteres)</label>
                                   <input class="form-control form-control-lg" type="email" name="email" placeholder="E-Mail" required>
                              </div>

                              <div class="form-group">
                              <label for="dni">DNI (8-9 dígitos)</label>
                                   <input class="form-control form-control-lg" type="number" name="dni" placeholder="DNI" required>
                              </div>

                              <div class="form-group">
                              <label for="password">Contraseña (6-45 caracteres)</label>
                                   <input class="form-control form-control-lg" type="password" name="password" placeholder="Contraseña" required>
                              </div>

                              <button class="btn btn-primary btn-block btn-lg text-center background-green" style="border-radius:25px 3px 25px 3px;" 
                              type="submit">
                                   Registrarte
                              </button>
                         </form>
                    </div>
               </div>

               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="border-radius:15px 2px 15px 2px;" data-dismiss="modal">Cerrar</button>
               </div>
          </div>
     </div>
</div>
<!-- ---------------- -->