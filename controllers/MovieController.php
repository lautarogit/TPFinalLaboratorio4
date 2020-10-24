<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class MovieController
    {
        private $movieDAO;
        private $genreDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
        }

        public function showMovieDashboard ()
        {
            $movieList = $this->movieDAO->getAll();
            $genreList = $this->genreDAO->getAll();
            require_once(VIEWS_PATH."movie-dashboard.php");
        }

        public function showFilterMovieDashboard ($filterMovieList)
        {
            $genreList = $this->genreDAO->getAll();
            $movieList = $filterMovieList;

            require_once(VIEWS_PATH."movie-dashboard.php");
            
            if($movieList == null)
            {
                ?>
                    <h4 class="text-white">No hay películas con el género elegido</h4>
                <?php 
            }
        }

        public function filterByGenre ($paramGenreId)
        {
            $movieList = $this->movieDAO->getAll();
            $filterMovieList = array();
            $genresId = array();

            foreach($movieList as $movieValue)
            {
                $genresId = $movieValue->getGenresId();

                foreach($genresId as $genreId)
                {
                    if($paramGenreId == $genreId)
                    {  
                        $filterMovie = $movieValue;

                        array_push($filterMovieList, $filterMovie);  
                    }
                }
            }

            $this->showFilterMovieDashboard($filterMovieList);     
        }
    }
?>