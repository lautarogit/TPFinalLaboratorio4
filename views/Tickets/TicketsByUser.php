<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>

<table class="table bg-dark text-white">
    <thead>
        <th>Nombre de cine</th>
        <th>Localidad de cine</th>
        <th>Nombre de la sala</th>
        <th>Nombre pelicula</th>
        <th>Fecha de la funcion</th>
        <th>Nombre de usuario</th>
        <th>Email</th>
    </thead>

<?php
    $ticketList = $this->ticketDAO->getTickets($user->getDni());

    foreach($ticketList as $ticket)
    {       
?>
        <tr>
            <td><?php echo $ticket['nameCinema'];?></td>
            <td><?php echo $ticket['locationCinema'];?></td>
            <td><?php echo $ticket['roomName'];?></td>
            <td><?php echo $ticket['nameMovie'];?></td>
            <td><?php echo $ticket['dateShow'];?></td>
            <td><?php echo $ticket['userName'];?></td>
            <td><?php echo $ticket['email'];?></td>
        </tr>
<?php  
    } 
?>
</table>

<a class="btn btn-info m-1" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>" rol="button">
    Volver a cartelera de cines
</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>
                                            