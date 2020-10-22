<?php 
    require_once("header.php"); 
    require_once("nav.php");

    use DAO\MovieDAO as MovieDAO;

    $rolId = $_SESSION['loggedUser']->getRolId();

    $movieDAO = new MovieDAO();
    $movieList = $movieDAO->getAll();
?>

<a class="btn btn-primary" role="button" href="
<?php 
    if($rolId == 0)
    {
        echo FRONT_ROOT."Home/showClientCinemaDashboard";
    }

    if($rolId == 1)
    {
        echo FRONT_ROOT."Home/showCinemaDashboard";
    }
?>">Volver</a>

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
                            
                            <button class="btn btn-sm btn-outline-success background-dark btn-block" data-toggle="modal" data-target="<?php echo "";//"#buyTicket".$cinemaValue->getTicket()->getId();?>">Comprar entrada</button>
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
                                <div class="content d-flex" style="justify-content: center;"> 
                                    <h4>Sala 8</h4>
                                    <h3>ADULTO  $63.00</h3>
                                    <h2>Sherlock Holmes</h2>
                                    <p>Funcion: 30/12/2011 07:00 pm Asiento E-8</p>
                                    <p>Usuario: lautarolp27</p>
                                    <form class="bg-dark-alpha p-5 text-black" action="<?php echo FRONT_ROOT."Cinema/addCinema"?>" method="POST">
                                        <button type="submit" name="addCinema" class="btn btn-success">Comprar entrada</button>   
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