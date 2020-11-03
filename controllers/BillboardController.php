<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class BillboardController
    {
        private $movieDAO;
        private $genreDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
        }

        public function showBillboard ($idMovie)
        {
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieById($idMovie);
            $genreDAO = $this->genreDAO;

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Billboard/billboard.php");
        }
    }
?>