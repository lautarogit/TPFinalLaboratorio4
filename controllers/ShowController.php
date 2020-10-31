<?php
    namespace Controllers;

    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAOJSON as MovieDAOJSON;
    use Controllers\iValidation as iValidation;
    use Controllers\RoomController as RoomController;

    class ShowController implements iValidation
    {
        private $roomDAO;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAOJSON();
            $this->roomController = new RoomController();
        }

        public function showAddView ($idRoom)
        {
            $room = new Room();
            $room = $this->roomDAO->getRoomByID($idRoom);

            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-show.php");
        }

        public function showDataView ($idShow)
        {
            require_once(VIEWS_PATH."show-data.php");
        }

        public function addShow ($idRoom, $idMovie, $dateTime, $remainingTickets)
        {
            $room = new Room();
            $movie = new Movie();
            $show = new Show();

            $room = $this->roomDAO->getRoomByID($idRoom);
            $movie = $this->movieDAO->getMovieById($idMovie);

            $show->setRoom($room);
            $show->setMovie($movie);
            $show->setDateTime($dateTime);
            $show->setRemainingTickets($remainingTickets);

            $this->showDAO->add($show);
            $idCinema = $show->getRoom()->getIdCinema();

            $show = $this->showDAO->getShowByIdRoom($idRoom);
            $idShow = $show->getId();
            $room->setIdShow($idShow);
            $this->roomDAO->edit($room);
            
            $this->roomController->showRoomDashboard($idCinema);
        }

        public function editShow ($id, $name, $location, $status)
        {
            
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