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

     if(!empty($roomList))
     {
?>
          <main class="py-3 text-white">
               <section>
                    <div class="container">
                         <h2 class="mb-4">Salas de <?php echo $cinema->getName();?></h2>
                         <table class="table bg-dark text-white">
                              <thead>
                                   <th>Nombre de sala</th>
                                   <th>Tipo de sala</th>
                                   <th>Capacidad</th>
                              </thead>
                              
                              <tbody>
                              <?php 
                                   foreach($roomList as $roomValue) 
                                   {
                              ?>
                                        <tr>
                                             <td><?php echo $roomValue->getName();?></td>
                                             <td><?php echo $roomValue->getPrice();?></td>
                                             <td><?php echo $roomValue->getCapacity();?></td>
                                        </tr>       
                              <?php 
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

<a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Cinema/showClientCinemaDashboard";?>">
     Volver
</a>

<?php 
     require_once("footer.php");
?>