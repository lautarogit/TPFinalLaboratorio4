<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use Models\Movie as Movie;

    class MovieController
    {
        private $movieDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
        }

        public function showMovieDashboard ()
        {
            require_once(VIEWS_PATH."movie-dashboard.php");
        }

        public function filterByGenre ()
        {
            
        }
    }
?>