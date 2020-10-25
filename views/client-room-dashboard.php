<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAOJSON as CinemaDAOJSON;
     use Models\Cinema as Cinema;
     use DAO\RoomDAOJSON as RoomDAOJSON;
     use Models\Room as Room;

     $idCinema = $_SESSION['idCinema'];
     $rolId = $_SESSION['loggedUser']->getRolId();
     $cinemaDAO = new CinemaDAOJSON();
     $cinema = new Cinema();
     $roomDAO = new RoomDAOJSON();
     $room = new Room();

     $cinema = $cinemaDAO->getCinemaById($idCinema);
     $roomsId = $cinema->getRoomsId();
     $roomList = array();

     if($roomsId !=null)
     {
          foreach($roomsId as $idRoom)
          {  
               $room = $roomDAO->getRoomById($idRoom);
               array_push($roomList, $room);
          }
     }

     if($roomList != null)
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
                                        <td><?php echo $roomValue->getType();?></td>
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