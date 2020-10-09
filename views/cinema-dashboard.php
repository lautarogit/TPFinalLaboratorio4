<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use Models\Cinema as Cinema;
?>

<main class="d-flex align-items-center height-100">
     <div class="content"> 
          <form action="<?php echo FRONT_ROOT."Cinema/addCinema"?>" method="POST" class="login-form bg-dark-alpha p-5 text-white">
          <h2>Agregar cine</h2>
               <div class="form-group">
                    <label for="name"><h5>Nombre</h5></label>
                    <input class="form-control form-control-lg" type="text" name="name" placeholder="Ingresar nombre"/>
               </div>

               <div class="form-group">
                    <label for="location"><h5>Localidad</h5></label>
                    <input class="form-control form-control-lg" type="text" name="location" placeholder="Ingresar localidad"/>
               </div>

               <div class="form-group">
                    <label for="capacity"><h5>Capacidad</h5></label>
                    <input class="form-control form-control-lg" type="text" name="capacity" placeholder="Ingresar capacidad"/>
               </div>

               <button type="submit" name="send" class="btn btn-success btn-block">Agregar cine</button>
          </form>
     </div>
     
     <?php   
                $cinema = new Cinema();
                $cinemaDAO = new CinemaDAO($cinema);
                $cinemaList = $cinemaDAO->getAll();

                foreach($cinemaList as $cinemaValue) 
                { 
     ?>
                    <div class="card w-15">
                         <div class="card-header" style="background-color:cornflowerblue">
                              <h3 class="card-title"><?php echo $cinemaValue->getName();?></h3> 
                         </div>

                         <div class="card-body">
                              <p class="card-text"><?php echo "<strong>Localidad: </strong>".$cinemaValue->getLocation();?></p>
                              <p class="card-text"><?php echo "<strong>Capacidad: </strong>".$cinemaValue->getCapacity();?></p>
                         </div>

                         <div>
                              <a class="btn btn-sm btn-outline-primary btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">Ver catalogo</a>
                         </div>
                    </div>
                    
     <?php     } 
     ?> 
</main>


