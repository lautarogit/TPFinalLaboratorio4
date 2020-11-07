<?php
    namespace Controllers;

    use Models\Show as Show;
    use DAO\ShowDAO as ShowDAO;
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Controllers\iValidation as iValidation;
    use Controllers\RoomController as RoomController;
    use DateTime;

    class ShowController implements iValidation
    {
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;
        private $movieDAO;
        private $roomController;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->cinemaDAO = new CinemaDAO();
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

                if(is_array($showMapout))
                {
                    $lastIndex = (count($showMapout)-1);
                    $room = $this->roomDAO->getRoomByID($showMapout[$lastIndex]->getIdRoom());
                    $movie = $this->movieDAO->getMovieById($showMapout[$lastIndex]->getIdMovie());
    
                    $previousShow = new Show();
                    $previousShow->setId($showMapout[$lastIndex]->getId());
                    $previousShow->setRoom($room);
                    $previousShow->setMovie($movie);
                    $previousShow->setDateTime($showMapout[$lastIndex]->getDateTime());
                    $previousShow->setRemainingTickets($showMapout[$lastIndex]->getRemainingTickets());
                }
                else
                {
                    $room = $this->roomDAO->getRoomByID($showMapout->getIdRoom());
                    $movie = $this->movieDAO->getMovieById($showMapout->getIdMovie());

                    $previousShow = new Show();
                    $previousShow->setId($showMapout->getId());
                    $previousShow->setRoom($room);
                    $previousShow->setMovie($movie);
                    $previousShow->setDateTime($showMapout->getDateTime());
                    $previousShow->setRemainingTickets($showMapout->getRemainingTickets());
                }
                
                $showPreviousDate = substr($previousShow->getDateTime(), 0, 10);
                $previousMovieRuntime = $previousMovie->getRuntime();

                $previousMovieRuntime = $this->minutesToTimeFormat($previousMovieRuntime);

                $newDateEntered = substr($newDateTime, 0, 10);

                $previousShowDateTime = new DateTime($previousShow->getDateTime());

                $hours = substr($previousMovieRuntime, 0, 2);
                $minutes = substr($previousMovieRuntime, 3, 2);
                $seconds = substr($previousMovieRuntime, 6, 2);
                
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
        
                if(($year >= $actualYear) && ($month >= $actualMonth) && ($day >= $actualDay))
                {
                    if($day == $actualDay)
                    {
                        if($hours >= $actualHours)
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
                    else if($day > $actualDay)
                    {
                        $result = true;
                    }  
                }
                else
                {
                    $result = false;
                }
            } 
            
            return $result;
        }
    
        public function searchMovie ($idMovie, $idCinema, $dateTime)
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
                                $dateTimeDay = substr($dateTime, 8, 2);

                                if($showDay == $dateTimeDay)
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

        public function validateShow ($idCinema, $idMovie, $dateTime, $remainingTickets)
        {
            $validateIdMovie = $this->validateFormField($idMovie);
            $validateDateTime = $this->validateDateTime($idCinema, $dateTime);
            $validateRemainingTickets = $this->validateFormField($remainingTickets);
            $movieFinded = $this->searchMovie($idMovie, $idCinema, $dateTime);

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

        public function addShow ($idRoom = '', $idMovie = '', $dateTime = 0, $remainingTickets = '')
        {
            $room = new Room();
            $movie = new Movie();
            $show = new Show();

            $room = $this->roomDAO->getRoomByID($idRoom);
            $movie = $this->movieDAO->getMovieById($idMovie);
            $idCinema = $room->getIdCinema();

            if(!empty($dateTime) && !empty($idMovie))
            {
                $validateShow = $this->validateShow($idCinema, $idMovie, $dateTime, $remainingTickets);
            }  
            else
            {
                $validateShow = false;
            }
            
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