<?php
use models\Ticket as Ticket;
use DAO\TicketDAO as TicketDAO;
$ticketDAO=new TicketDAO();

$ticketList=$ticketDAO->getTicketByUser($_SESSION["loggedUser"]->getDni());
 foreach($ticketList as $ticket)
{
        
?>
<div> <?php echo $ticket->getIdShow();    ;?></div>
<div> <?php   echo $ticket->getIdUser() ;?></div>
<div> <?php /*echo ;*/?></div>


    echo "<br>";

    echo "<br>";
 <?php
}
?>