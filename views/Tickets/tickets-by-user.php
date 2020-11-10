<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>

<table class="table bg-dark text-white m-2">
    <thead>
        <th>Cine</th>
        <th>Localidad</th>
        <th>Sala</th>
        <th>Pelicula</th>
        <th>Fecha de función</th>
        <th>Valor del ticket</th>
        <th>Nombre de usuario</th>
        <th>Email</th>
    </thead>

<?php
    foreach($ticketList as $ticket)
    {       
?>
        <tr>
            <td><?php echo $ticket['nameCinema'];?></td>
            <td><?php echo $ticket['locationCinema'];?></td>
            <td><?php echo $ticket['roomName'];?></td>
            <td><?php echo $ticket['nameMovie'];?></td>
            <td><?php echo $ticket['dateShow'];?></td>
            <td><?php echo "$".$ticket['price'];?></td>
            <td><?php echo $_SESSION['loggedUser']->getUserName();?></td>
            <td><?php echo $_SESSION['loggedUser']->getEmail();?></td>
        </tr>
<?php  
    } 
?>
</table>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>" rol="button">
    Volver a cartelera de cines
</a>

<?php
    require_once(VIEWS_PATH."footer.php");
?>
                                            