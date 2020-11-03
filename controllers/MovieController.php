<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\MoviesXGenresDAO as MoviesXGenreDAO;
use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\MoviesXGenres as MoviesXGenres;

    class MovieController
    {
        private $movieDAO;
        private $genreDAO;
        private $moviesXgenresDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->moviesXgenresDAO=new MoviesXGenresDAO();
        }

        public function showMovieDashboard ($errorMessage = '')
        {
            $movieList = $this->movieDAO->getAll();
            $genreList = $this->genreDAO->getAll();
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function addMoviesToDB()
        {
            require_once(VIEWS_PATH."add-movies.php");
           // $this->movieDAO->retrieveDataFromAPI();
        }
        
        public function showBillboard ($idMovie)
        {
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieById($idMovie);
            $genreList = $this->genreDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Billboard/billboard.php");
        }

        public function showFilterMovieDashboard ($filterMovieList)
        {
            $genreList = $this->genreDAO->getAll();
            $movieList = $filterMovieList;
            
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function filterByGenre ($paramGenreId)
        {
            $movieList = $this->movieDAO->getAll();
            $filterMovieList = array();
            $genresId = array();
// mod
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

        public function filterTopRated ($movieList)
        {
            $movieList = $this->movieDAO->getAll();
            $filterMovieList = array();
            $popularityList = array();

            foreach($movieList as $movie)
            {
                $popularity = $movie->getPopularity();
                array_push($popularityList, $popularity);
            }

            arsort($popularityList);

            $topRatedPopularityList = array();

            for($i = 0; $i < 5 ; $i++)
            {
                $popularity = $popularityList[$i];
                array_push($topRatedPopularityList, $popularity);
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

            $this->showFilterMovieDashboard($filterMovieList);

            return $filterMovieList;
        }
    }
?>