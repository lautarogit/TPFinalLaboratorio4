<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use Models\Movie as Movie;
     use DAO\MovieDAO as MovieDAO;
?>

<main class="d-flex align-items-center height-100">
     <?php   
            $movie = new Movie();
            $movieDAO = new MovieDAO($movie);
            $movieList = $movieDAO->getAll();

            foreach($movieList as $movieValue)
            {  
     ?>
                <div class="card w-15 m-2  background-dark text-white">
                    <div class="card-header" alig="center">
                        <img style="width: 300px; height: 400px;" src='https://image.tmdb.org/t/p/w780/<?= $movieValue->getPosterPath() ?>' alt="POSTER <?php echo $movieValue->getTitle()?>"/>
                    </div>
                    <div class="card-header" style="background-color:crimson">
                        <h3 class="card-title"><?php echo $movieValue->getTitle();?></h3> 
                    </div>

                    <div class="card-body">
                        <p class="card-text"><?php echo $movieValue->getOverview();?></p>
                    </div>

                    <div>
                        <button class="btn btn-sm btn-success btn-block">Comprar</button>
                    </div>
                </div>       
     <?php  
                break;
            } 
     ?> 
</main>
<br>
<br>
<a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Home/showCinemaDashboard";?>">Volver</a>