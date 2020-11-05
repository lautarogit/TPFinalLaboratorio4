<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");   
?>

<div class="btn-toolbar m-2 position-relative" style="left: 400px; top: 47px;" role="toolbar">
    <div class="btn-group mr-2" role="group">
        <?php   
            $i = 0;

            foreach($cinemaList as $cinemaValue)
            {
                if($i < count($showList))
                { 
                    $idCinema = $cinemaValue->getId();
                    $showIdCinema = $showList[$i]->getRoom()->getIdCinema();
                    
                    if($idCinema == $showIdCinema)
                    { 
                        
        ?>
                        <button class="btn btn-dark" style="color: chocolate; border-radius: 20px 20px 0px 0px;" type="button" data-toggle="collapse" data-target="<?= "#cinemaCollapseId".$showIdCinema;?>">
                            <?= substr($showList[$i]->getDateTime(), 0, 10);?>
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
    $i = 0;

    foreach($cinemaList as $cinemaValue)
    {
        $idCinema = $cinemaValue->getId();

        if($i < count($showList))
        {
            $showIdCinema = $showList[$i]->getRoom()->getIdCinema();

            if($idCinema == $showIdCinema)
            {    
?>
                <div class="card card-box-shadow collapse text-white background-dark d-relative" style="width: 400px; left: 406px; top: 173px;" id="<?= "cinemaCollapseId".$showIdCinema;?>">
                    <div class="card-header text-white background-linear-gradient">
                        <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>
                    </div>

                    <div class="card-body">
                        <p class="card-text">
                            <?php echo "<strong>Estado: </strong>";?><i class="fas fa-check-circle" style="color: green;"></i>
                        </p>

                        <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p> 
                    </div>                   
                </div>
<?php 
                $i++;
            } 
        }  
    }       
?>

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
    </div>
</main>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Movie/showMovieDashboard";?>">Volver</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>