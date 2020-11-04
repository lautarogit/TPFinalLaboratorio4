<?php
require_once(VIEWS_PATH."nav.php");
use models\Ticket as Ticket;
use DAO\TicketDAO as TicketDAO;
$ticketDAO=new TicketDAO();
?>
<table class="table bg-dark text-white">
                         <thead>
                              <th>Nombre de cine</th>
                              <th>Localidad de cine</th>
                              <th>Nombre de la sala</th>
                              <th>Nombre pelicula</th>
                              <th>Duracion</th>
                              <th>Fecha de la funcion</th>
                              <th>Nombre de usuario</th>
                              <th>Email </th>
                         </thead>
<?php
$ticketList=$ticketDAO->getTickets($_SESSION["loggedUser"]->getDni());

 foreach($ticketList as $ticket)
{
        
?>
<tr>
    <td><?php echo $ticket['nameCinema'];?></td>
    <td><?php echo $ticket['locationCinema'];?></td>
    <td><?php echo $ticket['roomName'];?></td>
    <td><?php echo $ticket['nameMovie'];?></td>
    <td><?php echo $ticket['runtime'];?></td>
    <td><?php echo $ticket['dateShow'];?></td>
    <td><?php echo $ticket['userName'];?></td>
    <td><?php echo $ticket['email'];?></td>

<?php      
    }                                               
?>
                                            