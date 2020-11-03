<?php
    namespace DAO;
        
    use Models\Genre as Genre;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class GenreDAO
    {
<<<<<<< HEAD
<<<<<<< HEAD
        private $connection;
=======
        $sqlQuery = "INSERT INTO Genres (id,nameGenre) 
        VALUES (:id,:nameGenre)";
        $parameters["nameGenre"]=$genre->getName();
        $parameters['id'] = $genre->getId();
     
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
=======
        private $connection;
>>>>>>> lautaro2

        public function add (Genre $genre)
        {
            $sqlQuery = "INSERT INTO Genres (id, nameGenre) 
            VALUES (:id, :nameGenre)";

            $parameters["nameGenre"] = $genre->getName();
            $parameters['id'] = $genre->getId();
        
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

        public function getAll ()
        {
            $sqlQuery = "SELECT * FROM genres";
            
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

                $genreList = array();

                if(!is_array($result))
                {
                    array_push($genreList, $result);
                }
            }
            else 
<<<<<<< HEAD
            {
                $result =  false;
            }

            if(!empty($genreList))
            {
                $finalResult = $genreList;  
            }
            else
            {
                $finalResult = $result;
            }

=======
            {
                $result =  false;
            }

            if(!empty($genreList))
            {
                $finalResult = $genreList;  
            }
            else
            {
                $finalResult = $result;
            }

>>>>>>> lautaro2
            return $finalResult;
        }

        public function getGenres ($movie)
        {  
            $sqlQuery = "SELECT g.id, g.nameGenre 
            FROM genres g 
            INNER JOIN MoviesXgenres r 
            ON g.id = r.idGenre 
            INNER JOIN movies m 
            ON r.idMovie = m.id 
            WHERE m.id = :id";

            $parameters['id'] = $movie->getId();

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

                $genreList = array();

                if(!is_array($result))
                {
                   array_push($genreList, $result);
                }
            }
            else 
            {
                $result =  false;
            }

            if(!empty($genreList))
            {
                $finalResult = $genreList;  
            }
            else
            {
                $finalResult = $result;
            }

            return $finalResult;
        }
            
        public function relateGenreMovie ($id)
        {  
            $sqlQuery ="SELECT * FROM movies m 
            INNER JOIN MoviesXgenres r 
            ON m.id = r.idMovie 
            INNER JOIN genres 
            ON g.id = r.idGenre 
            WHERE m.id = :id";

            $parameters['id'] = $id;
                
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
            
        public function retrieveDataFromApi ()
        {
            $moviedb = file_get_contents(API_HOST.'/genre/movie/list?api_key='.TMDB_API_KEY.'&language='.LANG);
            $genreList = ($moviedb) ? json_decode($moviedb, true)['genres']: array();

            foreach ($genreList as $genreValue) 
            {
                $name = $genreValue['name'];
                $IdGenre = $genreValue['id'];
                $genre = new Genre($IdGenre, $name);
                
                $this->add($genre); 
            }    
        }

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];
<<<<<<< HEAD

            $resp = array_map(function($p){
                return new Genre($p['id'], $p['nameGenre']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
<<<<<<< HEAD
=======

        public function getGenres ( $movie){
            
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
        
        public function relateGenreMovie(){
            
                $sqlQuery ="SELECT * FROM movies m inner join MoviesXgenres r on m.id=r.idMovie inner join genres on g.id = r.idGenre where m.id = :id";
            
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
        public function retrieveDataFromApi (){
            $moviedb= file_get_contents(API_HOST.'/genre/movie/list?api_key='.TMDB_API_KEY.'&language='.LANG);
            $genreList = ($moviedb) ? json_decode($moviedb, true)['genres']: array();
           $finalList=array();
            foreach ($genreList as $gnr) {
               
               $name= $gnr['name'];
                $IdGenre = $gnr['id'];
         $genre=new Genre($IdGenre,$name);
            
            $this->add($genre);    
            }
            
>>>>>>> 4d40689db52b9707d72e2ba89254201cb50a4f62
=======

            $resp = array_map(function($p){
                return new Genre($p['id'], $p['nameGenre']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
>>>>>>> lautaro2
    }
?>