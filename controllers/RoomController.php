<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use Controllers\iValidation as iValidation;

    class RoomController implements iValidation
    {
        private $roomDAO;
        private $cinemaDAO;

        public function __construct ()
        {
            $this->roomDAO = new RoomDAO();
            $this->cinemaDAO = new CinemaDAO();
        }

        public function showRoomPermissionBlocked ($rolId)
        {
            require_once(VIEWS_PATH."room-permission-blocked.php");
        }

        public function showRoomDashboard ($idCinema)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();
            $idCinema = intval($idCinema);
            $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);
            //var_dump($roomList);

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."room-dashboard.php");
            }
            else
            {
                $this->showRoomPermissionBlocked($rolId);   
            }   
        }

        public function showClientRoomDashboard ($idCinema)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();
            $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."client-room-dashboard.php");
            }
            else
            {
                $this->showRoomPermissionBlocked($rolId); 
            }   
        }

        public function addRoom ($idCinema, $capacity, $price, $name)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $room = new Room();
            $cinema = new Cinema();
            $cinemaController = new CinemaController();

            $cinema = $this->cinemaDAO->getCinemaById($idCinema);
            $idCinema = $cinema->getId();
            
            $room->setIdCinema($idCinema);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $room->setName($name);
            $this->roomDAO->add($room);

            $cinemaController->showCinemaDashboard();
        }

        public function editRoom ($id, $idCinema, $capacity, $price, $name)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $roomUpdated = new Room();
            
            $roomUpdated->setId($id);
            $roomUpdated->setIdCinema($idCinema);
            $roomUpdated->setCapacity($capacity);
            $roomUpdated->setPrice($price);
            $roomUpdated->setName($name);
           
            $this->roomDAO->edit($roomUpdated);
            $this->showRoomDashboard($idCinema);
        }

        public function disableRoom ($id)
        {
           
        }

        public function validateFormField ($paramName, $minLength, $maxLength) 
        {
            if(!empty(trim($paramName)))
            {
                if((strlen($paramName) >= $minLength) && (strlen($paramName) <= $maxLength))
                {
                    $flag = true;
                } 
                else
                {
                    $flag = false;
                } 
            }
            else
            {
                $flag = false;
            } 

            return $flag;
        }
    }
?>

 