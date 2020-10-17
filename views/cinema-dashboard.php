<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use Models\Cinema as Cinema;
?>

<main class="d-flex m-2">
     <?php   
          $cinema = new Cinema();
          $cinemaDAO = new CinemaDAO($cinema);
          $cinemaList = $cinemaDAO->getAll();
     ?>

     <div class="card-rows">
          <div class="card-columns">
               <div class="card w-15 card-box-shadow">
                    <button class="btn btn-outline-primary" style="width: 619px; height: 193px;" data-toggle="modal" data-target="#addCinema">Agregar cine</button>
               </div>

               <!-- Add cinema Modal -->
               <div class="modal fade" tabindex="-1" role="dialog" id="addCinema">
                    <div class="modal-dialog" role="document">
                         <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title">Agregar cine</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <div class="modal-body">
                                   <div class="content d-flex" style="justify-content: center;"> 
                                        <form action="<?php echo FRONT_ROOT."Cinema/addCinema"?>" method="POST" class="bg-dark-alpha p-5 text-black">
                                             <div class="form-group">
                                                  <label for="name"><h5 class="color-blue">Nombre</h5></label>
                                                  <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre"/>
                                             </div>

                                             <div class="form-group">
                                                  <label for="location"><h5 class="color-blue">Localidad</h5></label>
                                                  <input class="form-control form-control-lg" type="text" name="location" placeholder="Ingresar localidad"/>
                                             </div>

                                             <div class="form-group">
                                                  <label for="capacity"><h5 class="color-blue">Capacidad</h5></label>
                                                  <input class="form-control form-control-lg" type="number" name="capacity" placeholder="Ingresar capacidad"/>
                                             </div>

                                             <button type="submit" name="addCinema" class="btn btn-success">Agregar cine</button>   
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
                         <div class="card w-15 card-box-shadow">
                              <div class="card-header text-white background-linear-gradient">
                                   <h3 class="card-title" style="display:inline;"><?php echo $cinemaValue->getName();?></h3>

                                   <form method="POST" action="<?php echo FRONT_ROOT."Cinema/deleteCinema"?>" style="float:right; display:inline"> 
                                        <button value="<?php echo $cinemaValue->getId(); ?>" name="id" class="btn btn-danger btn-sm">Eliminar</button>
                                   </form>

                                   <div style="float:right; display:inline"> 
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?php echo "#editCinema".$cinemaValue->getId();?>">Editar</button>
                                   </div>
                              </div>

                              <div class="card-body">
                                   <p class="card-text"><?php echo "<strong>Localidad: </strong>".$cinemaValue->getLocation();?></p>
                                   <p class="card-text"><?php echo "<strong>Capacidad: </strong>".$cinemaValue->getCapacity();?></p>
                              </div>

                              <div>
                                   <a class="btn btn-sm btn-outline-primary btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">Ver catalogo</a>
                              </div>
                         </div>

                         <!-- Edit cinema Modal -->
                         <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo "editCinema".$cinemaValue->getId();?>">
                              <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Editar cine</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                             <div class="content d-flex d-center" style="justify-content: center;"> 
                                                  <form action="<?php echo FRONT_ROOT."Cinema/editCinema"?>" method="POST" class="bg-dark-alpha p-5 text-black">
                                                       <div class="form-group">
                                                            <label for="id"><h5 class="text-black">Id (No editable)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="id" value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="name"><h5 class="color-blue">Nombre</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="name" value="<?php echo $cinemaValue->getName();?>" placeholder="Ingresar nombre"/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="location"><h5 class="color-blue">Localidad</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="location" value="<?php echo $cinemaValue->getLocation();?>" placeholder="Ingresar localidad"/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="capacity"><h5 class="color-blue">Capacidad</h5></label>
                                                            <input class="form-control form-control-lg" type="number" name="capacity" value="<?php echo $cinemaValue->getCapacity();?>" placeholder="Ingresar capacidad"/>
                                                       </div>

                                                       <button type="submit" name="addCinema" class="btn btn-warning">Confirmar cambios</button>   
                                                  </form>
                                             </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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