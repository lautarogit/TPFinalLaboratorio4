<div class="content d-flex" style="justify-content: center;"> 
    <form action="<?php echo FRONT_ROOT."Show/addShow";?>" method="POST" class="login-form bg-dark-alpha p-5 text-white">
        <div class="form-group">
            <input class="form-control form-control-lg" type="text" name="id" value="<?= "example";?>" readonly/>
        </div>

        <div class="form-group">
            <input class="form-control form-control-lg" type="text" name="idRoom" readonly/>
        </div>

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

                        <div class="card-body">
                            <p class="card-text">
                                <?php 
                                    $movieOverview = $movieValue->getOverview(); 
                                    $movieOverviewLength = strlen($movieOverview);
                                    $overviewMaxCharacters = 150;
                                    $limitedMovieOverview = substr($movieOverview, 0, $overviewMaxCharacters);

                                    if($movieOverviewLength < $overviewMaxCharacters)
                                    {
                                        echo $movieOverview;
                                    }
                                    else
                                    {
                                        echo $limitedMovieOverview;?><a class="color-red" data-toggle="modal" data-target="<?= "#movieInfo".$movieValue->getId();?>">(...)</a>
                                <?php 
                                    }   
                                ?></p>       
                        </div>

                        <div class="modal-footer">
                            <div style="display:block; margin:auto;">
                                <?php 
                                    $genresId = $movieValue->getGenresId();
                                    $genreNameList = array();

                                    foreach($genresId as $genreId)
                                    {
                                        foreach($genreList as $genre)
                                        {
                                            if($genreId == $genre->getId())
                                            {
                                                $genreName = $genre->getName();
                                                array_push($genreNameList, $genreName);
                                            } 
                                        }     
                                    }   
                                ?>
                            
                                <p><?php 
                                    echo "<strong>Géneros: </strong>"; 

                                    $genreNameListDimension = count($genreNameList);
                                    $i = 0;
                                    
                                    foreach($genreNameList as $genreName)
                                    {
                                        $i ++;

                                        if($i == $genreNameListDimension)
                                        {  
                                            echo $genreName;
                                        }
                                        else
                                        {
                                            echo $genreName.", ";
                                        } 
                                    }
                                ?></p>

                                <p><?= "<strong>Fecha de lanzamiento: </strong>".$movieValue->getReleaseDate();?></p>
                            </div>
                        </div>

                        <button class="btn btn-sm btn-success m-1" style="width: 354px;" type="submit" name="idMovie" value="<?= $movieValue->getId();?>">
                            Elegir película
                        </button>   
                    </div>
        <?php 
                }
            } 
        ?>

        <button class="btn btn-success btn-lg text-center" style="border-radius:25px 3px 25px 3px;" type="submit">Confirmar</button>
    </form> 
</div>