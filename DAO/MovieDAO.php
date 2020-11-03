<?php

    namespace DAO;

    use Models\Movie as Movie;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class MovieDAO
    {
        private $connection;
        
        public function add(Movie $movie)
        {
            $id = $movie->getId();
            $title = $movie->getTitle();
            $overview = $movie->getOverview();
            $adult = $movie->getAdult();
            $originalLanguage = $movie->getOriginalLanguage();
            $popularity = $movie->getPopularity();
            $posterPath = $movie->getPosterPath();
            $releaseDate = $movie->getReleaseDate();
            $status = $movie->getStatus();
            $runtime = $movie->getRuntime();

            $sqlQuery = "INSERT INTO MOVIES (id, title, overview, adult, originalLanguage, popularity, posterPath, releaseDate, status, runtime) 
            VALUES(:id, :title, :overview, :adult, :originalLanguage, :popularity, :posterPath, :releaseDate, :status, :runtime)";

            $parameters['id'] = $id;
            $parameters['title'] = $title;
            $parameters['overview'] = $overview;
            $parameters['adult'] = $adult;
            $parameters['originalLanguage'] = $originalLanguage;
            $parameters['popularity'] = $popularity;
            $parameters['posterPath'] = $posterPath;
            $parameters['releaseDate'] = $releaseDate;
            $parameters['status'] = $status;
            $parameters['runtime'] = $runtime;

            try 
            {
                $this->connection = Connection::getInstance();

                return $this->connection->executeNonQuery($sqlQuery, $parameters);
            } 
            catch (PDOException $ex) 
            {
                throw $ex;
            }
        }
        public function getAll()
        {
            $sqlQuery = "SELECT * FROM movies";
            try {
                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($sqlQuery);
           
            } catch (PDOException $ex) {
                throw $ex;
            }
            if (!empty($result)) {
                $result = $this->mapout($result);

                $movieList = array();
            }
         
            else{

            $result=false;

             }

            return $result;
        }
        public function getMovieById($idMovie)
        {
            $sqlQuery = "SELECT * FROM rooms Where id=:id";
            $parameters['id'] = $idMovie;

            try {
                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($sqlQuery, $parameters);
            } catch (PDOException $ex) {
                throw $ex;
            }
            if (!empty($resultSet)) {
                $movie = $this->mapout($resultSet);
            } else {
                $movie = false;
            }
            return $movie;
        }

        public function getRuntime()
        {
            $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG);
            $movieList = ($moviedb) ? json_decode($moviedb, true)['results'] : array();
            foreach ($movieList as $movie) {
            $runtime = $movie['runtime'];
            return $runtime;
            }
        }

        private function setRuntime ($id)
        {
            $moviedb = file_get_contents(API_HOST.'/movie/'.$id.'?api_key='.TMDB_API_KEY.'&language='.LANG);
            $movie = json_decode($moviedb, TRUE);

            $runtime = $movie['runtime'];


            intval($runtime);

            return $runtime;
        }
        public function getGenres (Movie $movie){
            
            $sqlQuery =     "SELECT g.id, g.nameGenre FROM genres g inner join MoviesXgenres r on g.id=r.idGenre inner join movies m on r.idMovie = m.id where m.id= :id";
       $parameters['id']=$movie->getId();
            try
            {
                $this->connection = Connection::getInstance();
            
                $result = $this->connection->execute($sqlQuery,$parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($result))
            {
                $result = $this->mapout($result);
            }
            else 
            {
                $result =  false;
            }

            return $result;
        }

        public function retrieveDataFromAPI()
        {
            $moviedb = file_get_contents(API_HOST.'/movie/now_playing?api_key='.TMDB_API_KEY.'&language='.LANG);
            $movieList = ($moviedb) ? json_decode($moviedb, true)['results'] : array();

            foreach ($movieList as $movie) 
            {  
                $id = $movie['id'];
                $title = $movie['title'];
                $overview = $movie['overview'];
                $adult = $movie['adult'];
                $originalLanguage = $movie['original_language'];
                $popularity = $movie['popularity'];
                $posterPath = $movie['poster_path'];
                $releaseDate = $movie['release_date'];
                $status = 0;
                $runtime = $this->setRuntime($id);

                $newMovie = new Movie($id, $title, $overview, $adult,
                $originalLanguage, $popularity, $posterPath, $releaseDate, $status, $runtime);
       
                $this->add($newMovie);
            }
        }

        public function mapout($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function ($p) {
                return new Movie($p['id'], $p['title'], $p['overview'], $p['adult'], $p['originalLanguage'], $p['popularity'], 
                $p['posterPath'], $p['releaseDate'], $p['status'], $p['runtime']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
