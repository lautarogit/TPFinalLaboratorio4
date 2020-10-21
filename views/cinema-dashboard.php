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
                    <button class="btn btn-outline-dark background-dark text-white" style="width: 619px; height: 232px;" data-toggle="modal" data-target="#addCinema">Agregar cine</button>
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
                                                  <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre"/>
                                             </div>

                                             <div class="form-group">
                                                  <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                  <input class="form-control form-control-lg" type="text" name="location" placeholder="Ingresar localidad"/>
                                             </div>

                                             <div class="form-group">
                                                  <label for="capacity"><h5><strong>Capacidad</strong> (2-4 dígitos)</h5></label>
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
                         <div class="card w-15 card-box-shadow text-white background-dark">
                              <div class="card-header text-white background-linear-gradient">
                                   <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>

                                   <form style="float:right; display: inline" method="POST" action="<?php echo FRONT_ROOT."Cinema/deleteCinema"?>"> 
                                        <button class="btn btn-danger btn-sm" value="<?php echo $cinemaValue->getId(); ?>" name="id">Eliminar</button>
                                   </form>

                                   <div style="float:right; display: inline"> 
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="<?php echo "#editCinema".$cinemaValue->getId();?>">Editar</button>
                                   </div>
                              </div>

                              <div class="card-body">
                                   <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>
                                   <p class="card-text"><?php echo "<strong>Capacidad: </strong>".$cinemaValue->getCapacity();?></p>
                              </div>

                              <a class="btn btn-sm btn-outline-info background-dark btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">Ver catalogo</a>
                              <button class="btn btn-sm btn-outline-success background-dark btn-block" data-toggle="modal" data-target="<?php echo "";//"#buyTicket".$cinemaValue->getTicket()->getId();?>"><?php echo "Comprar entrada: $";//$cinemaValue->getCapacity();?></button>
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
                                                            <label for="id"><h5><strong>Id</strong> (No editable)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="id" value="<?php echo $cinemaValue->getId();?>" readonly/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="name"><h5><strong>Nombre</strong> (3-40 caracteres)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="name" value="<?php echo $cinemaValue->getName();?>" placeholder="Ingresar nombre"/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="location"><h5><strong>Dirección</strong> (3-40 caracteres)</h5></label>
                                                            <input class="form-control form-control-lg" type="text" name="location" value="<?php echo $cinemaValue->getLocation();?>" placeholder="Ingresar localidad"/>
                                                       </div>

                                                       <div class="form-group">
                                                            <label for="capacity"><h5><strong>Capacidad</strong> (2-4 dígitos)</h5></label>
                                                            <input class="form-control form-control-lg" type="number" name="capacity" value="<?php echo $cinemaValue->getCapacity();?>" placeholder="Ingresar capacidad"/>
                                                       </div>

                                                       <button type="submit" name="addCinema" class="btn btn-warning">Confirmar cambios</button>
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