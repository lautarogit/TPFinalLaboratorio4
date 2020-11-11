<?php
    namespace Controllers;

    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Controllers\iValidation as iValidation;
    use DateTime;

    class ShowController implements iValidation
    {
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
        }

        public function actionDisabled ($idShow)
        {
            $errorMessage = true;

            $this->showDataView($idShow, $errorMessage);
        }

        public function showAddView ($idRoom, $errorMessage = '')
        {
            $room = new Room();
            $room = $this->roomDAO->getRoomByID($idRoom);
            
            $movieList = $this->movieDAO->getAll();
            $idCinema = $room->getIdCinema();

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Shows/add-show.php");
        }

        public function showDataView ($idShow, $errorMessage = '')
        {
            $show = new Show();
            $showMapout = $this->showDAO->getShowById($idShow);

            $id = $showMapout->getId();
            $idRoom = $showMapout->getIdRoom();
            $room = new Room();
            $room = $this->roomDAO->getRoomByID($idRoom); 
            $idMovie = $showMapout->getIdMovie();
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieByID($idMovie);
            $newDateTime = $showMapout->getDateTime();
            $remainingTickets = $showMapout->getRemainingTickets();

            $show->setId($id);
            $show->setRoom($room);
            $show->setMovie($movie);
            $show->setDateTime($newDateTime);
            $show->setRemainingTickets($remainingTickets);

            require_once(VIEWS_PATH."Shows/show-data.php");
        }

        public function showRoomDashboard ($idCinema, $errorMessage = '')
        {
            if(!empty($_SESSION['loggedUser']))
            {
                $rolId = $_SESSION['loggedUser']->getRolId();
            }
            
            $cinemaDAO = new CinemaDAO();
            $showDAO = new ShowDAO();
            $cinema = $cinemaDAO->getCinemaById($idCinema);
            $idCinema = intval($idCinema);
            $roomList = $this->roomDAO->getRoomListByIdCinema($idCinema);
            $newShowList = array();
            
            if(!empty($roomList))
            {
                foreach($roomList as $room)
                {
                    $showList = $this->showDAO->getShowListByIdRoom($room->getId());
    
                    array_push($newShowList, $showList);
                }
            }
            
            $showList = $newShowList;
            $roomsXshows = $this->showDAO->getRoomsXshows();
            
            require_once(VIEWS_PATH."Rooms/room-dashboard.php");  
        }

        public function minutesToTimeFormat ($minutesToConvert)
        {
            $seconds = ($minutesToConvert * 60);
            $hours = floor($seconds/ 3600);
            $minutes = floor(($seconds - ($hours * 3600)) / 60);
            $seconds = $seconds - ($hours * 3600) - ($minutes * 60);

            $minutesToConvert = null;

            if(strlen($hours)<2)
            {
                $minutesToConvert.= '0'.$hours.':';
            }
            else
            {
                $minutesToConvert.= $hours.':';
            }

            if(strlen($minutes)<2)
            {
                $minutesToConvert.= '0'.$minutes.':';
            }
            else
            {
                $minutesToConvert.= $minutes.':';
            }

            if(strlen($seconds)<2)
            {
                $minutesToConvert.= '0'.$seconds;
            }
            else
            {
                $minutesToConvert.= $seconds;
            }

            return $minutesToConvert;
        }

        public function addHourToTime ($stringTime, $hourToAdd)
        {
            $hours = substr($hourToAdd, 0, 2);
            $minutes = substr($hourToAdd, 3, 2);
            $seconds = substr($hourToAdd, 6, 2);

            $time = new DateTime($stringTime);
            
            $time->modify('+'.$hours.' hours'); 
            $time->modify('+'.$minutes.' minute');
            $time->modify('+'.$seconds.' second');

            return $time;
        }

        public function updateShowStatus ($showId, $movieId, $idCinema = '')
        {
            $isValid = false; 

            $movie = $this->movieDAO->getMovieById($movieId);
            $showMapout = $this->showDAO->getShowById($showId);

            $show = new Show();
            $show->setId($showMapout->getId());
            $show->setMovie($movie);
            $show->setDateTime($showMapout->getDateTime());

            $showDateTime = $show->getDateTime();
        
            $newDateTime = new DateTime($showDateTime);
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $actualDate = new DateTime();
        
            $diff = date_diff($actualDate, $newDateTime);
  
            if($diff->invert == 1)
            {
                $isValid = true;
            }      
            
            if($isValid)
            {
                $show->setStatus(false);

                $this->showDAO->changeStatus($show);
            }
             
            $this->showRoomDashboard($idCinema);
        }  

        public function validateDateTime (Show $show, Show $newShow)
        {
            $isValid = true;

            $movie = $show->getMovie();
            $newMovie = $newShow->getMovie();

            $stringOldDate = substr($show->getDateTime(), 0, 10);
            $stringNewDate = substr($newShow->getDateTime(), 0, 10);
            $stringOldTime = substr($show->getDateTime(), 11, 5);
            $stringNewTime = substr($newShow->getDateTime(), 11, 8);
            
            $oldDate = new DateTime($stringOldDate);
            $newDate = new DateTime($stringNewDate);
            $oldTime = new DateTime($stringOldTime); 
            $newTime = new DateTime($stringNewTime); 
        
            $diff = $newDate->diff($oldDate);
            $dayDiff =  $diff->days; 

            if($dayDiff <= 1)
            {
                $diff = $oldTime->diff($newTime); 
                $result = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
                $runtime = 0;
                
                if($oldTime > $newTime) # 22:00  >   21:30(termina 21:42)
                {
                    $runtime = $newMovie->getRuntime();
                }
                else
                {
                    $runtime = $movie->getRuntime();
                }

                if($result < $runtime + 15 && $dayDiff == 0)
                {
                    $isValid = false;
                }

                if($result >= 1425 - $runtime && $dayDiff == 1)
                {
                    if($oldDate < $newDate && $oldTime < $newTime) 
                    {   
                        $isValid = true;                             
                    }
                    else if($oldDate > $newDate && $oldTime > $newTime)
                    {
                        $isValid = true; 
                    }
                    else
                    {
                        $isValid = false;
                    }
                }   
            }
         
            return $isValid;
        }
    
        public function searchMovie ($idMovie, $idCinema, $newDateTime)
        {
            $flag = false;
            $i = 0;
            $showListMapper = $this->showDAO->getAll();
            $showList = array();

            if(!empty($showListMapper))
            {
                foreach($showListMapper as $showMapper)
                {
                    $show = new Show();

                    $show->setId($showMapper->getId());
                    $movie = $this->movieDAO->getMovieById($showMapper->getIdMovie());
                    $show->setMovie($movie);
                    $room = $this->roomDAO->getRoomById($showMapper->getIdRoom());
                    $show->setRoom($room);
                    $show->setDateTime($showMapper->getDateTime());
                    
                    array_push($showList, $show);
                } 

                $cinemaList = $this->cinemaDAO->getAll();
                $showListSize = count($showList);
                
                foreach($cinemaList as $cinema)
                {
                    if($i < $showListSize)
                    {
                        if($cinema->getId() != $idCinema)
                        {
                            if(($showList[$i]->getMovie()->getId() == $idMovie) && ($showList[$i]->getRoom()->getId() == $cinema->getId()))
                            {
                                $showDay = substr($showList[$i]->getDateTime(), 8, 2);
                                $newDateTimeDay = substr($newDateTime, 8, 2);

                                if($showDay == $newDateTimeDay)
                                {
                                    $flag = true;
                                    break;
                                }
                                else
                                {
                                    $flag = false;
                                }

                                $i++;
                            }   
                        }
                    }  
                }
            }
            else
            {
                $flag = false;
            }

            return $flag;
        }

        public function validateShow ($idCinema, $idRoom, $idMovie, Show $newShow, $remainingTickets)
        {
            $flag = false;

            if(!empty($idCinema) && !empty($idMovie) && !empty($newShow) && !empty($remainingTickets))
            {
                $validateIdMovie = $this->validateFormField($idMovie);
                $validateRemainingTickets = $this->validateFormField($remainingTickets);
                $validateDateTime = false;
                $showMapoutList = $this->showDAO->getAll();
                $showList = array();

                if(!empty($showMapoutList))
                {
                    foreach($showMapoutList as $showMapout)
                    {
                        $movie = new Movie();
                        $movie = $this->movieDAO->getMovieById($showMapout->getIdMovie());
                        $room = new Room();
                        $room = $this->roomDAO->getRoomByID($showMapout->getIdRoom());

                        $show = new Show();
                        $show->setId($showMapout->getId());
                        $show->setRoom($room);
                        $show->setMovie($movie);
                        $show->setDateTime($showMapout->getDateTime());
                        $show->setStatus($showMapout->getStatus());

                        if(($show->getRoom()->getId() == $idRoom) && ($show->getStatus()))
                        {
                            array_push($showList, $show);
                        }  
                    }
                }

                if(!empty($showList))
                {
                    foreach($showList as $showValue)
                    {
                        $validateDateTime = $this->validateDateTime($showValue, $newShow);

                        if(!$validateDateTime)
                        {
                            break;
                        }
                    }
                }
                else
                {
                    $validateDateTime = true;
                }

                $newDateTime = $newShow->getDateTime();
                
                $movieFinded = $this->searchMovie($idMovie, $idCinema, $newDateTime);

                if($validateIdMovie && $validateDateTime && $validateRemainingTickets && !$movieFinded)
                {  
                    $flag = true; 
                }
                else
                {
                    $flag = false;
                }
            }

            return $flag;
        }

        public function addShow ($idRoom = '', $idMovie = '', $newDateTime = 0, $remainingTickets = '')
        {
            $room = new Room();
            $movie = new Movie();
            $show = new Show();

            $room = $this->roomDAO->getRoomByID($idRoom);
            $movie = $this->movieDAO->getMovieById($idMovie);
            $idCinema = $room->getIdCinema();

            if(!empty($idMovie) && !empty($newDateTime))
            {
                $show->setRoom($room);
                $show->setMovie($movie);
                $show->setDateTime($newDateTime);
                $show->setRemainingTickets($remainingTickets);
                $validateShow = $this->validateShow($idCinema, $idRoom, $idMovie, $show, $remainingTickets);
            }  
            else
            {
                $validateShow = false;
            }
            
            if($validateShow)
            {
                $this->showDAO->add($show);
                $idCinema = $show->getRoom()->getIdCinema();

                $this->roomDAO->edit($room);
                    
                $this->showRoomDashboard($idCinema);
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