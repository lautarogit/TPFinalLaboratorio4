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
        $genreId = $movie->getGenresId();
        $originalLanguage = $movie->getOriginalLanguage();
        $popularity = $movie->getPopularity();
        $posterPath = $movie->getPosterPath();
        $releaseDate = $movie->getReleaseDate();
        $status = $movie->getStatus();
        /* fijarse los parametros en bbdd*/
        $sqlQuery = "INSERT INTO MOVIES (id,title,overview,adult,idGenre,originalLanguage,popularity,posterPath,releaseDate,status) 
        values(:id,:title,:overview,:adult,:genreId,:originalLanguage,:popularity,:posterPath,:releaseDate,:status)";
        $parameters['id'] = $id;
        $parameters['title'] = $title;
        $parameters['overview'] = $overview;
        $parameters['adult'] = $adult;
        $parameters['genreId'] = $genreId;
        $parameters['originalLanguage'] = $originalLanguage;
        $parameters['popularity'] = $popularity;
        $parameters['posterPath'] = $posterPath;
        $parameters['releaseDate'] = $releaseDate;
        $parameters['status'] = $status;
        try {
            $this->connection = Connection::getInstance();

            return $this->connection->executeNonQuery($sqlQuery, $parameters);
        } catch (PDOException $ex) {
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
        if (!is_array($result)) {
            array_push($movieList, $result);
        } else {
            $result = false;
        }
        if (!empty($movieList)) {
            $finalResult = $movieList;
        } else {
            $finalResult = $result;
        }

        return $finalResult;
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

    public function getRuntinme()
    {
        $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG . '&page=1');
        $movieList = ($moviedb) ? json_decode($moviedb, true)['results'] : array();
        foreach ($movieList as $movie) {
        $runtime = $movie['runtime'];
         return $runtime;
        }
    }
    public function retrieveDataFromAPI()
    {
        $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG . '&page=1');
        $movieList = ($moviedb) ? json_decode($moviedb, true)['results'] : array();

        foreach ($movieList as $movie) {
    
            $id = $movie['id'];
            $title = $movie['title'];
            $overview = $movie['overview'];
            $adult = $movie['adult'];

            $genresId = $movie['genre_ids'];
            $originalLanguage = $movie['original_language'];
            $popularity = $movie['popularity'];
            $posterPath = $movie['poster_path'];
            $releaseDate = $movie['release_date'];
            $status = null;
            $newMovie = new Movie($id,$title,$overview,$adult,null,$originalLanguage,$popularity,$posterPath,$releaseDate,$status);
    /*        $newMovie->setId($id);
            $newMovie->setTitle($title);
            $newMovie->setOverview($overview);
            $newMovie->setAdult($adult);
            //      $newMovie->setGenresId($genresId);
            $newMovie->setOriginalLanguage($originalLanguage);
            $newMovie->setPopularity($popularity);
            $newMovie->setPosterPath($posterPath);
            $newMovie->setReleaseDate($releaseDate);
            $newMovie->setStatus($status);*/


            $this->add($newMovie);
        }
    }
    public function retrieveDataFromAPI2()
    {
        $moviedb = file_get_contents(API_HOST . '/movie/now_playing?api_key=' . TMDB_API_KEY . '&language=' . LANG . '&page=1');
        $movieList = ($moviedb) ? json_decode($moviedb, true) : array();
$finalResult=array();
        foreach ($movieList as $movie) {
   $runtime= $movie["Runtime"];
      /*      $id = $movie['id'];
            $title = $movie['title'];
            $overview = $movie['overview'];
            $adult = $movie['adult'];

            $genresId = $movie['genre_ids'];
            $originalLanguage = $movie['original_language'];
            $popularity = $movie['popularity'];
            $posterPath = $movie['poster_path'];
            $releaseDate = $movie['release_date'];
            $status = null;
            $newMovie = new Movie($id,$title,$overview,$adult,null,$originalLanguage,$popularity,$posterPath,$releaseDate,$status);
  
*/
        //    $this->add($newMovie);
    array_push($finalResult,$runtime);   
    }
    return $finalResult;
    }

    public function mapout($value)
    {
        $value = is_array($value) ? $value : [];

        $resp = array_map(function ($p) {
            return new Movie($p['id'], $p['title'], $p['overview'], $p['adult'], $p['genre_ids'], $p['originalLanguage'], $p['popularity'], $p['posterPath'], $p['releaseDate'], $p['status']);
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
}
