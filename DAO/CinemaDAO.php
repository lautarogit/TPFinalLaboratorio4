<?php
    namespace DAO;
    
    use Models\Cinema as Cinema;

    class CinemaDAO 
    {
        private $cinemaList = array();

        public function add(Cinema $newCinema)
        {
            $this->retrieveData();
            array_push($this->cinemaList, $newCinema);
            $this->saveData();
        }

        public function getAll ()
        {
            $this->retrieveData();
            return $this->cinemaList;
        }

        public function delete (Cinema $cinemaDeleted)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->cinemaList as $cinema) 
            {
                if($cinema->getId() != $cinemaDeleted->getId())
                {
                    array_push($newList, $cinema);
                }
            }

            $this->cinemaList = $newList;
            $this->saveData();
        }

        public function edit (Cinema $cinemaUpdated)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->cinemaList as $cinema) 
            {
                if($cinema->getId() != $cinemaUpdated->getId())
                {
                    array_push($newList, $cinema);
                }
                else
                {
                    array_push($newList,$cinemaUpdated);
                }
            }
            
            $this->cinemaList = $newList;
            $this->saveData();
        }

        private function saveData ()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->cinemaList as $cinema) 
            {
                $arrayValue['id'] = $cinema->getId();
                $arrayValue['name'] = $cinema->getName();
                $arrayValue['location'] = $cinema->getLocation();
         

                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }

        private function retrieveData ()
        {
            $this->cinemaList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $cinema = new Cinema($arrayValue['id'], $arrayValue['name'], $arrayValue['location']);
                
                array_push($this->cinemaList, $cinema);
            }
        }

        function getJsonFilePath ()
        {
            $initialPath = "Data/cinemas.json";

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