<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");

    $existingMovieList = $this->movieDAO->getMovieListByIdCinema($idCinema);
    if(!empty($existingMovieList))
    {
        $existingMovieListSize = count($existingMovieList);
    
        $movieListSize = count($movieList);
        $availableMovieList = array();
        $i = 0;
        $x = 0;

        for($i = 0; $i < $movieListSize; $i++)
        {
            if($x < $existingMovieListSize)
            {
                if($movieList[$i]->getId() != $existingMovieList[$x]->getId())
                {
                    array_push($availableMovieList, $movieList[$i]);
                }
                else
                {
                    $x++;
                }
            }
            else
            {
                array_push($availableMovieList, $movieList[$i]);
            }
        }

        $movieList = $availableMovieList;
    }
?>

<form action="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">
    <button class="btn btn-primary" type="submit" name="idCinema" value="<?= $room->getIdCinema();?>">
        Volver
    </button>
</form>

<?php 
     if(!empty($errorMessage))
     {
        $errorMessageLength = (strlen($errorMessage)*13);   
?>
        <div class="alert alert-danger alert-dismissible" style="width: <?= $errorMessageLength ?>px;">
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

<?php 
if(!empty($movieList))
{
    if(count($movieList) >= 5)
    {
?>
        <div class="grid">
<?php   
    }
    else if(count($movieList) <= 4)
    {
            
?>
        <div class="card-columns">
<?php 
    }
} 
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
                                        <p>
                                            <?php 
                                                $genres = $this->genreDAO->getGenres($movieValue);
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

                                        <p><?= "<strong>Fecha de lanzamiento: </strong>".substr($movieValue->getReleaseDate(), 0, 10);?></p>
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