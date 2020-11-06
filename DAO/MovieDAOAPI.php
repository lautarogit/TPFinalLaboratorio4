<?php
    namespace DAO;
    
    use Models\Movie as Movie;

    class MovieDAOAPI
    {
        private $movieList = array();
        
        public function add(Movie $newMovie)
        {
            $this->retrieveData();
            array_push($this->movieList, $newMovie);
            $this->saveData();
        }

        public function getAll()
        {
            if($this->movieList !== [])
            {
                $this->retrieveDataFromApi();
            }
            else
            {
                $this->retrieveData();
            }
            
            return $this->movieList;
        }

        public function getMovieById ($idMovie)
        {
            $this->retrieveData();
            $movie = new Movie();

            foreach($this->movieList as $movieValue)
            {
                if($movieValue->getId() == $idMovie)
                {
                    $movie = $movieValue;
                }
            }

            return $movie;
        }
        private function setRuntime ($id)
        {
            $moviedb = file_get_contents(API_HOST.'/movie/'.$id.'?api_key='.TMDB_API_KEY.'&language='.LANG);
            $movie = json_decode($moviedb, TRUE);

            $runtime = $movie['runtime'];

            intval($runtime);

            return $runtime;
        }

        public function retrieveDataFromApi()
        {
            $moviedb = file_get_contents(API_HOST.'/movie/now_playing?api_key='.TMDB_API_KEY.'&language='.LANG.'&page=1');
            
            $this->movieList = ($moviedb) ? json_decode($moviedb, TRUE)['results'] : array();

            $finalList=array();

            foreach($this->movieList as $movie)
            {
                $newMovie = new Movie();
                $id = $movie['id'];
                $title = $movie['title'];
                $overview = $movie['overview'];
                $adult = $movie['adult'];
                $originalLanguage = $movie['original_language'];
                $popularity = $movie['popularity'];
                $posterPath = $movie['poster_path'];  
                $releaseDate = $movie['release_date'];
                $status = null;

                $newMovie->setId($id);
                $newMovie->setTitle($title);
                $newMovie->setOverview($overview);
                $newMovie->setAdult($adult);
                $newMovie->setOriginalLanguage($originalLanguage);
                $newMovie->setPopularity($popularity);
                $newMovie->setPosterPath($posterPath);
                $newMovie->setReleaseDate($releaseDate);
                $newMovie->setStatus($status);
                $newMovie->setRuntime($this->setRuntime($id));

                array_push($finalList,$newMovie);
            }
            return $finalList;
        }


        private function saveData()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();
            
            foreach ($this->movieList as $movie) 
            {
                $arrayValue['id_movie'] = $movie->getId();
                $arrayValue['title'] = $movie->getTitle();
                $arrayValue['overview'] = $movie->getOverview();
                $arrayValue['adult'] = $movie->getAdult();
                $arrayValue['original_language'] = $movie->getOriginalLanguage();
                $arrayValue['popularity'] = $movie->getPopularity();
                $arrayValue['poster_Path'] = $movie->getPosterPath();
                $arrayValue['release_date'] = $movie->getReleaseDate();
                $arrayValue['runtime'] = $movie->getRuntime();

                array_push($arrayToEncode, $arrayValue);
            }
            
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }

        private function retrieveData()
        {
            $this->movieList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $movie = new Movie();
                $id = $arrayValue['id_movie'];
                $title = $arrayValue['title'];
                $overview = $arrayValue['overview'];
                $adult = $arrayValue['adult'];
                $originalLanguage = $arrayValue['original_language'];
                $popularity = $arrayValue['popularity'];
                $posterPath = $arrayValue['poster_Path'];  
                $releaseDate = $arrayValue['release_date'];
                $status = null;
                $runtime = $arrayValue['runtime'];

                $movie->setId($id);
                $movie->setTitle($title);
                $movie->setOverview($overview);
                $movie->setAdult($adult);
                $movie->setOriginalLanguage($originalLanguage);
                $movie->setPopularity($popularity);
                $movie->setPosterPath($posterPath);
                $movie->setReleaseDate($releaseDate);
                $movie->setStatus($status);
                $movie->setRuntime($runtime);
                
                array_push($this->movieList, $movie);
            }
        }

        function getJsonFilePath()
        {
            $initialPath = "Data/movies.json";

            if(file_exists($initialPath))
            {
                $jsonFilePath = $initialPath;
            }
            else
            {
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }
?>