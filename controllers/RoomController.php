<?php
    namespace Controllers;

    use DAO\RoomDAOJSON as RoomDAOJSON;
    use Models\Room as Room;
    use DAO\CinemaDAOJSON as CinemaDAOJSON;
    use Models\Cinema as Cinema;

    class RoomController
    {
        private $roomDAO;
        private $cinemaDAO;

        public function __construct ()
        {
            $this->roomDAO = new RoomDAOJSON();
            $this->cinemaDAO = new CinemaDAOJSON();
        }

        public function showRoomDashboard ($idCinema = ' ')
        {
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();

            if($rolId == 1)
            {
                $_SESSION['idCinema'] = $idCinema;
                require_once(VIEWS_PATH."room-dashboard.php");
            }
            else
            {
                ?>
                    <h4 class="text-white">No tiene los permisos necesarios para ingresar a esta página</h4>
                    <a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Room/showClientRoomDashboard";?>">Volver</a>
                <?php   
            }   
        }

        public function showClientRoomDashboard ($idCinema = ' ')
        {
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();

            if($rolId == 0)
            {
                $_SESSION['idCinema'] = $idCinema;
                require_once(VIEWS_PATH."client-room-dashboard.php");
            }
            else
            {
                ?>
                    <h4 class="text-white">No tiene los permisos necesarios para ingresar a esta página</h4>
                    <a class="btn btn-primary" role="button" href="<?php echo FRONT_ROOT."Room/showRoomDashboard";?>">Volver</a>
                <?php   
            }   
        }

        public function addRoom ($idCinema, $capacity, $type, $name)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $room = new Room();
            $cinema = new Cinema();
            $cinemaController = new CinemaController();

            $cinema = $this->cinemaDAO->getCinemaById($idCinema);
            $id = null;

            $room->setId($id);
            $room->setIdCinema($idCinema);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setName($name);
            $this->roomDAO->add($room);

            /* Filtering new list of rooms with the same id of Cinema */
            $roomList = $this->roomDAO->getAll();
            $newRoomList = array();

            foreach($roomList as $roomValue)
            {
                if($idCinema == $roomValue->getIdCinema())
                {
                    array_push($newRoomList, $roomValue);
                }
            }

            /* Pushing rooms ids to list */
            $roomsId = array();
            
            foreach($newRoomList as $roomValue)
            {
                $roomId = $roomValue->getId();
                array_push($roomsId, $roomId);
            }

            /* setting roomsId in cinema and saving changes in the DAO */

            $cinema->setRoomsId($roomsId);

            $this->cinemaDAO->edit($cinema);
            $cinemaController->showCinemaDashboard();
        }

        public function editRoom ($id, $idCinema, $name, $type, $capacity)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $roomUpdated = new Room();
            $roomUpdated->setId($id);
            $roomUpdated->setIdCinema($idCinema);
            $roomUpdated->setName($name);
            $roomUpdated->setType($type);
            $roomUpdated->setCapacity($capacity);
            
            $this->roomDAO->edit($roomUpdated);
            $this->showRoomDashboard($idCinema);
        }

        public function deleteRoom ($id)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $roomDeleted = $this->roomDAO->getRoomById($id);

            /* Retrieving roomId and deleting the room */
            $idCinema = $roomDeleted->getIdCinema();
            $this->roomDAO->delete($roomDeleted);

            /* Filtering new list of rooms with the same id of Cinema */
            $roomList = $this->roomDAO->getAll();
            $newRoomList = array();

            foreach($roomList as $roomValue)
            {
                if($idCinema == $roomValue->getIdCinema())
                {
                    array_push($newRoomList, $roomValue);
                }
            }

            /* Pushing rooms ids to list */
            $roomsId = array();
            
            foreach($newRoomList as $roomValue)
            {
                $roomId = $roomValue->getId();
                array_push($roomsId, $roomId);
            }

            /* Retrieving cinema, setting roomsId 
            in it and saving changes in the DAO */
            $cinema = $this->cinemaDAO->getCinemaById($idCinema);
            $cinema->setRoomsId($roomsId);

            $this->cinemaDAO->edit($cinema);

            $this->showRoomDashboard($idCinema);
        }
    }
?>

 