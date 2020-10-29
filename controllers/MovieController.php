<?php
    namespace Controllers;

    use DAO\MovieDAOJSON as MovieDAOJSON;
    use DAO\GenreDAOJSON as GenreDAOJSON;
    use Models\Movie as Movie;
    use Models\Genre as Genre;

    class MovieController
    {
        private $movieDAO;
        private $genreDAO;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAOJSON();
            $this->genreDAO = new GenreDAOJSON();
        }

        public function showMovieDashboard ()
        {
            $movieList = $this->movieDAO->getAll();
            $genreList = $this->genreDAO->getAll();
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."movie-dashboard.php");
        }

        public function showBillboard ($idMovie)
        {
            $movie = new Movie();
            $movie = $this->movieDAO->getMovieById($idMovie);
            $genreList = $this->genreDAO->getAll();

            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."billboard.php");
        }

        public function showFilterMovieDashboard ($filterMovieList)
        {
            $genreList = $this->genreDAO->getAll();
            $movieList = $filterMovieList;
            
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."movie-dashboard.php");
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