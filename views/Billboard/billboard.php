<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");  
    
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
?>

<?php 
     if(!empty($errorMessage))
     {
         if(is_bool($errorMessage))
         {
?>
            <div class="alert alert-success alert-dismissible m-2" style="width: 630px;">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                 <strong>
                    Entrada/s comprada exitosamente. Ingrese <a href="<?= FRONT_ROOT."Ticket/showAllTicketsByUser";?>">AQUÍ</a> para ver sus entradas
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
  
<div class="btn-toolbar m-2 position-relative" style="left: 400px; top: 80px;" role="toolbar">
    <div class="btn-group mr-2" role="group">
        <?php   
            $i = 0;
            $cinemaListSize = count($cinemaList);
            $showListSize = count($showList);

            foreach($cinemaList as $cinema)
            {
                if($i < $showListSize)
                { 
                    $showIdCinema = $showList[$i]->getRoom()->getIdCinema();
                    $idCinema = $cinema->getId();
                        
                    if($idCinema == $showIdCinema)
                    {             
            ?> 
                        <button class="btn btn-dark" style="color: chocolate; border-radius: 20px 20px 0px 0px;" type="button" 
                        data-toggle="collapse" data-target="<?= "#cinemaCollapseId".$showIdCinema;?>">
                            <?= substr($showList[$i]->getDateTime(), 0, 10);?>
                        </button>
            <?php      
                        $i++; 
                    }       
                }  
            } 
        ?>
    </div>
</div>

<?php   
        $idMovie = $movie->getId();

        foreach($showList as $show)
        {
            $idCinema = $show->getRoom()->getIdCinema();
            $cinema = new Cinema();
            $cinemaDAO = new CinemaDAO();
            $cinema = $cinemaDAO->getCinemaById($idCinema);  
?>
            <div class="card card-box-shadow collapse text-white background-dark d-relative" style="width: 400px; left: 405px; top: 73px;" id="<?= "cinemaCollapseId".$idCinema;?>">
                <div class="card-header text-white background-linear-gradient">
                    <h3 class="card-title" style="display: inline;"><?php echo $cinema->getName();?></h3>
                </div>

                <div class="card-body">
                    <p class="card-text">
                        <?php echo "<strong>Estado: </strong>";?><i class="fas fa-check-circle" style="color: green;"></i>
                    </p>

                    <p class="card-text"><?php echo "<strong>Dirección: </strong>".$cinema->getLocation();?></p> 
                </div>  

                <div class="card-footer">
                    <div class="card-rows">
                        <div class="card-columns">
                        <?php 
                            foreach($showList  as $show)
                            {
                                if($show->getRoom()->getIdCinema() == $idCinema)
                                {
                                    if($show->getRemainingTickets() > 0)
                                    {
                        ?>
                                        <button class="btn btn-warning m-1" type="button" 
                                        data-toggle="modal" data-target="<?= "#ticketModal".$show->getId();?>">
                                            <p>
                                                <i class="fa fa-ticket-alt" style="color: red;"></i>
                                                <?= " ".$show->getRemainingTickets();?>
                                            </p>
                                            <p>
                                                <?= substr($show->getDateTime(), 11, 5)." hs";?>
                                            </p>
                                        </button>

                                        <!-- Ticket Modal -->
                                        <div class="modal fade" tabindex="-1" role="dialog" id="<?= "ticketModal".$show->getId();?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content background-dark text-white">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Ticket (Descuentos martes y miercoles)</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <?php
                                                            $adult = $movie->getAdult();
                                                            $price = $show->getRoom()->getPrice();
                                                            $roomName = $show->getRoom()->getName();
                                                            $date = substr($show->getDateTime(), 0, 10);
                                                            $time = substr($show->getDateTime(), 11, 5);
                                                            $title = $movie->getTitle();
                                                            $idShow = $show->getId();

                                                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                                                            $dateDay = date('l');

                                                            if($dateDay == "Tuesday" || $dateDay == "Wednesday") 
                                                            {
                                                                $discount = 0.75;
                                                                $price = $show->getRoom()->getPrice() * $discount;
                                                                $discountDay = true;
                                                            }
                                                            else
                                                            {
                                                                $discountDay = false;
                                                            }
                                                        ?>

                                                        <h5><?= "Sala: ".$roomName;?></h5>
                                                        <p>
                                                            <?php
                                                                if($adult == 0)
                                                                {
                                                                    ?>
                                                                        <h2 class="d-inline">FAMILIAR<?= "  $".$price;?></h2>
                                                                        <?php 
                                                                            if($discountDay)
                                                                            {
                                                                                ?>
                                                                                    <p class="d-inline" style="color: green;">(25% de descuento incluido)</p>
                                                                                <?php 
                                                                            }
                                                                        ?>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                        <h2 class="d-inline">ADULTO<?= "  $".$price;?></h2>
                                                                        <?php 
                                                                            if($discountDay)
                                                                            {
                                                                                ?>
                                                                                    <p class="d-inline" style="color: green;">(25% de descuento incluido)</p>
                                                                                <?php 
                                                                            }
                                                                        ?>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </p>
                                                        <h2><?= $title; ?></h2>
                                                        <h5><?= "Fecha: ".$date;?></h5>
                                                        <h5><?= "Hora: ".$time;?></h5>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <form action="<?= FRONT_ROOT."Ticket/buyTicket";?>" method="POST">
                                                            <input class="m-1" type="radio" name="card" value="<?= "Visa";?>">
                                                            <img  style="width: 45px; height: 15px;" src='<?= IMG_PATH."visaLogo.png"; ?>'/>  
                                                            <input class="m-1" type="radio" name="card" value="<?= "Mastercard";?>">
                                                            <img  style="width: 30px; height: 23px;" src='<?= IMG_PATH."mastercardLogo.png"; ?>'/>  

                                                            <label class="d-inline" for="quantity">Cantidad de tickets</label>
                                                            <input class="d-inline m-1" type="number" name="quantity">

                                                            <button class="btn btn-success m-2" type="submit" name="idShow" 
                                                            value="<?= $idShow;?>">
                                                                Comprar entrada
                                                            </button>
                                                            
                                                            <button type="button" class="btn btn-secondary m-2" style="float: right;" data-dismiss="modal">
                                                                Cerrar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ----------------- -->
                        <?php 
                                    }
                                }
                            }
                        ?>
                        </div>
                    </div>
                </div> 
            </div>
<?php     
        }       
?>

<div class="card w-15 background-dark text-white text-center m-2" style="width: 364px;">
    <div class="card-header movie-header-color">
        <h3 class="card-title" style="text-align:center;"><?= $movie->getTitle();?></h3> 
    </div>

    <div class="card-header" style="display:block; margin:auto;">
        <img style="width: 300px; height: 400px;" src='<?= TMDB_IMG_PATH.$movie->getPosterPath(); ?>'/>
    </div>

    <div class="card-body">
        <p class="card-text"><?= $movie->getOverview();?></p>       
    </div>

    <div class="card-footer">
        <div style="display:block; margin:auto;">                     
        <?php 
            $genres = $genreDAO->getGenres($movie);
                        
        ?>

        <p>
            <?php 
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

            <p><?= "<strong>Fecha de lanzamiento: </strong>".substr($movie->getReleaseDate(), 0, 10);?></p>
        </div>
    </div> 
</div>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Movie/showMovieDashboard";?>">
    Volver a catálogo de películas
</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>

