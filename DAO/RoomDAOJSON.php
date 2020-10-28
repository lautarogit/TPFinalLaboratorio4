<?php
    namespace DAO;
    
    use Models\Room as Room;

    class RoomDAOJSON
    {
        private $roomList = array();

        public function add (Room $newRoom)
        {
            $this->retrieveData();
            $newRoom->setId($this->GetNextId());
            array_push($this->roomList, $newRoom);
            $this->saveData();
        }

        public function getAll ()
        {
            $this->retrieveData();
            return $this->roomList;
        }

        public function getRoomById ($idRoom)
        {
            $this->retrieveData();
            $room = new Room();

            foreach($this->roomList as $roomValue)
            {
                if($roomValue->getId() == $idRoom) 
                {
                    $room = $roomValue;
                }
            }

            return $room;
        }

        public function delete (Room $roomDeleted)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->roomList as $room) 
            {
                if($room->getId() != $roomDeleted->getId())
                {
                    array_push($newList, $room);
                }
            }

            $this->roomList = $newList;
            $this->saveData();
        }

        public function edit (Room $roomUpdated)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->roomList as $room) 
            {
                if($room->getId() != $roomUpdated->getId())
                {
                    array_push($newList, $room);
                }
                else
                {
                    array_push($newList, $roomUpdated);
                }
            }
            
            $this->roomList = $newList;
            $this->saveData();
        }

        private function saveData ()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->roomList as $room) 
            {
                $arrayValue['id'] = $room->getId();
                $arrayValue['idCinema'] = $room->getIdCinema();
                $arrayValue['capacity'] = $room->getCapacity();
                $arrayValue['type'] = $room->getType();
                $arrayValue['name'] = $room->getName();

                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }

        private function retrieveData ()
        {
            $this->roomList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, TRUE) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $room = new Room();
                $id = $arrayValue['id'];
                $idCinema = $arrayValue['idCinema'];
                $capacity = $arrayValue['capacity'];
                $type = $arrayValue['type'];
                $name = $arrayValue['name'];

                $room->setId($id);
                $room->setIdCinema($idCinema);
                $room->setCapacity($capacity);
                $room->setType($type);
                $room->setName($name);

                array_push($this->roomList, $room);
            }
        }

        private function GetNextId ()
        {
            $id = 0;

            foreach($this->roomList as $room)
            {
                $id = ($room->getId() > $id) ? $room->getId() : $id;
            }

            return $id + 1;
        }

        function getJsonFilePath ()
        {
            $initialPath = "Data/rooms.json";

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