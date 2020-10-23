<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\CinemaDAO as CinemaDAO;
     use Models\Cinema as Cinema;
     use DAO\RoomDAO as RoomDAO;
     use Models\Room as Room;

     $idCinema = $_SESSION['idCinema'];
     $rolId = $_SESSION['loggedUser']->getRolId();
     $cinemaDAO = new CinemaDAO();
     $cinema = new Cinema();
     $roomDAO = new RoomDAO();
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
                                   <td>
                                        <form style="float:right; display: inline" method="POST" action=""> 
                                             <button class="btn btn-danger btn-sm" value="<?php echo $roomValue->getId(); ?>" name="id">Eliminar</button>
                                        </form>
                                   </td>
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
               <h2 class="text-white">No hay salas disponibles</h2>
          <?php 
     }
?>

<a class="btn btn-primary" role="button" href="
<?php 
    if($rolId == 0)
    {
        echo FRONT_ROOT."Home/showClientCinemaDashboard";
    }

    if($rolId == 1)
    {
        echo FRONT_ROOT."Home/showCinemaDashboard";
    }
?>">Volver</a>

<?php 
     require_once("footer.php");
?>