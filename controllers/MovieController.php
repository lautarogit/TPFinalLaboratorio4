<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
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
            $this->moviesXgenresDAO = new MoviesXGenresDAO();
        }

        public function showMovieDashboard ($errorMessage = '')
        {
            $movieList = $this->movieDAO->getAll();
            $genreList = $this->genreDAO->getAll();
            $moviesXgenres = $this->moviesXgenresDAO->getAll();
            $genreDAO = $this->genreDAO;

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function addMoviesToDB()
        {
            require_once(VIEWS_PATH."add-movies.php");
        }

        public function showFilterMovieDashboard ($filterMovieList)
        {
            $genreList = $this->genreDAO->getAll();
            $movieList = $filterMovieList;
            $genreDAO = $this->genreDAO;
            
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function filterByGenre ($idGenre)
        {
            $movieList = $this->movieDAO->getMoviesXgenres($idGenre);

            $this->showFilterMovieDashboard($movieList);     
        }

        public function filterTopRated ($movieList)
        {
            $movieList = $this->movieDAO->getAll();
            $filterMovieList = array();
            $popularityList = array();

            foreach($movieList as $movie)
            {
                $popularity = $movie->getPopularity();
                settype($popularity, "float");

                array_push($popularityList, $popularity);
            }

            sort($popularityList);

            $topRatedPopularityList = array();
            $popularityListSize = (count($popularityList)-1);

            for($i = $popularityListSize; $i >= 0 ; $i--)
            {
                if($i == ($popularityListSize-5))
                {
                    break;
                }
                else
                {
                    array_push($topRatedPopularityList, $popularityList[$i]);
                }
            }

            foreach($movieList as $movieValue)
            {
                foreach($topRatedPopularityList as $popularityValue)
                {
                    if($movieValue->getPopularity() == $popularityValue)
                    {
                        $filterMovie = $movieValue;
                        array_push($filterMovieList, $filterMovie); 
                    }
                }   
            }

            $topRatedMovieList = array();
            $filterMovieListSize = (count($filterMovieList)-1);

            for($i = $filterMovieListSize; $i >= 0 ; $i--)
            {
                array_push($topRatedMovieList, $filterMovieList[$i]);
            }
            
            return $topRatedMovieList;
        }
    }
?>