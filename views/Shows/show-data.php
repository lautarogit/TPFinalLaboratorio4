<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");

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

<div class="m-3 text-white show-box" style="width: 550px;">
    <h4 class="m-3" style="display: inline;">Mostrando show de la sala <strong style="color: red"><?php echo $show->getRoom()->getName();?></strong></h4>

    <br><br>

    <div class="text-center">
        <p>
            <h3><?php echo "<strong>Película: </strong>".$show->getMovie()->getTitle();?></h3>
        </p>
        <img style="width: 380px; height: 510px;" src='<?= TMDB_IMG_PATH.$show->getMovie()->getPosterPath(); ?>'/>
    </div>

    <h5 class="m-2">
        <i class="fa fa-calendar" style="color: chartreuse;"></i><?php echo "  ".substr($show->getDateTime(), 0, 10);?>
    </h5>

    <h5 class="m-2">
        <i class="fa fa-clock" style="color: cadetblue;"></i><?php echo "  ".substr($show->getDateTime(), 11);?>
    </h5>
    
    <h5 class="m-2">
        <i class="fa fa-ticket-alt" style="color: burlywood;"></i><?php echo "  ".$show->getRemainingTickets();?><strong> Tickets restantes </strong>
    </h5>
</div>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary" type="submit" name="idCinema" value="<?= $show->getRoom()->getIdCinema();?>">
        Volver
    </button>
</form>

<?php 
    require_once(VIEWS_PATH."footer.php");
?>