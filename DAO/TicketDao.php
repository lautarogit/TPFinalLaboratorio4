<?php 
    namespace DAO;
    use Models\Ticket as Ticket;
    use Models\MovieXroom as MovieXroom;
use Models\User as User;
use \PDOException as PDOException;
use DAO\Connection as Connection;
use DAO\UserDAO as UserDao;
use DAO\MovieXRoomDAO as MovieXRoomDAO;

    class TicketDAO
    {
        private $conecction;
        private function add (Ticket $ticket){
        $sqlQuery ='INSERT INTO TICKETS  (id,IdUser,idFunction)   values (:id,:codeQR ,:idUser, :idFunction)';
    $parameter['id']=$ticket->getId();
    $parameter ['codeQR']=$ticket->getCodeQR();
    $parameter['idUser']=$ticket->getIdUser();
    $parameter['idFunction']=$ticket->getFunction();
    try {
        $this->connection=Connection::getInstance();
        return $this->connection->executeNonQuery($sqlQuery,$parameter);

    }   
    catch(PDOException $ex){
        throw $ex;

    } 

    }
    public function getAll ()
    {
        $sqlQuery = "SELECT * FROM tickets";
        
        try
        {
            $this->connection = Connection::getInstance();
        
            $result = $this->connection->execute($sqlQuery);
        }
        catch(PDOException $ex)
        {
            throw $ex;
        }
        
        if(!empty($result))
        {
            $result = $this->mapout($result);

            $cinemaList = array();

            if(!is_array($result))
            {
               array_push($ticketList, $result);
            }
        }
        else 
        {
            $result =  false;
        }

        if(!empty($ticketList))
        {
            $finalResult = $ticketList;  
        }
        else
        {
            $finalResult = $result;
        }

        return $finalResult;
    }
     public function mapout($value){
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            return new Ticket($p['id'],$p['codeQR'],$p['idUser'],$p['idFunction']);
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    }
 ?>
