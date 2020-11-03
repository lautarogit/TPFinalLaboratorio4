<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");

    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Show as Show;
    use Models\Room as Room;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;

    $movieDAO = new MovieDAO();
    $genreDAO = new GenreDAO();
    $movieList = $movieDAO->getAll();
    $genreList = $genreDAO->getAll();
?>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary" type="submit" name="idCinema" value="<?= $room->getIdCinema();?>">
        Volver
    </button>
</form>

<?php 
     if(!empty($errorMessage))
     {
?>
          <div class="alert alert-danger alert-dismissible" style="width: 230px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong><?php echo $errorMessage;?></strong>
          </div>
<?php      
     }   
?>

<div class="content d-flex" style="justify-content: center;"> 
    <form class="bg-dark-alpha text-white" action="<?php echo FRONT_ROOT."Show/addShow";?>" method="POST">
        <div class="form-group m-2">
            <label for="idRoom">ID de Sala (No editable)</label>
            <input type="text" name="idRoom" value="<?= $room->getId();?>" readonly/>
        </div>

        <h4 class="m-2">Seleccione una película: </h4>

        <div class="grid">
            <?php 
                    if(!empty($movieList))
                    {
                        foreach($movieList as $movieValue)
                        {  
            ?>
                            <div class="card w-15 m-2 background-dark text-white text-center" style="width: 364px;">
                                <div class="card-header movie-header-color">
                                    <h3 class="card-title" style="text-align:center;"><?= $movieValue->getTitle();?></h3> 
                                </div>

                                <div class="card-header" style="display:block; margin:auto;">
                                    <img style="width: 300px; height: 400px;" src='<?= TMDB_IMG_PATH.$movieValue->getPosterPath(); ?>'/>
                                </div>

                                

                                <div class="card-footer">
                                    <div style="display:block; margin:auto;">
                                        <p>Géneros: Example</p>

                                        <p><?= "<strong>Fecha de lanzamiento: </strong>".$movieValue->getReleaseDate();?></p>
                                    </div>
                                </div> 

                                <div class="text-center">
                                    Seleccionar
                                </div>

                                <div class="text-center">
                                    <input type="radio" name="idMovie" value="<?= $movieValue->getId();?>">
                                </div>
                            </div>
            <?php
                        } 
                    }
                    else
                    {

                    } 
            ?>
        </div>

        <div class="form-group">
            <label for="dateTime">Fecha del show</label>
            <input type="datetime-local" name="dateTime">
        </div>

        <div class="form-group">
            <label for="remainingTickets">Cantidad de tickets</label>
            <input type="text" name="remainingTickets">
        </div>
        
        <button class="btn btn-success btn-lg text-center" type="submit">Confirmar</button>
    </form> 
</div>

<?php 
    require_once(VIEWS_PATH."footer.php");
?>