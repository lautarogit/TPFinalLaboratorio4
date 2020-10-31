<?php 
    require_once("header.php");
    require_once("nav.php");

    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAOJSON as MovieDAOJSON;

    $show = new Show();
    $showDAO = new ShowDAO();
    
    $roomDAO = new RoomDAO();
    
    $movieDAO = new MovieDAOJSON();
    $showMapout = $showDAO->getShowById($idShow);

    $id = $showMapout->getId();
    $idRoom = $showMapout->getIdRoom();
    $room = new Room();
    $room = $roomDAO->getRoomByID($idRoom); 
    $idMovie = $showMapout->getIdMovie();
    $movie = new Movie();
    $movie = $movieDAO->getMovieByID($idMovie);
    $dateTime = $showMapout->getDateTime();
    $remainingTickets = $showMapout->getRemainingTickets();

    $show->setId($id);
    $show->setRoom($room);
    $show->setMovie($movie);
    $show->setDateTime($dateTime);
    $show->setRemainingTickets($remainingTickets);
?>

<h4 class="text-white" style="display: inline;">Mostrando show de la sala <strong><?php echo $show->getRoom()->getName();?></strong></h4>
<br><br>
<div class="text-white">
    <p>
        <?php echo "<strong>ID: </strong>".$show->getId();?>
    </p>

    <p>
        <?php echo "<strong>ID de Sala: </strong>".$show->getRoom()->getId();?>
    </p>

    <p class="card-text">
        <?php echo "<strong>Película: </strong>".$show->getMovie()->getTitle();?>
    </p>

    <p class="card-text">
        <?php echo "<strong>Fecha y hora: </strong>".$show->getDateTime();?>
    </p>

    <p class="card-text">
        <?php echo "<strong>Tickets restantes: </strong>".$show->getRemainingTickets();?>
    </p>
</div>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary" type="submit" name="idCinema" value="<?= $show->getRoom()->getIdCinema();?>">
        Volver
    </button>
</form>

<?php 
    require_once("footer.php");
?>