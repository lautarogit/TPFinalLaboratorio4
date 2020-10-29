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

        public function showRoomDashboard ($idCinema, $errorMessage = '')
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
            $cinemaController = new CinemaController();

            $roomFinded = $this->roomDAO->validateData($name, $idCinema);
            $validateCapacity = $this->validateFormField($capacity, 2, 3);
            $validatePrice = $this->validateFormField($price, 3, 25);
            $validateName = $this->validateFormField($name, 4, 25);
            
            if($roomFinded)
            {
                $room = $this->roomDAO->getRoomByName($name, $idCinema);

                if(!$room->getStatus())
                {
                    $room->setStatus(true);
                    $this->roomDAO->edit($room);
                    $errorMessage = "<h4 class="."text-white m-2".">Se ha rehabilitado una sala con el nombre ingresado</h4>";
                } 
                else
                {
                    $errorMessage = "<h4 class="."text-white m-2".">Ya existe una sala habilitada con ese nombre</h4>";
                } 
            }
            else if($validateCapacity && $validatePrice && $validateName)
            {
                $room->setIdCinema($idCinema);
                $room->setCapacity($capacity);
                $room->setPrice($price);
                $room->setName($name);
                $room->setStatus(true);

                $this->roomDAO->add($room);
            }
            
            if(!empty($errorMessage))
            {
                $cinemaController->showCinemaDashboard($idCinema, $errorMessage);
            }
            else
            {
                $cinemaController->showCinemaDashboard($idCinema);
            }
        }

        public function editRoom ($id, $idCinema, $capacity, $price, $name, $status)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $roomUpdated = new Room();

            $roomFinded = $this->roomDAO->validateData($name, $idCinema);
            $validateCapacity = $this->validateFormField($capacity, 2, 3);
            $validatePrice = $this->validateFormField($price, 2, 10);
            $validateName = $this->validateFormField($name, 2, 25);
            
            if($roomFinded)
            {
                $roomUpdated = $this->roomDAO->getRoomByName($name, $idCinema);

                if(!$roomUpdated->getStatus())
                {
                    $roomUpdated->setStatus(true);
                    $this->roomDAO->edit($room);
                    $errorMessage = "<h4 class="."text-white m-2".">Se ha rehabilitado una sala con el nombre ingresado</h4>";
                } 
                else
                {
                    $errorMessage = "<h4 class="."text-white m-2".">Ya existe una sala habilitada con ese nombre</h4>";
                } 
            }
            else if($validateCapacity && $validatePrice && $validateName && $status!=null)
            {
                $roomUpdated->setId($id);
                $roomUpdated->setIdCinema($idCinema);
                $roomUpdated->setCapacity($capacity);
                $roomUpdated->setPrice($price);
                $roomUpdated->setName($name);
                $roomUpdated->setStatus($status);

                $this->roomDAO->edit($roomUpdated);
            }
            
            if(!empty($errorMessage))
            {
                $this->showRoomDashboard($idCinema, $errorMessage);
            }
            else
            {
                $this->showRoomDashboard($idCinema);
            }
        }

        public function disableRoom ($id)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $roomDisabled = new Room();
            
            $roomDisabled = $this->roomDAO->getRoomByID($id);
            $idCinema = $roomDisabled->getIdCinema();

            if($roomDisabled->getStatus())
            {
                $roomDisabled->setStatus(false);
                $this->roomDAO->edit($roomDisabled);
                $this->showRoomDashboard($idCinema);
            }
            else
            {
                $roomDisabled->setStatus(true);
                $this->roomDAO->edit($roomDisabled);
                $this->showRoomDashboard($idCinema);
            } 
        }

        public function validateFormField ($paramName, $minLength = '', $maxLength = '') 
        {
            if(!empty(trim($paramName)))
            {
                if(!empty($minLenght) && !empty($maxLength))
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
                    $flag = true;
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

 