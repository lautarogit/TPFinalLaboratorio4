<?php 
     require_once(VIEWS_PATH."header.php"); 
     require_once(VIEWS_PATH."nav.php");

     if(!isset($_SESSION['loggedUser']))
     {
          $rolId = -1;
     }
?>

<?php 
     if(!empty($errorMessage))
     {
?>
          <div class="alert alert-danger alert-dismissible" style="width: 575px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong><?php echo $errorMessage;?></strong>
          </div>
<?php      
     }   
?>

<?php
     if(!empty($roomList))
     {
?>
     <main class="py-3 text-white">
          <section>
               <div class="container">
                    <h2 class="mb-4">Salas habilitadas de <p style="color: red; display: inline;"><?php echo $cinema->getName();?></p></h2>
                    <table class="table bg-dark text-white">
                         <thead>
                              <th>Nombre de sala</th>
                              <th>Precio</th>
                              <th>Capacidad</th>    
                    <?php   
                    
                         if(isset($rolId))
                         {  
                              if($rolId == 1)
                              { 
                    ?>
                                   <th>Estado</th>
                    <?php 
                              }    
                    ?>
                                   <th>Show</th>
                    <?php 
                              if($rolId == 1)
                              { 
                    ?>
                                   <th>Editar</th>
                                   <th>Eliminar</th>
                    <?php 
                              }  
                         }
                    ?>
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
                                             <td><?php echo "<strong>$</strong>".$roomValue->getPrice();?></td>
                                             <td><?php echo $roomValue->getCapacity();?></td>
                                        <?php      
                                             if(isset($rolId) && $rolId == 1)
                                             { 
                                        ?>
                                                  <td><i class="fas fa-check-circle" style="color: green;"></i></td>
                                        <?php      
                                             }
                                             
                                             if(isset($rolId))
                                             { 
                                                  if(!empty($roomValue->getIdShow()))
                                                  {
                                        ?>
                                                       <td> 
                                                            <form method="POST" action="<?= FRONT_ROOT."Show/showDataView";?>"> 
                                                                 <button class="btn btn-info btn-sm" type="submit" name="idShow" value="<?= $roomValue->getIdShow();?>">
                                                                      <i class="fas fa-eye"></i>  Ver show
                                                                 </button>
                                                            </form> 
                                        <?php 
                                                  }

                                                  if(!empty($roomValue->getIdShow()) && $rolId == 1)
                                                  {
                                        ?>
                                                            <form method="POST" action="<?= FRONT_ROOT."Show/showAddView";?>"> 
                                                                 <button class="btn btn-success btn-sm" type="submit" name="idRoom" value="<?= $roomValue->getId();?>">
                                                                      <i class="fas fa-calendar-plus"></i>  Agregar show
                                                                 </button>
                                                            </form> 
                                                       </td>
                                        <?php 
                                                  }
                                             }
                                   }

                                        if(isset($rolId) && $rolId == 1)
                                        { 
                                   ?>             
                                             <td> 
                                                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?= "#editRoom".$roomValue->getId(); ?>">
                                                       <i class="fas fa-cogs"></i>
                                                  </button>
                                             </td>

                                             <td>
                                                  <form method="POST" action="<?php echo FRONT_ROOT."Room/disableRoom";?>"> 
                                                       <button class="btn btn-danger btn-sm" value="<?= $roomValue->getId(); ?>" name="id">
                                                            <i class="fas fa-trash"></i>
                                                       </button>
                                                  </form>
                                             </td>      
                                   <?php      
                                        } 
                                   ?>
                                        </tr>

                                        <!-- Edit room Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog" id="<?= "editRoom".$roomValue->getId();?>">
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
                                                                 <form class="bg-dark-alpha p-5 text-black" action="<?= FRONT_ROOT."Room/editRoom"?>" method="POST">
                                                                      <div class="form-group">
                                                                           <label for="id"><h5><strong>ID de sala</strong> (No editable)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="id" value="<?= $roomValue->getId();?>" readonly/>
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="idCinema"><h5><strong>ID del cine</strong> (No editable)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="idCinema" value="<?= $roomValue->getIdCinema();?>" readonly/>
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="capacity"><h5><strong>Capacidad</strong> (2-3 dígitos)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="capacity" value="<?= $roomValue->getCapacity();?>" placeholder="Ingresar capacidad">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="price"><h5><strong>Precio</strong> (2-10 dígitos)</h5></label>
                                                                           <input class="form-control form-control-lg" type="number" name="price" value="<?= $roomValue->getPrice();?>" placeholder="Ingresar precio">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="name"><h5><strong>Nombre</strong> (2-25 caracteres)</h5></label>
                                                                           <input class="form-control form-control-lg" type="text" name="name" value="<?= $roomValue->getName();?>" placeholder="Ingresar nombre">
                                                                      </div>

                                                                      <div class="form-group">
                                                                           <label for="status"><h5><strong>Estado</strong></h5></label>
                                                                           <input type="radio" name="status" value="<?= true;?>">Habilitado
                                                                           <input type="radio" name="status" value="<?= false;?>">Deshabilitado
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
                         ?>     
                         </tbody>
                    </table>

          <?php      
               if(!empty($rolId) && $rolId == 1)
               { 
          ?>
                    <h2 class="mb-4">Salas deshabilitadas de <p style="color: red; display: inline;"><?php echo $cinema->getName();?></p></h2>
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
          <?php      
               }
          ?>     
           
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
     require_once(VIEWS_PATH."footer.php");
?>