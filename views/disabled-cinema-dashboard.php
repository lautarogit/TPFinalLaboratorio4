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

                                    <form style="float:right; display: inline; margin: 2px;" method="POST" action="<?php echo FRONT_ROOT."Cinema/disableCinema"?>"> 
                                        <button class="btn btn-danger btn-sm" value="<?php echo $cinemaValue->getId(); ?>" name="id">
                                            <i class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="card-body">
                                    <p class="card-text">
                                        <?php echo "<strong>Estado: </strong>";?><i class="fas fa-ban" style="color: red;"></i>
                                    </p>

                                    <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>
                                    <?php 
                                        $idCinema = $cinemaValue->getId();
                                        $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);

                                        if(!empty($roomList))
                                        {
                                            $roomListSize = count($roomList);
                                        }
                                        else
                                        {
                                            $roomListSize = 0;
                                        }
                                        ?>

                                        <p class="card-text">
                                            <?php echo "<strong>N° de Salas disponibles: </strong>".$roomListSize;?>
                                        </p>
                                </div>
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