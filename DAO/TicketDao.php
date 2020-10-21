<?php 
    namespace DAO;
    use Models\Ticket as Ticket;
    use Models\MovieXroom as MovieXroom;

    class TicketDAO
    {
        private $ticketList;

        public function add (Ticket $ticket)
        {
            $this->retrieveData();
            array_push($this->ticketList, $ticket);
            $this->saveData();
        }

        public function getAll ()
        {
            $this->retrieveData();
            return $this->ticketList;
        }

        public function delete (Ticket $ticketDeleted)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->ticketList as $ticket) 
            {
                if($ticket->getCode() != $ticketDeleted->getId())
                {
                    array_push($newList, $ticket);
                }
            }

            $this->ticketList = $newList;
            $this->saveData();
        }

        public function saveData ()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->ticketList as $ticket) 
            {
                $arrayValue['id'] = $ticket->getId();
                $arrayValue['codeQR'] = $ticket->getCodeQR();
                $arrayValue['function'] = $ticket->getFunction();
                $arrayValue['user'] = $ticket->getUser();
                array_push($arrayToEncode,$arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
            file_put_contents($jsonPath,$jsonContent);
        }

        public function retrieveData ()
        {
            $this->ticketList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $ticket = new Ticket(
                $arrayValue['id'],
                $arrayValue['codeQR'],
                $arrayValue['function'],
                $arrayValue['user']);
                        
                array_push($this->ticketList, $ticket);
            }
        }

        public function getJsonFilePath ()
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
