<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
<<<<<<< HEAD
    use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
    use Models\Movie as Movie;
=======
    use DAO\MoviesXGenresDAO as MoviesXGenreDAO;
use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
use Models\Movie as Movie;
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
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
<<<<<<< HEAD
            $this->moviesXgenresDAO = new MoviesXGenresDAO();
=======
            $this->moviesXgenresDAO=new MoviesXGenresDAO();
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
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
<<<<<<< HEAD
            $movieList = $this->movieDAO->getMoviesXgenres($idGenre);
=======
            $movieList = $this->movieDAO->getAll();
            $filterMovieList = array();
            $genresId = array();
// mod
            foreach($movieList as $movieValue)
            {
                $genresId = $movieValue->getGenresId();
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62

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