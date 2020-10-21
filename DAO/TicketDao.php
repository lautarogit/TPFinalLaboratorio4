<?php 
    namespace DAO;
    use Models\Ticket as Ticket;
    use Models\MovieXroom as MovieXroom;
    use DAO\UserDAO as UserDAO;

    class TicketDao
    {
        private $TicketList;

        public function add (Ticket $ticket)
        {
            $this->retrieveData();
            array_push($this->TicketList, $ticket);
            $this->saveData();
        }

        public function getAll()
        {
            $this->retrieveData();
            return $this->TicketList;
        }

        public function delete($idTicket)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->TicketList as $ticket) 
            {
                if($ticket->getCode() != $idTicket)
                {
                    array_push($newList, $ticket);
                }
            }

            $this->TicketList = $newList;
            $this->saveData();
        }

        public function saveData ()
        {
            $arrayToEncode=array();
            $jsonPath =$this->getJsonFilePath();

            foreach ($this->TicketList as $ticket) 
            {
                $arrayValue['idTicket'] =$ticket->getId();
                $arrayValue['codeQr'] =$ticket->getCodeQR();
                $arrayValue['function'] =$ticket->getFunction();
                $arrayValue['user'] =$ticket->getUser();
                array_push($arrayToEncode,$arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
            file_put_contents($jsonPath,$jsonContent);
        }

        public function retrieveData ()
        {
            $this->TicketList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $ticket = new Ticket(
                $arrayValue['idTicket'] ;
                $arrayValue['codeQr'] ;
                $arrayValue['function'];
                $arrayValue['user'];)
                        
                array_push($this->TicketList, $ticket);
            }

        }

        public function getJsonFilePath()
        {
            $initialPath = "Data/tickets.json";

            if(file_exists($initialPath))
            {
                $jsonFilePath = $initialPath;
            }
            else
            {
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }
 ?>
