<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");  
    
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
?>
    
<div class="btn-toolbar m-2 position-relative" style="left: 400px; top: 80px;" role="toolbar">
    <div class="btn-group mr-2" role="group">
        <?php   
            $i = 0;
            $cinemaListSize = count($cinemaList);

            foreach($showList as $show)
            {
                if($i < $cinemaListSize)
                { 
                    $idCinema = $cinemaList[$i]->getId();
                    $showIdCinema = $show->getRoom()->getIdCinema();

                    if($idCinema == $showIdCinema)
                    { 
                        
                        
        ?>
                        <button class="btn btn-dark" style="color: chocolate; border-radius: 20px 20px 0px 0px;" type="button" 
                        data-toggle="collapse" data-target="<?= "#cinemaCollapseId".$showIdCinema;?>">
                            <?= substr($show->getDateTime(), 0, 10);?>
                        </button>
        <?php    
                        $i++;
                    }    
                }  
            }
        ?>
    </div>
</div>

<?php   
        $idMovie = $movie->getId();

        foreach($showList as $show)
        {
            $idCinema = $show->getRoom()->getIdCinema();
            $cinema = new Cinema();
            $cinemaDAO = new CinemaDAO();
            $cinema = $cinemaDAO->getCinemaById($idCinema);  
?>
                <div class="card card-box-shadow collapse text-white background-dark d-relative" style="width: 400px; left: 405px; top: 73px;" id="<?= "cinemaCollapseId".$idCinema;?>">
                    <div class="card-header text-white background-linear-gradient">
                        <h3 class="card-title" style="display: inline;"><?php echo $cinema->getName();?></h3>
                    </div>

                    <div class="card-body">
                        <p class="card-text">
                            <?php echo "<strong>Estado: </strong>";?><i class="fas fa-check-circle" style="color: green;"></i>
                        </p>

                        <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinema->getLocation();?></p> 
                    </div>  

                    <div class="card-footer">
                        <div class="card-rows">
                            <div class="card-columns">
                                <button class="btn btn-warning" type="button">
                                    xx:xx hs
                                </button>
                            </div>
                        </div>
                    </div> 
                </div>
<?php     
        }       
?>

<div class="card w-15 background-dark text-white text-center m-2" style="width: 364px;">
    <div class="card-header movie-header-color">
        <h3 class="card-title" style="text-align:center;"><?= $movie->getTitle();?></h3> 
    </div>

    <div class="card-header" style="display:block; margin:auto;">
        <img style="width: 300px; height: 400px;" src='<?= TMDB_IMG_PATH.$movie->getPosterPath(); ?>'/>
    </div>

    <div class="card-body">
        <p class="card-text"><?= $movie->getOverview();?></p>       
    </div>

    <div class="card-footer">
        <div style="display:block; margin:auto;">                     
        <?php 
            $genres = $genreDAO->getGenres($movie);
                        
        ?>

        <p>
            <?php 
                echo "<strong>Géneros: </strong>"; 

                $genresDimension = count($genres);
                $i = 0;
                                
                foreach($genres as $genre)
                {
                    $i ++;

                    if($i == $genresDimension)
                    {  
                        echo $genre->getName();
                    }
                    else
                    {
                        echo $genre->getName().", ";
                    } 
                }
            ?>
        </p>

            <p><?= "<strong>Fecha de lanzamiento: </strong>".substr($movie->getReleaseDate(), 0, 10);?></p>
        </div>
    </div> 
</div>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Movie/showMovieDashboard";?>">
    Volver
</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>

