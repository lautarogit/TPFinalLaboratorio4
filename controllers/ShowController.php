<?php
    namespace Controllers;

    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use Controllers\iValidation as iValidation;
    use Controllers\RoomController as RoomController;
    use DateTime;

    class ShowController implements iValidation
    {
        private $roomDAO;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAO();
            $this->roomController = new RoomController();
        }

        public function showAddView ($idRoom, $errorMessage = '')
        {
            $room = new Room();
            $room = $this->roomDAO->getRoomByID($idRoom);

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Shows/add-show.php");
        }

        public function showDataView ($idShow)
        {
            require_once(VIEWS_PATH."Shows/show-data.php");
        }

        public function validateShow ($idCinema, $idMovie, $dateTime, $remainingTickets)
        {
            $flag = false;
            $validateIdMovie = $this->validateFormField($idMovie);
            #$validateDateTime = $this->validateDateTime($dateTime);
            $validateRemainingTickets = $this->validateFormField($remainingTickets);
            $movieFinded = $this->showDAO->getShowMovieByIdCinema($idMovie, $idCinema);
            var_dump($movieFinded);
            if($validateIdMovie && !empty($dateTime) && $validateRemainingTickets && !$movieFinded)
            {  
                $flag = true; 
            }
            else
            {
                $flag = false;
            }
            
            return $flag;
        }

        public function validateDateTime ($dateTime)
        {
            $result = false;

            $movieDate = substr($dateTime, 0, 10);

            $date = new DateTime($movieDate); #serian las fechas
            $newDate = new DateTime("2020-10-31"); #irian las fechas nueva
            $time = new DateTime("15:29:00"); #irian las horas, deberia compararlo asi y sumandole el get duration.
            $newTime = new DateTime("15:22:00"); #irian la hora nueva

            var_dump($movieDate);

            if($date == $newDate)
            {
                $diff = $time->diff($newTime);
                $result = ($diff->days * 24) * 60  + ($diff->i); 
            
                if($result <= 15)
                {
                    $result = false;
                }
                else
                {
                    $result = true;
                }
            }

            return $result;
        }

        public function addShow ($idRoom, $idMovie, $dateTime, $remainingTickets)
        {
            $room = new Room();
            $movie = new Movie();
            $show = new Show();

            $room = $this->roomDAO->getRoomByID($idRoom);
            $movie = $this->movieDAO->getMovieById($idMovie);
            $idCinema = $room->getIdCinema();
            
            $validateShow = $this->validateShow($idCinema, $idMovie, $dateTime, $remainingTickets);

            if($validateShow)
            {
                $show->setRoom($room);
                $show->setMovie($movie);
                $show->setDateTime($dateTime);
                $show->setRemainingTickets($remainingTickets);

                $this->showDAO->add($show);
                $idCinema = $show->getRoom()->getIdCinema();
    
                $showMapout = $this->showDAO->getShowByIdRoom($idRoom);
                $idShow = $showMapout->getId();
                $room->setIdShow($idShow);
                $this->roomDAO->edit($room);
                
                $this->roomController->showRoomDashboard($idCinema);
            }
            else
            {
                $errorMessage = "Datos incorrectos"; 
                $this->showAddView($idRoom, $errorMessage);
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