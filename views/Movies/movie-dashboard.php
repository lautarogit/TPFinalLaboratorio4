<?php 
    require_once(VIEWS_PATH."header.php"); 
    require_once(VIEWS_PATH."nav.php");

    use Controllers\MovieController as MovieController;

    $movieController = new MovieController();

    $filterGenreList = $movieController->returnGenresAvailabe();
    
    if(!isset($_SESSION['loggedUser']))
    {
        $rolId = -1;
    }
?>

<div class="movie-buttons-div">
    <a class="btn btn-light m-1" style="display: inline; border-radius: 2px 2px 2px 10px;" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>">
        Volver
    </a>

    <form action="<?= FRONT_ROOT."Movie/showMovieDashboard"?>" style="display: inline;" method="POST">
        <button class="btn btn-secondary m-1" type="submit">
            Restaurar filtro <i class="fas fa-redo"></i>
        </button>
    </form>
    
    <div class="dropdown" style="display: inline;">
        <button class="btn btn-dark dropdown-toggle m-1" style="color: crimson;" 
        type="button" id="genreFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrar por género
        </button>
        <div class="dropdown-menu background-dark" aria-labelledby="dropdownMenuButton">
            <?php 
                foreach($filterGenreList as $genre)
                {
            ?>
                    <form action="<?= FRONT_ROOT."Movie/filterByGenre"?>" method="POST">
                        <button class="dropdown-item btn btn-dark" style="color: crimson; border-radius: 15px 15px 15px 15px;" 
                        type="submit" name="paramGenreId" value="<?= $genre->getId();?>">
                            <?= $genre->getName();?>
                        </button>
                    </form> 
            <?php   
                }
            ?>
        </div>
    </div>

    <form class="d-inline" action="<?= FRONT_ROOT."Movie/filterByDate"?>" method="POST">
            <input type="date" name="dateTime">
            <button class="btn btn-dark m-1" style="color: crimson; border-radius: 2px 2px 10px 2px;">
                Filtrar por fecha
            </button>
    </form>
</div>

<?php 
    if(!empty($errorMessage))
    {
        if(is_bool($errorMessage))
        {
?>
            <div class="alert alert-warning alert-dismissible m-2" style="width: 500px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                    Debe tener una cuenta para utilizar esta funcionalidad.
                    <a href="<?= FRONT_ROOT."Home/showLoginView";?>"> Inicie sesión</a> para continuar             
                </strong> 
            </div>
<?php   
        }
        elseif(is_string($errorMessage))
        {
?>
            <div class="alert alert-danger alert-dismissible m-2" style="width: 630px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong><?php echo $errorMessage;?></strong>
            </div>
<?php    
        }  
    } 
?>  

<div class="container text-center" style="width: 100%; height: 100px;">
    <h1 class="text-crimson text-shadow">Top 5 películas mas populares</h1>
</div>

<!-- Carousel of Top 5 rated movies -->
<div class="container" style="width: 500px; height: 750px;">
    <div id="carouselIndicator" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
                $i = 0;

                if(!empty($topRatedMovieList))
                {
                    foreach($topRatedMovieList as $movieValue)
                    {
                        if($i == 0)
                        {
            ?>
                            <li data-target="#carouselIndicator" data-slide-to="<?= $i; ?>" class="active"></li>
            <?php
                        }
                        else
                        {
            ?>
                            <li data-target="#carouselIndicator" data-slide-to="<?= $i; ?>"></li>
            <?php
                        }
                        
                        $i++;
                    }
                }
            ?>
        </ol>

        <div class="carousel-inner">
            
            <?php
                $i = 0;
                if(!empty($topRatedMovieList))
                {
                    foreach($topRatedMovieList as $movieValue)
                    {
                        if($i == 0)
                        {
            ?>
                            <div class="carousel-item active">
                                <img class="w-100" src='<?= TMDB_IMG_PATH.$movieValue->getPosterPath(); ?>' alt="<?= $i; ?>">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="text-info text-shadow"><?= "<strong>Top ".($i+1)." -</strong> ".$movieValue->getTitle(); ?></h2>
                                </div>
                            </div>
            <?php
                        }
                        else
                        {
            ?>
                            <div class="carousel-item">
                                <img class="w-100" src='<?= TMDB_IMG_PATH.$movieValue->getPosterPath(); ?>' alt="<?= $i; ?>">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2 class="text-info text-shadow"><?= "<strong>Top ".($i+1)." -</strong> ".$movieValue->getTitle(); ?></h2>
                                </div>
                            </div>
            <?php
                        }
                        
                        $i++;
                    }
                }
            ?>
        </div>

        <a class="carousel-control-prev" href="#carouselIndicator" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>

        <a class="carousel-control-next" href="#carouselIndicator" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>
</div>
<!-- ------------------------------ -->

<main class="d-flex align-items-center height-100">
    <?php 
        if(!empty($movieList))
        {
            if(count($movieList) >= 5)
            {
    ?>
                <div class="grid">
    <?php   
            }
            else if(count($movieList) <= 4)
            {  
    ?>
                <div class="card-columns">
    <?php 
            }
        } 

        if(empty($movieList))
        {
            ?>
                <h2 class="text-white">No hay películas con el filtro ingresado</h2>
            <?php 
        }
        else
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

                    <div class="card-footer">
                        <div style="display:block; margin:auto;">
                            <p>
                                <?php 
                                    $genres = $this->genreDAO->getGenres($movieValue);
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

                            <p><?= "<strong>Fecha de lanzamiento: </strong>".substr($movieValue->getReleaseDate(), 0, 10);?></p>
                            <?php 
                                if(isset($date) && !empty($date))
                                {
                            ?>
                                    <p><strong style="color: crimson">Fecha del show: </strong><?= $date;?></p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    
                        <form action="
                            <?php 
                                if($rolId != -1)
                                {
                                    echo FRONT_ROOT."Billboard/showBillboard";
                                }
                                else
                                {
                                    echo FRONT_ROOT."Movie/actionDisabled";
                                }
                            ?>" 
                            method="POST">
                                <button class="btn btn-sm btn-success m-1" style="width: 354px;" type="submit" name="idMovie" value="<?= $movieValue->getId();?>">
                                    Consultar por entrada
                                </button>   
                        </form>  
                </div>                              
                    
                <!-- Movie info Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="<?= "movieInfo".$movieValue->getId();?>">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content background-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title">Información de película</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body movie-header-color">
                                <div class="content d-flex d-center"> 
                                    <h2><?= $movieValue->getTitle();?></h2>
                                </div>
                            </div>

                            <div class="modal-header" style="display:block; margin:auto;">
                                <img style="width: 400px; height: 550px;" src='<?= TMDB_IMG_PATH.$movieValue->getPosterPath() ?>'/>
                            </div>

                            <div class="modal-footer">
                                <p><?= $movieValue->getOverview();?></p>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ----------------- -->
    <?php       
            } 
        }
    ?>
    </div>
</main>

<?php 
    require_once(VIEWS_PATH."footer.php");
?>