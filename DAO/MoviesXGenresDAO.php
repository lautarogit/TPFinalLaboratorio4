<?php
    namespace DAO;
        
    use Models\MoviesXGenres as MoviesXGenres;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class MoviesXGenresDAO
    {
        private $connection;

        public function add (MoviesXGenres $movieXGenre)
        {
            $sqlQuery = "INSERT INTO moviesXgenres (idMovie, idGenre) 
            VALUES (:idMovie,:idGenre)";

            $parameters["idMovie"] = $movieXGenre->getIdMovie();
            $parameters['idGenre'] = $movieXGenre->getIdGenre();

            try
            {
                $this->connection = Connection::getInstance();

                return $this->connection->executeNonQuery($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
        }
<<<<<<< HEAD
=======
    }
    
        public function getAll ()
        {
        $sqlQuery = "SELECT * FROM MoviesXgenres";
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
        
        public function getAll ()
        {
            $sqlQuery = "SELECT * FROM moviesXgenres";
            
            try
            {
                $this->connection = Connection::getInstance();
            
                $result = $this->connection->execute($sqlQuery);
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
                $result = false;
            }

            return $result;
        }

        
        public function relateGender ()
        {
<<<<<<< HEAD
            $sqlQuery = "SELECT * FROM MoviesXgenres r 
            INNER JOIN movies m 
            ON r.idMovie = m.id";
            
            try
            {
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($sqlQuery);
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

        public function filterGenre ($id)
=======
            $result = $this->mapout($result);

       
        }
        else 
        {
            $result =  false;
        }

  

        return $result;
        }
        public function mapout ($value)
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
        {
            $sqlQuery = "SELECT m.id, r.idGenre FROM MoviesXgenres r 
            INNER JOIN movies m 
            ON r.idMovie = m.id 
            WHERE r.idGenre = :id";

            $parameters['id'] = $id;

            try
            {
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($sqlQuery, $parameters);
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
<<<<<<< HEAD

        public function retrieveDataFromApi ()
        {
=======
        public function relateGender(){
            $sqlQuery = "SELECT * FROM MoviesXgenres r inner join movies m on r.idMovie = m.id";
        
            try
            {
                $this->connection = Connection::getInstance();
            
                $result = $this->connection->execute($sqlQuery);
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
        public function filterGenre($id){
            $sqlQuery = "SELECT * FROM MoviesXgenres r inner join movies m on r.idMovie = m.id where r.idGenre = :id";
            $parameters['id']=$id;
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
        public function retrieveDataFromApi (){
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
            $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG . '&page=1');
            $movieList = ($moviedb) ? json_decode($moviedb, true)['results'] : array();
            $finalList = array();

            foreach ($movieList as $movie) 
            {
                $idMovie = $movie['id'];
                $IdGenre = $movie['genre_ids'];

                foreach($IdGenre as $genre)
                {
                    $newMovie = new MoviesXGenres($idMovie,$genre);
                    $this->add($newMovie);
                }
            }
        }

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                return new MoviesXGenres($p['idMovie'], $p['idGenre']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>