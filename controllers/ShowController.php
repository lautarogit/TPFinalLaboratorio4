<?php
    namespace Controllers;

    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use Controllers\iValidation as iValidation;
    use Controllers\RoomController as RoomController;
    use DateTime;

    class ShowController implements iValidation
    {
        private $roomDAO;
        private $showDAO;
        private $movieDAO; 
        private $genreDAO;  
        private $roomController;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->roomController = new RoomController();
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

        public function showDataView ($idShow)
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
            $dateTime = $showMapout->getDateTime();
            $remainingTickets = $showMapout->getRemainingTickets();

            $show->setId($id);
            $show->setRoom($room);
            $show->setMovie($movie);
            $show->setDateTime($dateTime);
            $show->setRemainingTickets($remainingTickets);

            require_once(VIEWS_PATH."Shows/show-data.php");
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

        public function addHourToTime ($time, $hourToAdd)
        {
            $hours = substr($hourToAdd, 0, 2);
            $minutes = substr($hourToAdd, 3, 2);
            $seconds = substr($hourToAdd, 6, 2);
            
            $time->modify('+'.$hours.' hours'); 
            $time->modify('+'.$minutes.' minute');
            $time->modify('+'.$seconds.' second');

            return $time;
        }

        public function validateDateTime ($idCinema, $newDateTime)
        {
            $result = false;
            $previousMovieList = $this->movieDAO->getMovieListByIdCinema($idCinema);

            if(!empty($previousMovieList))
            {
                $previousMovieListSize = count($previousMovieList);
                $previousMovie = new Movie();

                for($i = 0; $i < $previousMovieListSize ; $i++)
                {
                    if($i == ($previousMovieListSize-1))
                    {
                        $previousMovie = $previousMovieList[$i];
                    }
                }

                $showMapout = $this->showDAO->getShowByIdCinemaAndIdMovie($idCinema, $previousMovie->getId());
                $previousShow = new Show();
                $room = $this->roomDAO->getRoomByID($showMapout->getIdRoom());
                $movie = $this->movieDAO->getMovieById($showMapout->getIdMovie());
                $previousShow->setId($showMapout->getId());
                $previousShow->setRoom($room);
                $previousShow->setMovie($movie);
                $previousShow->setDateTime($showMapout->getDateTime());
                $previousShow->setRemainingTickets($showMapout->getRemainingTickets());

                $showPreviousDate = substr($previousShow->getDateTime(), 0, 10);
                $previousMovieRuntime = $previousMovie->getRuntime();

                $previousMovieRuntime = $this->minutesToTimeFormat($previousMovieRuntime);

                $newDateEntered = substr($newDateTime, 0, 10);

                $hours = substr($previousMovieRuntime, 0, 2);
                $minutes = substr($previousMovieRuntime, 3, 2);
                $seconds = substr($previousMovieRuntime, 6, 2);

                $previousShowDateTime = new DateTime($previousShow->getDateTime());
                
                $previousShowDateTime->modify('+'.$hours.' hours'); 
                $previousShowDateTime->modify('+'.$minutes.' minute');
                $previousShowDateTime->modify('+'.$seconds.' second');

                $stringPreviousShowTime = $previousShowDateTime->format('Y-m-d H:i:s');
                $showPreviousTime = substr($stringPreviousShowTime, 11, 8);
    
                $newTimeEntered = substr($newDateTime, 11, 8);
                $newTimeEntered .= ':00';
                

                $previousDateTime = $showPreviousDate." ".$showPreviousTime;
                $newDateTime = $newDateEntered." ".$newTimeEntered;

                $dateTime1 = new DateTime($previousDateTime);
                $dateTime2 = new DateTime($newDateTime);

                $diff = $dateTime1->diff($dateTime2);
                $diff->format('%Y:%m:%d:%H:%i:%s');
            
                $year = substr($newDateTime, 0, 4);
                $month = substr($newDateTime, 5, 2);
                $day = substr($newDateTime, 8, 2);
                $hours = $diff->format('%H');
                $minutes = $diff->format('%i');

                $actualDate = new DateTime();
                date_default_timezone_set('America/Argentina/Buenos_Aires');

                $actualYear = $actualDate->format('%Y');
                $actualMonth = $actualDate->format('%m');
                $actualDay = $actualDate->format('%d');

                if(($year >= $actualYear) && ($month >= $actualMonth) && ($day >= $actualDay))
                {
                    if($diff->invert == 0)
                    {
                        if($hours > 0)
                        {
                            $result = true;
                        }
                        else
                        {
                            if($minutes >= 15)
                            {
                                $result = true;
                            }
                            else
                            {
                                $result = false;
                            }
                        }
                    }
                    else
                    {
                        $result = false;
                    }
                }
                else
                {
                    $result = false;
                }  
            }
            else
            {
                $year = substr($newDateTime, 0, 4);
                $month = substr($newDateTime, 5, 2);
                $day = substr($newDateTime, 8, 2);
                $hours = substr($newDateTime, 11, 2);
                $minutes = substr($newDateTime, 14, 2);

                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $actualDate = new DateTime();

                $actualYear = $actualDate->format('%Y');
                $actualMonth = $actualDate->format('%m');
                $actualDay = $actualDate->format('%d');
                $actualHours = $actualDate->format('%H');
                $actualMinutes = $actualDate->format('%i');

                $actualYear = substr($actualYear, 1, 4);
                $actualMonth = substr($actualMonth, 1, 2);
                $actualDay = substr($actualDay, 1, 2);
                $actualHours = substr($actualHours, 1, 2);
                $actualMinutes = substr($actualMinutes, 1, 2);
        
                if(($year >= $actualYear) && ($month >= $actualMonth) && ($day >= $actualDay) && ($hours >= $actualHours))
                {
                    if($hours > $actualHours)
                    {
                        $result = true;
                    }
                    else if($hours == $actualHours)
                    {
                        if($minutes >= $actualMinutes)
                        {
                            $result = true;
                        }
                        else
                        {
                            $result = false;
                        }
                    }  
                }
                else
                {
                    $result = false;
                }
            } 
            
            return $result;
        }

        public function validateShow ($idCinema, $idMovie, $dateTime, $remainingTickets)
        {
            $validateIdMovie = $this->validateFormField($idMovie);

            if(!empty($dateTime))
            {
                $validateDateTime = $this->validateDateTime($idCinema, $dateTime);
            }
            else
            {
                $validateDateTime = false;
            }
    
            $validateRemainingTickets = $this->validateFormField($remainingTickets);
            $movieFinded = $this->showDAO->getShowMovieByIdCinema($idMovie, $idCinema);
            
            if($validateIdMovie && $validateDateTime && $validateRemainingTickets && !$movieFinded)
            {  
                $flag = true; 
            }
            else
            {
                $flag = false;
            }
            
            return $flag;
        }

        public function addShow ($idRoom, $idMovie = '', $dateTime, $remainingTickets = '')
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