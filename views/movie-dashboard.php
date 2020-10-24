<?php 
    require_once("header.php"); 
    require_once("nav.php");

    $rolId = $_SESSION['loggedUser']->getRolId();
    use Controllers\MovieController as MovieController;

    $movieController = new MovieController();
    $topRatedMovieList = $movieController->filterTopRated($movieList);
?>

<div class="m-2 movie-buttons-div">
    <a class="btn btn-light m-1" style="display: inline; border-radius: 2px 2px 2px 10px;" role="button" href="
    <?php 
        if($rolId == 0)
        {
            echo FRONT_ROOT."Cinema/showClientCinemaDashboard";
        }

        if($rolId == 1)
        {
            echo FRONT_ROOT."Cinema/showCinemaDashboard";
        }
    ?>">Volver</a>

    <form action="<?= FRONT_ROOT."Movie/showMovieDashboard"?>" style="display: inline;" method="POST">
        <button class="btn btn-secondary m-1" type="submit">
            Restaurar filtro
        </button>
    </form>

    <div class="dropdown" style="display: inline;">
        <button class="btn btn-dark dropdown-toggle m-1" style="color: crimson; border-radius: 2px 2px 10px 2px;" type="button" id="genreFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrar por género
        </button>
        <div class="dropdown-menu background-dark" aria-labelledby="dropdownMenuButton">
            <?php 
                foreach($genreList as $genre)
                {
            ?>
                    <form action="<?= FRONT_ROOT."Movie/filterByGenre"?>" method="POST">
                        <button class="dropdown-item btn btn-dark" style="color: crimson; border-radius: 15px 15px 15px 15px;" type="submit" name="paramGenreId" value="<?= $genre->getId();?>">
                            <?= $genre->getName();?>
                        </button>
                    </form> 
            <?php   
                }
            ?>
        </div>
    </div>
</div>

<div class="container text-center" style="width: 100%; height: 100px;">
    <h1 class="text-crimson text-shadow">Top 5 películas mas populares</h1>
</div>

<!-- Carousel of Top 5 rated movies -->
<div class="container" style="width: 500px; height: 750px;">
    <div id="carouselIndicator" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselIndicator" data-slide-to="0" class="active"></li>
            <li data-target="#carouselIndicator" data-slide-to="1"></li>
            <li data-target="#carouselIndicator" data-slide-to="2"></li>
            <li data-target="#carouselIndicator" data-slide-to="3"></li>
            <li data-target="#carouselIndicator" data-slide-to="4"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src='<?= TMDB_IMG_PATH.$topRatedMovieList[0]->getPosterPath(); ?>' alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-info text-shadow"><?= "<strong>Top 1 - </strong>".$topRatedMovieList[0]->getTitle(); ?></h2>
                </div>
            </div>

            <div class="carousel-item">
                <img class="w-100" src='<?= TMDB_IMG_PATH.$topRatedMovieList[1]->getPosterPath(); ?>' alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-info text-shadow"><?= "<strong>Top 2 - </strong>".$topRatedMovieList[1]->getTitle(); ?></h2>
                </div>
            </div>

            <div class="carousel-item">
                <img class="w-100" src='<?= TMDB_IMG_PATH.$topRatedMovieList[2]->getPosterPath(); ?>' alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-info text-shadow"><?= "<strong>Top 3 - </strong>".$topRatedMovieList[2]->getTitle(); ?></h2>
                </div>
            </div>

            <div class="carousel-item">
                <img class="w-100" src='<?= TMDB_IMG_PATH.$topRatedMovieList[3]->getPosterPath(); ?>' alt="Fourth slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-info text-shadow"><?= "<strong>Top 4 - </strong>".$topRatedMovieList[3]->getTitle(); ?></h2>
                </div>
            </div>

            <div class="carousel-item">
                <img class="w-100" src='<?= TMDB_IMG_PATH.$topRatedMovieList[4]->getPosterPath(); ?>' alt="Fifth slide">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="text-info text-shadow"><?= "<strong>Top 5 - </strong>".$topRatedMovieList[4]->getTitle(); ?></h2>
                </div>
            </div>
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
    ?>
        <?php   
            foreach($movieList as $movieValue)
            {  
        ?>
                <div class="card w-15 m-2 background-dark text-white text-center" style="width: 364px;">
                    <div class="card-header" style="background: crimson;">
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

                    <div class="modal-footer">
                        <button class="btn btn-sm btn-outline-success background-dark btn-block" data-toggle="modal" data-target="<?= "#buyTicket";?>">
                            Comprar entrada
                        </button>
                    </div>
                </div>                              

                <!-- Buy ticket Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="buyTicket">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content background-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title">Ticket</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="content d-flex d-center" style="justify-content: center;"> 
                                    <h4>Sala 8</h4>
                                    <h3>ADULTO  $63.00</h3>
                                    <h2>TITULO PELICULA</h2>
                                    <p>Funcion: 30/12/2011 07:00 pm Asiento E-8</p>
                                    <p>Usuario: lautarolp27</p>
                                    <form class="bg-dark-alpha p-5 text-black" action="" method="POST">
                                        <button type="submit" class="btn btn-success">
                                            Comprar entrada
                                        </button>   
                                    </form>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ---------------- -->
                
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

                            <div class="modal-body" style="background-color: crimson">
                                <div class="content d-flex d-center"> 
                                    <h2 style="text-align:center;"><?= $movieValue->getTitle();?></h2>
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
        ?> 
    </div>
</main>

<div class="m-2 movie-buttons-div">
    <a class="btn btn-light m-1" style="display: inline; border-radius: 2px 2px 2px 10px;" role="button" href="
    <?php 
        if($rolId == 0)
        {
            echo FRONT_ROOT."Cinema/showClientCinemaDashboard";
        }

        if($rolId == 1)
        {
            echo FRONT_ROOT."Cinema/showCinemaDashboard";
        }
    ?>">Volver</a>

    <form action="<?= FRONT_ROOT."Movie/showMovieDashboard"?>" style="display: inline;" method="POST">
        <button class="btn btn-secondary m-1" type="submit">
            Restaurar filtro
        </button>
    </form>

    <div class="dropup" style="display: inline;">
        <button class="btn btn-dark dropdown-toggle m-1" style="color: crimson; border-radius: 2px 2px 10px 2px;" type="button" id="genreFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filtrar por género
        </button>
        <div class="dropdown-menu background-dark" aria-labelledby="dropdownMenuButton">
            <?php 
                foreach($genreList as $genre)
                {
            ?>
                    <form action="<?= FRONT_ROOT."Movie/filterByGenre"?>" method="POST">
                        <button class="dropdown-item btn btn-dark" style="color: crimson; border-radius: 15px 15px 15px 15px;" type="submit" name="paramGenreId" value="<?= $genre->getId();?>">
                            <?= $genre->getName();?>
                        </button>
                    </form> 
            <?php   
                }
            ?>
        </div>
    </div>
</div>

<?php 
     require_once("footer.php");
?>