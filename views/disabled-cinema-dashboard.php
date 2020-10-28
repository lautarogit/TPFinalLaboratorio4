<?php 
    require_once("header.php"); 
    require_once("nav.php");
?>
<div class="m-2">
    <a class="btn btn-info" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="
        <?php echo FRONT_ROOT."Cinema/showCinemaDashboard";?>">Mostrar cines habilitados
    </a>
</div>

<?php 
    if(!empty($errorMessage))
    {
        echo $errorMessage;
    }
?>

<main class="d-flex m-2">
    <div class="card-rows">
        <div class="card-columns">
            <?php  
                if($cinemaList != null)
                {
                    foreach($cinemaList as $cinemaValue) 
                    {
                        if(!$cinemaValue->getStatus())
                        {
            ?>
                            <div class="card w-15 card-box-shadow text-white background-dark">
                                <div class="card-header text-white background-blackWhite">
                                    <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>

                                <form style="float:right; display: inline" method="POST" action="<?php echo FRONT_ROOT."Cinema/disableCinema"?>"> 
                                    <button class="btn btn-danger btn-sm" value="<?php echo $cinemaValue->getId(); ?>" name="id">
                                        <i class="fas fa-trash-restore"></i>
                                    </button>
                                </form>
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
                                        <i class="fas fa-film"></i> Ver catalogo
                                    </a>

                                    <form method="POST" action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>"> 
                                        <button class="btn btn-sm btn-outline-success background-dark btn-block" value="<?php echo $cinemaValue->getId();?>" name="idCinema">
                                            <i class="fas fa-eye"></i> Ver salas
                                        </button>
                                    </form>
                                </div>
            <?php
                        }
                    }

                    $status = true;

                    foreach($cinemaList as $cinemaValue) 
                    {
                        if(!$cinemaValue->getStatus())
                        {
                            $status = false;
                        }
                    }

                    if($status)
                    {
                        ?>
                            <h4 class="text-white">No hay cines deshabilitados</h4>
                        <?php
                    }
                }
                else
                {
                    ?>
                        <h4 class="text-white">No hay cines deshabilitados</h4>
                    <?php
                }
            ?> 
        </div>
    </div> 
</main>

<?php 
    require_once("footer.php");
?>