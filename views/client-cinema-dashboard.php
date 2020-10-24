<?php 
    require_once("header.php"); 
    require_once("nav.php");

    use DAO\CinemaDAO as CinemaDAO;

    $cinemaDAO = new CinemaDAO();
    $cinemaList = $cinemaDAO->getAll();
?>

<main class="d-flex m-2">
    <div class="card-rows">
        <div class="card-columns">
            <?php 
                foreach($cinemaList as $cinemaValue) 
                {
            ?>
                    <div class="card w-15 card-box-shadow text-white background-dark">
                        <div class="card-header text-white background-linear-gradient">
                            <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>
                        </div>

                        <div class="card-body">
                            <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>
                            <?php 
                                if($cinemaValue->getRoomsId() != null)
                                {
                                    $roomsQuantity = count($cinemaValue->getRoomsId());
                                }
                                else
                                {
                                    $roomsQuantity = 0;
                                }  
                            ?>
                            <p class="card-text">
                            <?php echo "<strong>N° de Salas disponibles: </strong>".$roomsQuantity;?></p>
                        </div>

                        <a class="btn btn-sm btn-outline-info background-dark btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">
                            Ver catalogo
                        </a>

                        <form method="POST" action="<?php echo FRONT_ROOT."Room/showClientRoomDashboard";?>"> 
                            <button class="btn btn-sm btn-outline-success background-dark btn-block" value="<?php echo $cinemaValue->getId();?>" name="idCinema">
                                Ver salas
                            </button>
                        </form>
                    </div> 
            <?php
                } 
            ?> 
        </div>
    </div> 
</main>

<?php 
    require_once("footer.php");
?>