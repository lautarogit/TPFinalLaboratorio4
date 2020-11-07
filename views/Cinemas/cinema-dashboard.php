<?php 
     require_once(VIEWS_PATH."header.php"); 
     require_once(VIEWS_PATH."nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use DAO\RoomDAO as RoomDAO;

     if(empty($rolId))
     {
          $cinemaDAO = new CinemaDAO();
          $cinemaList = $cinemaDAO->getAll();
     }
?>

<div class="m-2 inline">
     <?php 
          if(!empty($rolId) && $rolId == 1)
          {
     ?>
               <a class="btn btn-dark" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="
                    <?php echo FRONT_ROOT."Cinema/showDisabledCinemaDashboard";?>">Mostrar cines deshabilitados
               </a> 
     <?php
          }
     ?>
     
     <a class="btn btn-sm btn-outline-info background-dark m-1" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">
          <i class="fas fa-film"></i> Ver catálogo de películas
     </a>
</div>

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

<main class="d-flex m-2">
     <div class="card-rows">
          <div class="card-columns">
          <?php 
               if(!empty($rolId) && $rolId == 1)
               {
          ?>
                    <div class="card w-15 card-box-shadow">
                         <button class="btn btn-outline-dark background-dark text-white" style="width: 619px; height: 233px;" data-toggle="modal" data-target="#addCinema">
                              <h1><i class="fas fa-plus-square"></i></h1>
                         </button>
                    </div>

                    <!-- Add cinema Modal -->
                    <div class="modal fade" tabindex="-1" role="dialog" id="addCinema">
                         <div class="modal-dialog" role="document">
                              <div class="modal-content background-dark text-white">
                                   <div class="modal-header">
                                        <h5 class="modal-title">Agregar cine</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                   </div>

                                   <div class="modal-body">
                                        <div class="content d-flex" style="justify-content: center;"> 
                                             <form class="bg-dark-alpha p-5 text-black" action="<?php echo FRONT_ROOT."Cinema/addCinema"?>" method="POST">
                                                  <div class="form-group">
                                                       <label for="name"><h5><strong>Nombre</strong> (3-40 caracteres)</h5></label>
                                                       <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre">
                                                  </div>

                                                  <div class="form-group">
                                                       <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                       <input class="form-control form-control-lg" type="text" name="location" placeholder="Ingresar localidad">
                                                  </div>

                                                  <button type="submit" class="btn btn-success">
                                                       Agregar cine
                                                  </button>   
                                             </form>
                                        </div>
                                   </div>

                                   <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <!-- ---------------- -->
          <?php 
               }
          ?>
          
          <?php
                
                    if(!empty($cinemaList))
                    {
                         foreach($cinemaList as $cinemaValue) 
                         {
                              if($cinemaValue->getStatus())
                              {
               ?>
                                   <div class="card w-15 card-box-shadow text-white background-dark">
                                        <div class="card-header text-white background-linear-gradient">
                                             <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>
                                             <?php 
                                                  if(!empty($rolId) && $rolId == 1)
                                                  {
                                             ?>
                                                       <form style="float:right; display: inline; margin: 2px;" method="POST" action="<?php echo FRONT_ROOT."Cinema/disableCinema"?>"> 
                                                            <button class="btn btn-danger btn-sm" value="<?php echo $cinemaValue->getId(); ?>" name="id">
                                                                 <i class="fas fa-trash"></i>
                                                            </button>
                                                       </form>

                                                       <div style="float:right; display: inline; margin: 2px;"> 
                                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?php echo "#editCinema".$cinemaValue->getId();?>">
                                                                 <i class="fas fa-cogs"></i>
                                                            </button>
                                                       </div>
                                                       
                                                       <div style="float:right; display: inline; margin: 2px;"> 
                                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="<?php echo "#addRoom".$cinemaValue->getId();?>">
                                                                 Agregar sala
                                                            </button>
                                                       </div>
                                             <?php
                                                  }
                                             ?>
                                        </div>

                                        <div class="card-body">
                                             <p class="card-text">
                                                  <?php echo "<strong>Estado: </strong>";?><i class="fas fa-check-circle" style="color: green;"></i>
                                             </p>

                                             <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>
                                             
                                             <?php 
                                                  $idCinema = $cinemaValue->getId();

                                                  if(empty($rolId))
                                                  {
                                                       $roomDAO = new RoomDAO();
                                                       $roomList = $roomDAO->getRoomListByIdCinema($idCinema); 
                                                  }
                                                  else 
                                                  {
                                                       $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);
                                                  }
                                                  
                                                  $enableRoomList = array();

                                                  if(!empty($roomList))
                                                  {
                                                       foreach($roomList as $roomValue)
                                                       {
                                                            if($roomValue->getStatus())
                                                            {
                                                                 array_push($enableRoomList, $roomValue);
                                                            }
                                                       }

                                                       $roomListSize = count($enableRoomList);
                                                  }
                                                  else
                                                  {
                                                       $roomListSize = 0;
                                                  }
                                             ?>

                                             <p class="card-text">
                                                  <?php echo "<strong>N° de Salas disponibles: </strong>".$roomListSize;?>
                                             </p>
                                        </div>

                                        <form method="POST" action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>"> 
                                             <button class="btn btn-sm btn-outline-success background-dark btn-block" value="<?php echo $cinemaValue->getId();?>" name="idCinema">
                                                  <i class="fas fa-eye"></i> Ver salas
                                             </button>
                                        </form>
                                   </div>

                                   <?php
                                        if(!empty($rolId) && $rolId == 1)
                                        {       
                                   ?>
                                             <!-- Edit cinema Modal -->
                                             <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo "editCinema".$cinemaValue->getId();?>">
                                                  <div class="modal-dialog" role="document">
                                                       <div class="modal-content background-dark text-white">
                                                            <div class="modal-header">
                                                                 <h5 class="modal-title">Editar cine</h5>
                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                 <div class="content d-flex d-center" style="justify-content: center;"> 
                                                                      <form class="bg-dark-alpha p-5 text-black" action="<?php echo FRONT_ROOT."Cinema/editCinema"?>" method="POST">
                                                                           <div class="form-group">
                                                                                <label for="id"><h5><strong>ID</strong> (No editable)</h5></label>
                                                                                <input class="form-control form-control-lg" type="number" name="id" 
                                                                                value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="name"><h5><strong>Nombre</strong> (3-40 caracteres)</h5></label>
                                                                                <input class="form-control form-control-lg" type="text" name="name" 
                                                                                value="<?php echo $cinemaValue->getName();?>" placeholder="Ingresar nombre">
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                                                <input class="form-control form-control-lg" type="text" name="location" 
                                                                                value="<?php echo $cinemaValue->getLocation();?>" placeholder="Ingresar localidad">
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="status"><h5><strong>Estado</strong></h5></label>
                                                                                <input class="radioSize" type="radio" name="status" value="<?= true; ?>">Habilitado
                                                                                <input class="radioSize" type="radio" name="status" value="<?= false; ?>">Deshabilitado
                                                                           </div>

                                                                           <button type="submit" class="btn btn-warning">
                                                                                Confirmar cambios
                                                                           </button>
                                                                      </form>
                                                                 </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- ----------------- -->

                                             <!-- Add room Modal -->
                                             <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo "addRoom".$cinemaValue->getId();?>">
                                                  <div class="modal-dialog" role="document">
                                                       <div class="modal-content background-dark text-white">
                                                            <div class="modal-header">
                                                                 <h5 class="modal-title">Agregar sala</h5>
                                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                 <div class="content d-flex d-center" style="justify-content: center;"> 
                                                                      <form class="bg-dark-alpha p-5 text-black" action="<?php echo FRONT_ROOT."Room/addRoom"?>" method="POST">
                                                                           <div class="form-group">
                                                                                <label for="id"><h5><strong>ID del cine</strong> (No editable)</h5></label>
                                                                                <input class="form-control form-control-lg" type="number" name="idCinema" 
                                                                                value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="name"><h5><strong>Capacidad</strong> (3-40 dígitos)</h5></label>
                                                                                <input class="form-control form-control-lg" type="number" name="capacity" placeholder="Ingresar capacidad">
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="name"><h5><strong>Precio</strong></h5></label>
                                                                                <input class="form-control form-control-lg" type="number" name="price" placeholder="Ingresar precio">
                                                                           </div>

                                                                           <div class="form-group">
                                                                                <label for="capacity"><h5><strong>Nombre</strong> (2-25 caracteres)</h5></label>
                                                                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre">
                                                                           </div>

                                                                           <button type="submit" name="addRoom" class="btn btn-warning">
                                                                                Agregar sala
                                                                           </button>
                                                                      </form>
                                                                 </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <!-- ----------------- -->
                                   <?php
                                        }      
                                   ?>
               <?php
                              }
                         }
                    }
               ?> 
          </div>
     </div> 
</main>

<?php 
     require_once(VIEWS_PATH."footer.php");
?>