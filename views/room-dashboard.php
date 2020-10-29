<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use Models\Cinema as Cinema;
     use Models\Room as Room;

     $rolId = $_SESSION['loggedUser']->getRolId();
     $cinemaDAO = new CinemaDAO();
     $cinema = new Cinema();

     $cinema = $cinemaDAO->getCinemaById($idCinema);
      
     if(!empty($errorMessage))
     {
          echo $errorMessage;
     }

     if(!empty($roomList))
     {
?>
     <main class="py-3 text-white">
          <section>
               <div class="container">
                    <h2 class="mb-4">Salas habilitadas de <?php echo $cinema->getName();?></h2>
                    <table class="table bg-dark text-white">
                         <thead>
                              <th>Nombre de sala</th>
                              <th>Precio</th>
                              <th>Capacidad</th>
                              <th>Estado</th>
                              <th>Editar</th>
                              <th>Eliminar</th>
                         </thead>

                         <tbody>
                         <?php 
                              foreach($roomList as $roomValue) 
                              {
                                   if($roomValue->getStatus())
                                   {
                         ?>
                                        <tr>
                                             <td><?php echo $roomValue->getName();?></td>
                                             <td><?php echo $roomValue->getPrice();?></td>
                                             <td><?php echo $roomValue->getCapacity();?></td>
                                             <td><i class="fas fa-check-circle" style="color: green;"></i></td>
                                             <td> 
                                                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?php echo "#editRoom".$roomValue->getId(); ?>">
                                                       <i class="fas fa-cogs"></i>
                                                  </button>
                                             </td>
                                             <td>
                                                  <form method="POST" action="<?php echo FRONT_ROOT."Room/disableRoom";?>"> 
                                                       <button class="btn btn-danger btn-sm" value="<?php echo $roomValue->getId(); ?>" name="id">
                                                            <i class="fas fa-trash"></i>
                                                       </button>
                                                  </form>
                                             </td>
                                        </tr>

                                        <!-- Edit room Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo "editRoom".$roomValue->getId();?>">
                                             <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content background-dark text-white">
                                                       <div class="modal-header">
                                                            <h5 class="modal-title">Editar sala</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                            </button>
                                                       </div>

                                                       <div class="modal-body">
                                                            <div class="content d-flex d-center" style="justify-content: center;"> 
                                                                 <form class="bg-dark-alpha p-5 text-black" action="<?php echo FRONT_ROOT."Room/editRoom"?>" method="POST">
                                                                      <div class="form-group">
                                                                           <label for="id"><h5><strong>ID de sala</strong> (No editable)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="id" value="<?php echo $roomValue->getId();?>" readonly/>
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="idCinema"><h5><strong>ID del cine</strong> (No editable)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="idCinema" value="<?php echo $roomValue->getIdCinema();?>" readonly/>
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="capacity"><h5><strong>Capacidad</strong> (2-3 dígitos)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="capacity" value="<?php echo $roomValue->getCapacity();?>" placeholder="Ingresar localidad">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="price"><h5><strong>Precio</strong> (2-10 dígitos)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="price" value="<?php echo $roomValue->getPrice();?>" placeholder="Ingresar localidad">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="name"><h5><strong>Nombre</strong> (2-25 caracteres)</h5></label>
                                                                           <input class="form-control form-control-lg" type="text" name="name" value="<?php echo $roomValue->getName();?>" placeholder="Ingresar capacidad">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="status"><h5><strong>Estado</strong></h5></label>
                                                                           <input class="radioSize" type="radio" name="status" value="<?= true;?>">Habilitado
                                                                           <input class="radioSize" type="radio" name="status" value="<?= false;?>">Deshabilitado
                                                                      </div>

                                                                      <button type="submit" class="btn btn-warning">
                                                                           Confirmar cambios
                                                                      </button>
                                                                 </form>
                                                            </div>
                                                       </div>
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        <!-- ----------------- -->
                         <?php 
                                   }
                              } 
                         ?>     
                         </tbody>
                    </table>

                    <h2 class="mb-4">Salas deshabilitadas de <?php echo $cinema->getName();?></h2>
                    <table class="table bg-dark text-white">
                         <thead>
                              <th>Nombre de sala</th>
                              <th>Precio</th>
                              <th>Capacidad</th>
                              <th>Estado</th>
                              <th>Restaurar</th>
                         </thead>

                         <tbody>
                         <?php 
                              foreach($roomList as $roomValue) 
                              {
                                   if(!$roomValue->getStatus())
                                   {
                         ?>
                                        <tr>
                                             <td><?php echo $roomValue->getName();?></td>
                                             <td><?php echo $roomValue->getPrice();?></td>
                                             <td><?php echo $roomValue->getCapacity();?></td>
                                             <td><i class="fas fa-ban" style="color: red;"></i></td>
                                             <td>
                                                  <form method="POST" action="<?php echo FRONT_ROOT."Room/disableRoom";?>"> 
                                                       <button class="btn btn-info btn-sm" value="<?php echo $roomValue->getId(); ?>" name="id">
                                                            <i class="fas fa-trash-restore" style="color: blue;"></i>
                                                       </button>
                                                  </form>
                                             </td>
                                        </tr>
                         <?php 
                                   }
                              } 
                         ?>     
                         </tbody>
                    </table>
               </div>
          </section>
     </main>
<?php 
     }
     else
     {
          ?>
               <h2 class="text-white">No hay salas disponibles en <?php echo $cinema->getName();?></h2>
<?php
     }
?>

<a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Cinema/showCinemaDashboard";?>">
     Volver
</a>

<?php 
     require_once("footer.php");
?>