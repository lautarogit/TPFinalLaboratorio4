<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use Models\Cinema as Cinema;
    use Models\Room as Room;

    class CinemaController
    {
        private $cinemaDAO;
        private $roomDAO;

        public function __construct ()
        {
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
        }

        public function showCinemaDashboard ()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."cinema-dashboard.php");
        }

        public function showRoomDashboard ($idCinema)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $_SESSION['idCinema'] = $idCinema;
            require_once(VIEWS_PATH."room-dashboard.php");
        }

        public function addCinema ($name, $location, $capacity)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinema = new Cinema();
            $cinemaList = $this->cinemaDAO->getAll();
            $cinemaListDimension = count($cinemaList);
            $index = $cinemaListDimension-1;
    
            if($cinemaListDimension == 0)
            {
                $id = 1;
            }
            else
            {
                $id = $cinemaList[$index]->getId() + 1;
            }
                
            $cinema->setId($id);
            $cinema->setName($name);
            $cinema->setLocation($location);
            $cinema->setCapacity($capacity);
    
            $this->cinemaDAO->add($cinema);
            $this->showCinemaDashboard();
        }

        public function editCinema ($id, $name, $location, $capacity)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinemaUpdated = new Cinema();
            $cinemaUpdated->setId($id);
            $cinemaUpdated->setName($name);
            $cinemaUpdated->setLocation($location);
            $cinemaUpdated->setCapacity($capacity);

            $this->$cinemaDAO->edit($cinemaUpdated);
            $this->showCinemaDashboard();
        }

        public function deleteCinema ($id)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinemaDeleted = new Cinema();
            $cinemaDeleted->setId($id);

            $this->cinemaDAO->delete($cinemaDeleted);
            $this->showCinemaDashboard();
        }

        public function addRoom ($idCinema, $capacity, $type, $name)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinema = new Cinema();
            $cinema = $this->cinemaDAO->getCinemaById($idCinema);

            $room = new Room();
            $roomList = $this->roomDAO->getAll();
            $roomListDimension = count($roomList);
            $index = $roomListDimension-1;
    
            if($roomListDimension == 0)
            {
                $id = 1;
            }
            else
            {
                $id = $roomList[$index]->getId() + 1;
            }
    
            $room->setId($id);
            $idCinema = $cinema->getId();
            $room->setIdCinema($idCinema);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setName($name);
            $this->roomDAO->add($room);

            $roomsId = array();
            
            foreach($roomList as $roomValue)
            {
                $roomId = $roomValue->getId();
                array_push($roomsId, $roomId);
            }

            $roomId = $room->getId();
            array_push ($roomsId, $roomId);

            $cinema->setRoomsId($roomsId);

            $this->cinemaDAO->edit($cinema);
            $this->showCinemaDashboard();
        }
    }
?>