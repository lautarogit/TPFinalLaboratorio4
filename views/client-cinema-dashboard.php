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
                            <p class="card-text"><?php echo "<strong>Capacidad: </strong>".$cinemaValue->getCapacity();?></p>
                        </div>

                        <a class="btn btn-sm btn-outline-info background-dark btn-block" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">Ver catalogo</a>
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