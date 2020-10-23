<?php 
    require_once("header.php"); 
    require_once("nav.php");

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;

    $rolId = $_SESSION['loggedUser']->getRolId();

    $movieDAO = new MovieDAO();
    $genreDAO = new GenreDAO();
    $movieList = $movieDAO->getAll();
    $genreList = $genreDAO->getAll();
?>

<a class="btn btn-primary" style="display: inline;" role="button" href="
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

<div class="dropdown" style="display: inline;">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Filtrar por
    </button>
    <div class="dropdown-menu background-dark" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" style="color: crimson;" href="#">Titulo</a>
        <a class="dropdown-item" style="color: crimson;" href="#">Niños/Familiares</a>
        <a class="dropdown-item" style="color: crimson;" href="#">Adultos</a>
    </div>
</div>

<div class="dropdown" style="display: inline;">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="genreFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Filtrar por género
    </button>
    <div class="dropdown-menu background-dark" aria-labelledby="dropdownMenuButton">
        <?php 
            foreach($genreList as $genre)
            {

        ?>
                <a class="dropdown-item" style="color: crimson;" href="<?php echo "#genreId".$genre->getId();?>"><?php echo $genre->getName();?></a>
        <?php   
            }
        ?>
    </div>
</div>

<main class="d-flex align-items-center height-100">
    <div class="grid">
        <?php   
            foreach($movieList as $movieValue)
            {  
        ?>
                <div class="card w-15 m-2 background-dark text-white text-center" style="width: 364px;">
                    <div class="card-header" style="background: crimson;">
                        <h3 class="card-title" style="text-align:center;"><?php echo $movieValue->getTitle();?></h3> 
                    </div>

                    <div class="card-header" style="display:block; margin:auto;">
                        <img style="width: 300px; height: 400px;" src='https://image.tmdb.org/t/p/w780/<?= $movieValue->getPosterPath() ?>'/>
                    </div>

                    <div class="card-body">
                        <p class="card-text">
                            <?php 
                                $movieOverview = $movieValue->getOverview(); 
                                $movieOverviewLength = strlen($movieOverview);
                                $overviewMaxCharacters = 210;
                                $limitedMovieOverview = substr($movieOverview, 0, $overviewMaxCharacters);

                                if($movieOverviewLength < $overviewMaxCharacters)
                                {
                                    echo $movieOverview;
                                }
                                else
                                {
                                    echo $limitedMovieOverview;?><a class="color-red" data-toggle="modal" data-target="<?php echo "#movieInfo".$movieValue->getId();?>">(...)</a>
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
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm btn-outline-success background-dark btn-block" data-toggle="modal" data-target="<?php echo "#buyTicket";?>">Comprar entrada</button>
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
                                        <button type="submit" class="btn btn-success">Comprar entrada</button>   
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
                <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo "movieInfo".$movieValue->getId();?>">
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
                                    <h2 style="text-align:center;"><?php echo $movieValue->getTitle();?></h2>
                                </div>
                            </div>

                            <div class="modal-header" style="display:block; margin:auto;">
                                <img style="width: 400px; height: 550px;" src='https://image.tmdb.org/t/p/w780/<?= $movieValue->getPosterPath() ?>'/>
                            </div>

                            <div class="modal-footer">
                                <p><?php echo $movieValue->getOverview();?></p>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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