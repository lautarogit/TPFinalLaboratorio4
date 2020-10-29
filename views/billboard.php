<?php
    require_once("header.php");
    require_once("nav.php");
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
                <p class="card-text">
                    <?php 
                        $movieOverview = $movie->getOverview(); 
                        $movieOverviewLength = strlen($movieOverview);
                        $overviewMaxCharacters = 150;
                        $limitedMovieOverview = substr($movieOverview, 0, $overviewMaxCharacters);

                        if($movieOverviewLength < $overviewMaxCharacters)
                        {
                            echo $movieOverview;
                        }
                        else
                        {
                            echo $limitedMovieOverview;?><a class="color-red" data-toggle="modal" data-target="<?= "#movieInfo".$movie->getId();?>">(...)</a>
                    <?php 
                        }   
                    ?></p>       
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
        
        <div class="btn-toolbar" style="display: inline;" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="First group">
                <?php   
                    for($i = 0; $i < 7; $i++)
                    { 
                ?>
                        <button class="btn btn-dark" style="color: crimson; border-radius: 20px 20px 0px 0px;" type="button"><?= "dayName ".($i+1);?></button>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</main>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Movie/showMovieDashboard";?>">Volver</a>

<?php
    require_once("footer.php");
?>