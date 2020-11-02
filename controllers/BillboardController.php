<?php
    namespace Controllers;

    use DAO\MovieDAOJSON as MovieDAOJSON;
    use DAO\GenreDAOJSON as GenreDAOJSON;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class BillboardController
    {
        private $movieDAO;
        private $genreDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAOJSON();
            $this->genreDAO = new GenreDAOJSON();
        }

        public function showBillboard ($idMovie)
        {
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieById($idMovie);
            $genreList = $this->genreDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Billboard/billboard.php");
        }
    }
?>