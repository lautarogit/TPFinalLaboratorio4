<?php 
     require_once("header.php"); 
     require_once("nav.php");

  

     use DAO\CinemaDAO as CinemaDAO;

     $cinemaDAO = new CinemaDAO();
     $cinemaList = $cinemaDAO->getAll();

?>

<main class="d-flex m-2">
     <div class="card-rows">
          <div class="card-columns">
               <div class="card w-15 card-box-shadow">
                    <button class="btn btn-outline-dark background-dark text-white" style="width: 619px; height: 225px;" data-toggle="modal" data-target="#addCinema">
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
                                                  <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre" required>
                                             </div>

                                             <div class="form-group">
                                                  <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                  <input class="form-control form-control-lg" type="text" name="location" placeholder="Ingresar localidad" required>
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
                    foreach($cinemaList as $cinemaValue) 
                    {
               ?>
                         <div class="card w-15 card-box-shadow text-white background-dark">
                              <div class="card-header text-white background-linear-gradient">
                                   <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>

                                   <form style="float:right; display: inline" method="POST" action="<?php echo FRONT_ROOT."Cinema/deleteCinema"?>"> 
                                        <button class="btn btn-danger btn-sm" value="<?php echo $cinemaValue->getId(); ?>" name="id">
                                             <i class="fas fa-trash"></i>
                                        </button>
                                   </form>

                                   <div style="float:right; display: inline"> 
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?php echo "#editCinema".$cinemaValue->getId();?>">
                                             <i class="fas fa-cogs"></i>
                                        </button>
                                   </div>
                                   
                                   <div style="float:right; display: inline"> 
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="<?php echo "#addRoom".$cinemaValue->getId();?>">
                                             Agregar sala
                                        </button>
                                   </div>
                              </div>

                              <div class="card-body">
                                   <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>
                                   <?php 
                                        if($cinemaValue->getRoomsId() != null)
                                        {
                                             $roomsQuantity = count($cinemaValue->getRoomsId());
                                        }
                                        else
                                        {
                                             $roomsQuantity = 0;
                                        }  
                                   ?>
                                   <p class="card-text">
                                   <?php echo "<strong>N° de Salas disponibles: </strong>".$roomsQuantity;?></p>
                              </div>

                              <a class="btn btn-sm btn-outline-info background-dark btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">
                                   <i class="fas fa-film"></i> Ver catalogo
                              </a>

                              <form method="POST" action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>"> 
                                   <button class="btn btn-sm btn-outline-success background-dark btn-block" value="<?php echo $cinemaValue->getId();?>" name="idCinema">
                                        <i class="fas fa-eye"></i> Ver salas
                                   </button>
                              </form>
                         </div>

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
                                                            <input class="form-control form-control-lg" type="number" name="id" value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="name"><h5><strong>Nombre</strong> (3-40 caracteres)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="name" value="<?php echo $cinemaValue->getName();?>" placeholder="Ingresar nombre" required>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="location" value="<?php echo $cinemaValue->getLocation();?>" placeholder="Ingresar localidad" required>
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
                                                            <input class="form-control form-control-lg" type="number" name="idCinema" value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="name"><h5><strong>Capacidad</strong> (3-40 caracteres)</h5></label>
                                                            <input class="form-control form-control-lg" type="number" name="capacity" placeholder="Ingresar capacidad" required>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="location"><h5 style="display: inline;"><strong>Tipo de sala</strong></h5></label>
                                                            <input class="radioSize" type="radio" name="type" value="Atmos"  required>Atmos
                                                            <input class="radioSize" type="radio" name="type" value="2D"  required>2D
                                                            <input class="radioSize" type="radio" name="type" value="3D"  required>3D
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="capacity"><h5><strong>Nombre</strong> (2-4 dígitos)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre" required>
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
          </div>
     </div> 
</main>

<?php 
     require_once("footer.php");
?>