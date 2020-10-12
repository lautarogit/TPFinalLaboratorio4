<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use Models\Cinema as Cinema;
?>

<main class="d-flex">
     <div class="content d-flex cinema-dashboard-form"> 
          <form action="<?php echo FRONT_ROOT."Cinema/addCinema"?>" method="POST" class="bg-dark-alpha p-5 text-black">
               <h2 style="color:black">Agregar cine</h2>
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

               <button type="submit" name="addCinema" class="btn btn-success btn-block">Agregar cine</button>   
          </form>
     </div>

     <?php   
          $cinema = new Cinema();
          $cinemaDAO = new CinemaDAO($cinema);
          $cinemaList = $cinemaDAO->getAll();
     ?>

     <div class="card-rows">
          <div class="card-columns">
               <?php 
                    foreach($cinemaList as $cinemaValue) 
                    {
               ?>
                         <div class="card w-15 card-box-shadow">
                              <div class="card-header text-white background-linear-gradient">
                                   <h3 class="card-title" style="display:inline;"><?php echo $cinemaValue->getName();?></h3>
                                   <form method="POST" action="<?php echo FRONT_ROOT."Cinema/deleteCinema"?>" style="float:right; display:inline"> 
                                        <button value="<?php echo $cinemaValue->getId(); ?>" name="id" class="btn btn-danger btn-sm" >Eliminar</button>
                                   </form>
                              </div>

                              <div class="card-body">
                                   <p class="card-text"><?php echo "<strong>Localidad: </strong>".$cinemaValue->getLocation();?></p>
                                   <p class="card-text"><?php echo "<strong>Capacidad: </strong>".$cinemaValue->getCapacity();?></p>
                              </div>

                              <div>
                                   <a class="btn btn-sm btn-outline-primary btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">Ver catalogo</a>
                              </div>
                         </div>
               <?php
                    } 
               ?> 
          </div>
     </div> 
</main>
