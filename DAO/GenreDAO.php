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
        $sqlQuery = "INSERT INTO Genre (id,nameGenre) 
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
        public function retrieveDataFromApi (){
            $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG . '&page=1');
            $genreList = ($moviedb) ? json_decode($moviedb, true)['runtime'] : array();
        /*    $finalList=array();
            foreach ($genreList as $gnr) {
               
               $name= $gnr['name'];
                $IdGenre = $gnr['id'];
         $genre=new Genre($IdGenre,$name);
                array_push($finalList,$genre);
                
            }*/
            return $genreList;
    }
}

?>