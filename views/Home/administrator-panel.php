<?php 
    if(!empty($errorMessage))
    {
        if(is_bool($errorMessage))
        {
?>
            <div class="alert alert-warning alert-dismissible m-2" style="width: 500px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                    No hay nada para actualizar            
                </strong> 
            </div>
<?php   
        }
        elseif(is_string($errorMessage))
        {
?>
            <div class="alert alert-success alert-dismissible m-2" style="width: 630px;">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               <strong><?php echo $errorMessage;?></strong>
            </div>
<?php    
        }  
    } 
?>

<form action="<?php echo FRONT_ROOT."Movie/addMoviesToDB"?>">    
    <button class="btn btn-success m-2" type="submit"> 
        Agregar peliculas a la BDD
    </button>
</form>

<form action="<?php echo FRONT_ROOT."Ticket/showTicketsSelled"?>">    
    <button class="btn btn-info m-2" type="submit"> 
        Ver ventas de tickets
    </button>
</form>

<a class="btn btn-outline-primary m-2" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard"?>">
    Volver a cinema dashboard
</a>


