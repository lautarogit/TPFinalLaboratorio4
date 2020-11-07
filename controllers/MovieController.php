<?php
    namespace Controllers;

    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
    use DAO\MoviesXGenresDAOAPI as MoviesXGenresDAOAPI;
    use DAO\GenreDAOAPI as GenreDAOAPI;
    use DAO\MovieDAOAPI as MovieDAOAPI;
    class MovieController
    {
        private $movieDAO;
        private $genreDAO;
        private $moviesXGenresDAO;      
        private $showDAO;
        private $genreDAOAPI;
        private $moviesXGenresDAOAPI;
        private $movieDAOAPI;

        public function __construct ()
        {
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->moviesXGenresDAO = new MoviesXGenresDAO();
            $this->genreDAOAPI = new GenreDAOAPI();
            $this->moviesXGenresDAOAPI=new MoviesXGenresDAOAPI();
            $this->movieDAOAPI= new MovieDAOAPI();
       
            $this->showDAO = new ShowDAO();
        }
    
        public function showMovieDashboard ($errorMessage = '')
        {
            $rolId = $_SESSION['loggedUser']->getRolId();

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

            $moviesXgenres = $this->moviesXgenresDAO->getAll();
            $genreDAO = $this->genreDAO;
            $showDAO = $this->showDAO;
            
            $topRatedMovieList = $this->filterTopRated($movieList);
            
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }
        public function addGenresToDB()
        {
          
           require_once(VIEWS_PATH."add-movies.php");
            $genreList=$this->genreDAOAPI->getAll();
         
            $genreDB=$this->genreDAO->getAll();

            foreach($genreList as $genre)
            {
             
                $this->genreDAOAPI->add($genre);
                if(!in_array($genre,$genreDB))
                {
                    $this->genreDAO->add($genre);
                    $flag=true;
                    $this->updateQuery ($flag);
                }
                else{
                      $flag = false;
                }
            
            }
            $this->updateQuery ($flag);
        }
    public function updateQuery($flag){
                if($flag){
      ?>
                      <div class="alert alert-success" role="alert">
                      Se ha cargado en la base de datos con exito
                       </div> 
      <?php
                  }
                  else{
      ?> 
                      <div class="alert alert-success" role="alert">
                        no hay nada que actualizar
                      </div>
      <?php
              }
      }
      
      
   
         
           
        
        public function addMoviesXGenresToDB()
        {
            require_once(VIEWS_PATH."add-movies.php");
            $moviesXgenreList=$this->MoviesXGenresDAOAPI->getAll();
         
            $moviesXgenresDB=$this->moviesXGenresDAO->getAll();

            foreach($moviesXgenresList as $mxg)
            {
             
                $this->moviesXGenresDAOAPI->add($mxg);
                if(!in_array($mxg,$moviesXGenresDB))
                {
                    $this->moviesXgenreDAO->add($mxg);
                    $flag=true;
                }
                else{
                    $flag = false;
                }
            }
            $this->updateQuery ($flag);
        }

        public function addMoviesToDB()
        {
            require_once(VIEWS_PATH."add-movies.php");      
          
        }
        public function addMovies(){
           require_once(VIEWS_PATH."add-movies.php");
           $moviesList= $this->movieDAOAPI->getAll();

        $moviesDB=$this->movieDAO->getAll();

            foreach($moviesList as $movies)
            {
        
                $this->movieDAOAPI->add($movies);
                if(!in_array($movies,$moviesDB))
                {
                    $this->movieDAO->add($movies);
                    $flag=true;
            
                }
                else{
                    $flag = false;
                }
            }

            $this->updateQuery ($flag);
        }

        public function showFilterMovieDashboard ($filterMovieList)
        {
            $moviesXgenres = $this->moviesXgenresDAO->getAll();
            $genreDAO = $this->genreDAO;
            $showDAO = $this->showDAO;
            $movieList = $filterMovieList;

            $topRatedMovieList = $this->filterTopRated($movieList);
            
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Movies/movie-dashboard.php");
        }

        public function filterByGenre ($idGenre)
        {
            $movieList = $this->movieDAO->getMoviesXgenres($idGenre);

            $this->showFilterMovieDashboard($movieList);  
            
            return $movieList;
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
