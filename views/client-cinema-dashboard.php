<?php 
    require_once("header.php"); 
    require_once("nav.php");
?>

<a class="btn btn-sm btn-outline-info background-dark m-2" role="button" href="<?php echo FRONT_ROOT."Movie/showMovieDashboard";?>">
    <i class="fas fa-film"></i> Ver catálogo de películas
</a>

<main class="d-flex m-2">
    <div class="card-rows">
        <div class="card-columns">
            <?php 
                if($cinemaList != null)
                {
                    foreach($cinemaList as $cinemaValue) 
                    {
                        if($cinemaValue->getStatus())
                        {
            ?>
                            <div class="card w-15 card-box-shadow text-white background-dark">
                                <div class="card-header text-white background-linear-gradient">
                                    <h3 class="card-title" style="display: inline;"><?php echo $cinemaValue->getName();?></h3>
                                </div>

                                <div class="card-body">
                                    <p class="card-text">
                                        <?php echo "<strong>Estado: </strong>";?><i class="fas fa-check-circle" style="color: green;"></i>
                                    </p>

                                    <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinemaValue->getLocation();?></p>    

                                    <?php 
                                        $idCinema = $cinemaValue->getId();
                                        $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);
                                        $enableRoomList = array();

                                        if(!empty($roomList))
                                        {
                                            foreach($roomList as $roomValue)
                                            {
                                                if($roomValue->getStatus())
                                                {
                                                    array_push($enableRoomList, $roomValue);
                                                }
                                            }

                                            $roomListSize = count($enableRoomList);
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

                                <form method="POST" action="<?php echo FRONT_ROOT."Room/showClientRoomDashboard";?>"> 
                                    <button class="btn btn-sm btn-outline-success background-dark btn-block" value="<?php echo $cinemaValue->getId();?>" name="idCinema">
                                        <i class="fas fa-eye"></i> Ver salas
                                    </button>
                                </form>
                            </div> 
            <?php
                        }
                    }
                } 
            ?> 
        </div>
    </div> 
</main>

<?php 
    require_once("footer.php");
?>