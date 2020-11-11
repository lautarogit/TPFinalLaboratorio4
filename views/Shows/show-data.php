<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php"); 

    if(!isset($_SESSION['loggedUser']))
    {
        $rolId = -1;
    }
?>

<?php 
    if(!empty($errorMessage))
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
?>

<div class="m-3 text-white show-box" style="width: 550px;">
    <h4 class="m-3" style="display: inline;">Mostrando show de la sala <strong style="color: red"><?php echo $show->getRoom()->getName();?></strong></h4>

    <br><br>

    <div class="text-center">
        <p>
            <h3><?php echo "<strong>Película: </strong>".$show->getMovie()->getTitle();?></h3>
        </p>
        <img style="width: 380px; height: 510px;" src='<?= TMDB_IMG_PATH.$show->getMovie()->getPosterPath(); ?>'/>
    </div>

    <h5 class="m-2">
        <i class="fa fa-calendar" style="color: chartreuse;"></i><?php echo "  Fecha: ".substr($show->getDateTime(), 0, 10);?>
    </h5>

    <?php
        $previousMovieRuntime = $this->minutesToTimeFormat($movie->getRuntime());

        $showDateTime = $this->addHourToTime($show->getDateTime(), $previousMovieRuntime);

        $stringShowTime = $showDateTime->format('Y-m-d H:i:s');
        $endTime = substr($stringShowTime, 11, 5);
    ?>

    <h5 class="m-2">
        <i class="fa fa-clock" style="color: cadetblue;"></i><?php echo "  Inicia a las ".substr($show->getDateTime(), 11, 5)." hs.";?>
    </h5>

    <h5 class="m-2">
        <i class="fa fa-clock" style="color: brown;"></i><?php echo "  Finaliza a las ".$endTime." hs.";?>
    </h5>
    
    <h5 class="m-2">
        <i class="fa fa-ticket-alt" style="color: burlywood;"></i><?php echo "  ".$show->getRemainingTickets();?><strong> Tickets restantes </strong>
    </h5>

    <form class="text-center" action="
        <?php 
            if($rolId != -1)
            {
                echo FRONT_ROOT."Billboard/showBillboard";
            }
            else
            {
                echo FRONT_ROOT."Show/actionDisabled";
            }
        ?>">

        <?php
            if($rolId != -1)
            {
        ?>
                <button class="btn btn-success m-2" type="submit" name="idMovie" value="<?= $show->getMovie()->getId();?>">
                    Consultar por entrada
                </button>
        <?php
            }
            else
            {
        ?>
                <button class="btn btn-success m-2" type="submit" name="idShow" value="<?= $show->getId();?>">
                    Consultar por entrada
                </button>
        <?php
            }
        ?>
    </form>
</div>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary m-2" type="submit" name="idCinema" value="<?= $show->getRoom()->getIdCinema();?>">
        Volver
    </button>
</form>

<?php 
    require_once(VIEWS_PATH."footer.php");
?>