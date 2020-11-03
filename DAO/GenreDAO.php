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
        $sqlQuery = "INSERT INTO Genres (id,nameGenre) 
        VALUES (:id,:nameGenre)";
        $parameters["nameGenre"]=$genre->getName();
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

            $cinemaList = array();

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
        public function mapout ($value)
        {
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            return new Genre($p['id'],$p['nameGenre']);
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
        }

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
            
    }
}

?>