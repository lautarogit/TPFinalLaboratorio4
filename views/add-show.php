<?php 
    require_once("header.php");
    require_once("nav.php");

    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAOJSON as MovieDAOJSON;
    use DAO\GenreDAOJSON as GenreDAOJSON;

    $movieDAO = new MovieDAOJSON();
    $genreDAO = new GenreDAOJSON();
    $movieList = $movieDAO->getAll();
    $genreList = $genreDAO->getAll();
    $movieSelected = false;

    #$movie = new Movie;
    #$movie = $movieDAO->getMovieById(528085);  #período de prueba, elijo una sola película manualmente
?>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary" type="submit" name="idCinema" value="<?= $room->getIdCinema();?>">
        Volver
    </button>
</form>

<div class="content d-flex m-2" style="justify-content: center;"> 
    <form class="bg-dark-alpha p-5 text-white" action="<?php echo FRONT_ROOT."Show/addShow";?>" method="POST">
        <div class="form-group">
            <label for="idRoom">ID de Sala (No editable)</label>
            <input type="text" name="idRoom" value="<?= $room->getId();?>" readonly/>
        </div>

        <h4 class="m-2">Elija una película: </h4>

        <div class="grid">
            <?php 
                    if(!empty($movieList))
                    {
                        foreach($movieList as $movieValue)
                        {  
            ?>
                        <div class="card w-15 m-2 background-dark text-white text-center" style="width: 364px;">
                            <div class="card-header movie-header-color">
                                <h3 class="card-title" style="text-align:center;"><?= $movieValue->getTitle();?></h3> 
                            </div>

                            <div class="card-header" style="display:block; margin:auto;">
                                <img style="width: 300px; height: 400px;" src='<?= TMDB_IMG_PATH.$movieValue->getPosterPath(); ?>'/>
                            </div>

                            <div class="card-body">
                                <p class="card-text">
                                    <?php 
                                        $movieOverview = $movieValue->getOverview(); 
                                        $movieOverviewLength = strlen($movieOverview);
                                        $overviewMaxCharacters = 150;
                                        $limitedMovieOverview = substr($movieOverview, 0, $overviewMaxCharacters);

                                        if($movieOverviewLength < $overviewMaxCharacters)
                                        {
                                            echo $movieOverview;
                                        }
                                        else
                                        {
                                            echo $limitedMovieOverview;?><a class="color-red" data-toggle="modal" data-target="<?= "#movieInfo".$movieValue->getId();?>">(...)</a>
                                    <?php 
                                        }   
                                    ?></p>       
                            </div>

                            <div class="modal-footer">
                                <div style="display:block; margin:auto;">
                                    <?php 
                                        $genresId = $movieValue->getGenresId();
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

                                    <p><?= "<strong>Fecha de lanzamiento: </strong>".$movieValue->getReleaseDate();?></p>
                                </div>
                            </div> 

                            <input class="radioSize" type="radio" name="idMovie" value="<?= $movieValue->getId();?>">Seleccionar
                        </div>
            <?php
                        } 
                    }
                    else
                    {

                    } 
            ?>
        </div>

        <div class="form-group">
            <label for="dateTime">Fecha del show</label>
            <input type="date" name="dateTime">
        </div>

        <div class="form-group">
            <label for="remainingTickets">Cantidad de tickets</label>
            <input type="text" name="remainingTickets">
        </div>
        
        <button class="btn btn-success btn-lg text-center" type="submit">Confirmar</button>
    </form> 
</div>

<?php 
    require_once("footer.php");
?>