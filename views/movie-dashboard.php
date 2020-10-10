<?php 
     require_once("header.php"); 
     require_once("nav.php");

     use DAO\MovieDAO as MovieDAO;
     use Models\Movie as Movie;
?>

<main class="d-flex align-items-center height-100">
     <?php   
            $Movie = new Movie();
            $MovieDAO = new MovieDAO($Movie);
            $MovieList = $MovieDAO->getAll();

            for($i=0; $i<5 ;$i++) 
            { 
     ?>
                <div class="card w-15 m-2">
                    <div class="card-header" alig="center">
                        <img style="display:block; margin:auto;" src="<?php echo IMG_PATH."portrait-example.jpg"; ?>">
                        </div>
                    <div class="card-header" style="background-color:crimson">
                        <h3 class="card-title"><?php echo "TITULO largo . . . . .";?></h3> 
                    </div>

                    <div class="card-body">
                        <p class="card-text"><?php echo "Sinapsis...";?></p>
                    </div>

                    <div>
                        <button class="btn btn-sm btn-success btn-block">Comprar</button>
                    </div>
                </div>       
     <?php  } 
     ?> 
</main>
<br>
<br>
<a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Home/showCinemaDashboard";?>">Volver</a>