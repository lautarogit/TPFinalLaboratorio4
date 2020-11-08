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
