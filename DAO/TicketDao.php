<?php 
    namespace DAO;

    use Models\Ticket as Ticket;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class TicketDAO
    {
        private $connection;

        public function add (Ticket $ticket)
        {
            $id = $ticket->getId();
            $codeQR = $ticket->getCodeQR();
            $idShow = $ticket->getIdShow();
            $idUser = $ticket->getIdUser();

            $sqlQuery ='INSERT INTO TICKETS  (id, codeQR, IdUser, idShow)  
            VALUES (:id,:codeQR ,:idUser, :idShow)';

            $parameter['id'] = $id; 
            $parameter['codeQR'] = $codeQR;
            $parameter['idUser'] = $idUser;
            $parameter['idShow'] = $idShow;

            try 
            {
                $this->connection = Connection::getInstance();

                return $this->connection->executeNonQuery($sqlQuery, $parameter);
            }   
            catch(PDOException $ex)
            {
                throw $ex;
            } 
        }
        public function getTicketByUser($idUser){
            $sqlQuery='SELECT * FROM tickets WHERE idUser= :idUser ';
           $parameter['idUser']=$idUser;
            try
            {
                $this->connection = Connection::getInstance();
            
                $result = $this->connection->execute($sqlQuery,$parameter);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($result))
            {
                $result = $this->mapout($result);

                $ticketList = array();

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
        public function getTickets($idUser){
            $sqlQuery ="   SELECT 
             c.name as  'nameCinema'
            , c.location as 'locationCinema'
            , r.name as 'roomName'
            ,m.title as 'nameMovie'
            ,m.runtime as 'runtime'
            , s.dateTime  as 'dateShow' 
            , u.userName as 'userName'
            ,u.email  as 'email'
              , r.price FROM tickets t 
            INNER JOIN shows s 
            ON t.idshow = s.id 
            INNER JOIN users  u
            ON t.idUser = u.dni
            INNER JOIN rooms r 
            ON s.idRoom = r.id 
            INNER JOiN cinemas c
            ON c.id= r.idCinema
            INNER JOIN movies m 
            ON s.idMovie = m.id
            WHERE t.idUser = :idUser; ";
      
            $parameter['idUser']=$idUser;
             try
             {
                 $this->connection = Connection::getInstance();
             
               return   $result = $this->connection->execute($sqlQuery,$parameter);
             }
             catch(PDOException $ex)
             {
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

                $ticketList = array();

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
      

        public function mapout($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                return new Ticket($p['codeQR'], $p['idShow'], $p['idUser']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
 ?>
