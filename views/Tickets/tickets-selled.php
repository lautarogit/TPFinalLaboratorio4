<?php
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>

<a class="btn btn-info m-2" style="display: inline; border-radius: 2px 10px 10px 2px;" role="button" href="<?= FRONT_ROOT."Cinema/showCinemaDashboard";?>" rol="button">
    Volver a cartelera de cines
</a>
<?php
    $i = 0;
    $x = 0;
    $totalPrice = 0;
    $totalRemainingTickets = 0;

    foreach($ticketList as $ticket)
    {       
        $totalPrice += $ticket['price'];
        $i++;
    } 

    foreach($showList as $show)
    {       
        $totalRemainingTickets += $show['remainingTickets'];
        $x++;
    } 
?>

<table class="table bg-dark text-white m-2">
    <thead>
        <th>Cantidad de tickets total</th>
        <th>Cantidad en pesos total</th>
        <th>Tickets restantes total</th>
    </thead>

    <tr>
        <td><?php echo count($ticketList);?></td>
        <td><?php echo "$".$totalPrice;?></td>
        <td><?php echo $totalRemainingTickets;?></td>
    </tr>
</table>

<table class="table bg-dark text-white m-2">
    <thead>
        <th>Ticket</th>
        <th>Valor</th>
    </thead>

<?php
    $i = 1;
    $x = 0;

    foreach($ticketList as $ticket)
    {      
?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo "$".$ticket['price'];?></td>
        </tr>
<?php   
        $i++;
    } 
?>
</table>

<?php
    require_once(VIEWS_PATH."footer.php");
?>