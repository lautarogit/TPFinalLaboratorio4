<?php
namespace Controllers;

class TicketController{

    public function showAllTicketsByUser(){
        require_once (VIEWS_PATH."Tickets/TicketsByUser.php");
    }
}

?>