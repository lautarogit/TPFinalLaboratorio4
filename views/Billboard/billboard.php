<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");

    use Models\Show as Show;
    use Models\Room as Room;
    use Models\Movie as Movie;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\MovieDAOJSON as MovieDAOJSON;
    use DAO\ShowDAO as ShowDAO;

    $cinemaDAO = new CinemaDAO();
    $roomDAO = new RoomDAO();
    $movieDAO = new MovieDAOJSON();
    $showDAO = new ShowDAO();
    $showList = array();
    $showMapoutList = $showDAO->getAll();

    foreach($showMapoutList as $showMapout)
    {
        $show = new Show();
        $room = new Room();
        $movie = new Movie();

        $show->setId($showMapout->getId());
        $room = $roomDAO->getRoomByID($showMapout->getIdRoom());
        $show->setRoom($room);
        $movie = $movieDAO->getMovieById($showMapout->getIdMovie());
        $show->setMovie($movie);
        $show->setDateTime($showMapout->getDateTime());
        $show->setRemainingTickets($showMapout->getRemainingTickets());

        array_push($showList, $show);
    }

    $cinemaList = $cinemaDAO->getAll();
?>

<div class="btn-toolbar m-2 position-relative" style="left: 400px; top: 47px;" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <?php   
            foreach($showList as $show)
            { 
        ?>
                <button class="btn btn-dark" style="color: crimson; border-radius: 20px 20px 0px 0px;" type="button"><?= "dayName ";?></button>
        <?php
            }
        ?>
    </div>
</div>

<main class="d-flex m-2">
    <div class="card-columns">
        <div class="card w-15 background-dark text-white text-center" style="width: 364px;">
            <div class="card-header movie-header-color">
                <h3 class="card-title" style="text-align:center;"><?= $movie->getTitle();?></h3> 
            </div>

            <div class="card-header" style="display:block; margin:auto;">
                <img style="width: 300px; height: 400px;" src='<?= TMDB_IMG_PATH.$movie->getPosterPath(); ?>'/>
            </div>

            <div class="card-body">
                <p class="card-text"><?= $movie->getOverview();?></p>       
            </div>

            <div class="modal-footer">
                <div style="display:block; margin:auto;">
                    <?php 
                        $genresId = $movie->getGenresId();
                        $genreNameList = array();

                        foreach($genresId as $genreId)
                        {
                            foreach($genreList as $genre)
                            {
                                if($genreId == $genre->getId())
                                {
                                    $genreName = $genre->getName();
                                    array_push($genreNameList, $genreName);
                                } 
                            }     
                        }   
                    ?>
                                    
                    <p><?php 
                        echo "<strong>Géneros: </strong>"; 

                        $genreNameListDimension = count($genreNameList);
                        $i = 0;
                                            
                        foreach($genreNameList as $genreName)
                        {
                            $i ++;

                            if($i == $genreNameListDimension)
                            {  
                                echo $genreName;
                            }
                            else
                            {
                                echo $genreName.", ";
                            } 
                        }
                    ?></p>

                    <p><?= "<strong>Fecha de lanzamiento: </strong>".$movie->getReleaseDate();?></p>
                </div>
            </div> 
        </div>
    </div>
</main>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Movie/showMovieDashboard";?>">Volver</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>