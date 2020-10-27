<?php
namespace DAO;
use Models\Ticket as Ticket;
use \PDOException as PDOException;
use DAO\Connection as Connection;
class TicketDAO{

    private $connection;
    public function add(Ticket $ticket){
        $sqlQuerty='INSERT INTO TICKETS (codeQR ,idUser,idFunction) values (:codeQR, :idUser ,:idFunction)';
        $parameters['codeQR']=$ticket->getCodeQR()
    }
}


?>