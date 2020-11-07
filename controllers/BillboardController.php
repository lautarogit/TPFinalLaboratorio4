<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Movie as Movie;
    use Models\Show as Show;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;

    class BillboardController
    {
        private $movieDAO;
        private $genreDAO;
        private $cinemaDAO;
        private $roomDAO;
        private $showDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
        }

        public function showBillboard ($idMovie)
        {
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieById($idMovie);
            $genreDAO = $this->genreDAO;

            $showMapout = $this->showDAO->getShowByIdMovie($idMovie);

            $cinemaList = $this->cinemaDAO->getAll();

            $showList = array();

            if(!empty($showMapout))
            {
                if(!is_array($showMapout))
                {
                    $room = $this->roomDAO->getRoomById($showMapout->getIdRoom());
                    $movie = $this->movieDAO->getMovieById($showMapout->getIdMovie());
                
                    $show = new Show();
                    $show->setId($showMapout->getId());
                    $show->setRoom($room);
                    $show->setMovie($movie);
                    $show->setDateTime($showMapout->getDateTime());
                    $show->setRemainingTickets($showMapout->getRemainingTickets());

                    array_push($showList, $show);
                }
                else
                {
                    foreach($showMapout as $showValue)
                    {
                        $room = $this->roomDAO->getRoomById($showValue->getIdRoom());
                        $movie = $this->movieDAO->getMovieById($showValue->getIdMovie());

                        $show = new Show();
                        $show->setId($showValue->getId());
                        $show->setRoom($room);
                        $show->setMovie($movie);
                        $show->setDateTime($showValue->getDateTime());
                        $show->setRemainingTickets($showValue->getRemainingTickets());

                        array_push($showList, $show);
                        
                    }    
                } 
            }

            require_once(VIEWS_PATH."Billboard/billboard.php");
        }
    }
?>