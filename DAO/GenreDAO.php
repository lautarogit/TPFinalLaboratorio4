<?php
    namespace DAO;
        
    use Models\Genre as Genre;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class GenreDAO
    {
        private $connection;

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

            $resp = array_map(function($p){
                return new Genre($p['id'], $p['nameGenre']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>