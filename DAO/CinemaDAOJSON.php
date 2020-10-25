<?php
    namespace DAO;
    
    use Models\Cinema as Cinema;

    class CinemaDAOJSON 
    {
        private $cinemaList = array();

        public function add (Cinema $newCinema)
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

        public function getCinemaById ($idCinema)
        {
            $this->retrieveData();
            $cinema = new Cinema();

            foreach($this->cinemaList as $cinemaValue)
            {
                if($cinemaValue->getId() == $idCinema)
                {
                    $cinema = $cinemaValue;
                }
            }

            return $cinema;
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
                    array_push($newList, $cinemaUpdated);
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
                $arrayValue['roomsId'] = $cinema->getRoomsId();
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
                $cinema = new Cinema();

                $id = $arrayValue['id'];
                $roomsId = $arrayValue['roomsId'];
                $name = $arrayValue['name'];
                $location = $arrayValue['location'];

                $cinema->setId($id);
                $cinema->setRoomsId($roomsId);
                $cinema->setName($name);
                $cinema->setLocation($location);

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