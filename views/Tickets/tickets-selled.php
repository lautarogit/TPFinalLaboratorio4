<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>" rol="button">
    Volver a cartelera de cines
</a>

<table class="table bg-dark text-white m-2">
    <thead>
        <th>Cantidad de tickets total</th>
        <th>Cantidad en pesos total</th>
    </thead>

    <tr>
        <td><?php echo count($ticketList);?></td>
        <td><?php echo "pesosTotal";?></td>
    </tr>
</table>

<table class="table bg-dark text-white m-2">
    <thead>
        <th>Cantidad de tickets</th>
        <th>Cantidad en pesos</th>
    </thead>

<?php
    foreach($ticketList as $ticket)
    {       
?>
        <tr>
            <td><?php echo "ex";?></td>
            <td><?php echo "$"."ex";?></td>
        </tr>
<?php  
    } 
?>
</table>

<?php
    require_once(VIEWS_PATH."footer.php");
?>