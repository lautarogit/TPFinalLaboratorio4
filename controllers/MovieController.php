<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
    use DAO\MoviesXGenresDAOAPI as MoviesXGenresDAOAPI;
    use DAO\GenreDAOAPI as GenreDAOAPI;
    use DAO\MovieDAOAPI as MovieDAOAPI;
    use Controllers\HomeController as HomeController;

    class MovieController
    {
        private $movieDAO;
        private $genreDAO;
        private $moviesXGenresDAO;      
        private $showDAO;
        private $genreDAOAPI;
        private $moviesXGenresDAOAPI;
        private $movieDAOAPI;
        private $homeController;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->moviesXGenresDAO = new MoviesXGenresDAO();
            $this->genreDAOAPI = new GenreDAOAPI();
            $this->moviesXGenresDAOAPI = new MoviesXGenresDAOAPI();
            $this->movieDAOAPI = new MovieDAOAPI();
            $this->showDAO = new ShowDAO();
            $this->homeController = new HomeController();
        }
    
        public function actionDisabled ()
        {
            $errorMessage = true;

            $this->showMovieDashboard($errorMessage);
        }

        public function showMovieDashboard ($errorMessage = '')
        {
            if(!empty($_SESSION['loggedUser']))
            {
                $rolId = $_SESSION['loggedUser']->getRolId();
            }

            $movieList = $this->movieDAO->getAll();
            $availableMovieList = array();

            foreach($movieList as $movieValue)
            {  
                $idMovie = $movieValue->getId();
                $showMapout = $this->showDAO->getShowByIdMovie($idMovie);

                if(!empty($showMapout))
                {
                    array_push($availableMovieList, $movieValue);
                }
            }

            $movieList = $availableMovieList;

            $moviesXgenres = $this->moviesXGenresDAOAPI->getAll();
            $genreDAO = $this->genreDAO;
            $showDAO = $this->showDAO;
            
            $topRatedMovieList = $this->filterTopRated($movieList);
            
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function addMoviesXGenresToDB()
        {
            require_once(VIEWS_PATH."add-movies.php");
            $moviesXgenresList = $this->moviesXGenresDAOAPI->retrieveDataFromApi();
            $mxgDB = $this->moviesXGenresDAO->getAll();

            foreach($moviesXgenresList as $mxg)
            {
                $this->moviesXGenresDAOAPI->add($mxg);

                if(!empty($mxgDB))
                {
                    if(!in_array($mxg,$mxgDB))
                    {
                        $flag=true;
                        $this->moviesXGenresDAO->add($mxg);

                    }
                    else
                    {
                        $flag = false;
                    }
                }
                else
                {
                    $flag=true;
                    $this->moviesXGenresDAO->add($mxg);
                }
            }

            $this->updateQuery ($flag);
        }

        public function addMoviesToDB ()
        {
            require_once(VIEWS_PATH."add-movies.php");
        }

        public function addMovies()
        {
            require_once(VIEWS_PATH."add-movies.php");
            $moviesList= $this->movieDAOAPI->getAll();

            foreach($moviesList as $movies)
            {
                $this->movieDAOAPI->add($movies);

                $result=$this->movieDAO->add($movies);

                if($result)
                {
                    $flag=true;
                }
                else
                {
                    $flag=false;
                }

            }

            $this->updateQuery ($flag);
        }

        public function addGenresToDB ()
        {
            require_once(VIEWS_PATH."add-movies.php");
            $genreList = $this->genreDAOAPI->getAll();

            $genreDB = $this->genreDAO->getAll();

            foreach($genreList as $genre)
            {

                $this->genreDAOAPI->add($genre);

                if(!in_array($genre,$genreDB))
                {
                    $this->genreDAO->add($genre);
                    $flag=true;
                    $this->updateQuery ($flag);
                }
                else
                {
                      $flag = false;
                }
            }

            $this->updateQuery ($flag);
        }

        public function updateQuery($flag)
        {
            if($flag)
            {
                $errorMessage = "Se ha cargado con éxito en la base de datos";
            }
            else
            {
                $errorMessage = true;
            }

            $this->homeController->showAdministratorPanel($errorMessage);
        }

        public function showFilterMovieDashboard ($filterMovieList, $date = '')
        {
            $moviesXgenres = $this->moviesXGenresDAOAPI->getAll();
            $genreDAO = $this->genreDAO;
            $showDAO = $this->showDAO;
            $movieList = $filterMovieList;

            $topRatedMovieList = $this->filterTopRated($movieList);
            
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function filterByGenre ($idGenre)
        {
            $movieList = $this->movieDAO->getMoviesXgenres($idGenre);

            $this->showFilterMovieDashboard($movieList);  
            
            return $movieList;
        }

        public function filterByDate ($date)
        {
            if(!empty($date))
            {
                if(!empty($_SESSION['loggedUser']))
                {
                    $rolId = $_SESSION['loggedUser']->getRolId();
                }

                $movieList = $this->movieDAO->getAll();
                $availableMovieList = array();
                $showMapoutList = $this->showDAO->getAll();

                if(!empty($showMapoutList))
                {
                    $i = 0;

                    foreach($movieList as $movie)
                    {
                        for($i = 0; $i < count($showMapoutList); $i++)
                        {  
                            $showMapoutDate = substr($showMapoutList[$i]->getDateTime(), 0, 10);
                                
                            if($showMapoutDate == $date && $showMapoutList[$i]->getIdMovie() == $movie->getId())
                            {  
                                array_push($availableMovieList, $movie);
                            }  
                        }
                    }
                }
    
                $movieList = $availableMovieList;

                $this->showFilterMovieDashboard($movieList, $date);
            }
            else
            {
                $errorMessage = "No ingreso fecha a filtrar";
                $this->showMovieDashboard($errorMessage);
            }
        }

        public function returnGenresAvailabe ()
        {
            $genreList = $this->genreDAO->getAll();
            $filterGenreList = array();

            if(!empty($genreList))
            {
                foreach($genreList as $genre)
                {
                    $genreFinded = $this->filterByGenre($genre->getId());
    
                    if(!empty($genreFinded))
                    {
                        array_push($filterGenreList, $genre);
                    }
                }
            }

            return $filterGenreList;
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
