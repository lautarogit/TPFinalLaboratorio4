<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\ShowDAO as ShowDAO;
    use Models\Show as Show;
    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;
    use Controllers\iValidation as iValidation;

    class RoomController implements iValidation
    {
        private $roomDAO;
        private $cinemaDAO;
        private $showDAO;
        private $movieDAO;

        public function __construct ()
        {
            $this->roomDAO = new RoomDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->showDAO = new ShowDAO();
            $this->movieDAO = new MovieDAO();
        }

        public function showRoomPermissionBlocked ($rolId)
        {
            require_once(VIEWS_PATH."Rooms/room-permission-blocked.php");
        }

        public function showRoomDashboard ($idCinema, $errorMessage = '')
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();
            $idCinema = intval($idCinema);
            $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);
            $showMapout = $this->showDAO->getAll();
            $newShowList = array();
            
            if(!empty($showMapout))
            {
                foreach($showMapout as $showValue)
                {
                    $id = $showValue->getId();
                    $room = new Room();
                    $idRoom = $showValue->getIdRoom();
                    $room = $this->roomDAO->getRoomByID($idRoom);
                    $movie = new Movie();
                    $idMovie = $showValue->getIdMovie();
                    $movie = $this->movieDAO->getMovieByID($idMovie);
                    $dateTime = $showValue->getDateTime();
                    $remainingTickets = $showValue->getRemainingTickets();
    
                    $show = new Show();
    
                    $show->setId($id);
                    $show->setRoom($room);
                    $show->setMovie($movie);
                    $show->setDateTime($dateTime);
                    $show->setRemainingTickets($remainingTickets);
    
                    array_push($newShowList, $show);
                }
            }
        
            $showList = $newShowList;
            
            if($rolId == 1)
            {
                require_once(VIEWS_PATH."Rooms/room-dashboard.php");
            }
            else
            {
                $this->showRoomPermissionBlocked($rolId);   
            }   
        }

        public function showClientRoomDashboard ($idCinema)
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();
            $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."Rooms/client-room-dashboard.php");
            }
            else
            {
                $this->showRoomPermissionBlocked($rolId); 
            }   
        }

        public function addRoom ($idCinema, $capacity, $price, $name)
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
            $room = new Room();

            $roomFinded = $this->roomDAO->validateData($name, $idCinema);
            $validateCapacity = $this->validateFormField($capacity, 2, 3);
            $validatePrice = $this->validateFormField($price, 3, 25);
            $validateName = $this->validateFormField($name, 4, 25);
            
            if($roomFinded)
            {
                $room = $this->roomDAO->getRoomByName($name, $idCinema);

                if(!$room->getStatus())
                {
                    if($validateCapacity && $validatePrice && $validateName)
                    {
                        $room->setStatus(true);
                        $room->setIdCinema($idCinema);
                        $room->setCapacity($capacity);
                        $room->setPrice($price);
                        $room->setName($name);
                        $this->roomDAO->edit($room);

                        $errorMessage = "Se ha rehabilitado y modificado una sala con el nombre ingresado";
                    }
                    else
                    {
                        $errorMessage = "No se ha podido rehabilitar y modificar la sala ya existente por datos incorrectos.";
                    }    
                } 
                else
                {
                    if($validateCapacity && $validatePrice && $validateName)
                    {
                        $room->setIdCinema($idCinema);
                        $room->setCapacity($capacity);
                        $room->setPrice($price);
                        $room->setName($name);
                        $this->roomDAO->edit($room);
                
                        $errorMessage = "Se ha modificado una sala ya existente con ese nombre";
                    }
                    else
                    {
                        $errorMessage = "No se ha podido modificar la sala ya existente por datos incorrectos.";
                    }   
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
                $this->showRoomDashboard($idCinema, $errorMessage);
            }
            else
            {
                $this->showRoomDashboard($idCinema);
            }
        }

        public function editRoom ($id, $idCinema, $capacity, $price, $name, $status)
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
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
                    $this->roomDAO->edit($roomUpdated);
                    $errorMessage = "Se ha rehabilitado una sala con el nombre ingresado";
                } 
                else
                {
                    $errorMessage = "Ya existe una sala habilitada con ese nombre";
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
            require_once(VIEWS_PATH."Session/validate-session.php");
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

 