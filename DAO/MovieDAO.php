<?php
    namespace DAO;
    
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    
    class MovieDAO 
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
            $this->retrieveDataFromAPI();
            return $this->movieList;
        }

        public function retrieveDataFromAPI ()
        {
            $this->movieList;
            $moviedb = file_get_contents(API_HOST.'/movie/now_playing?api_key='.TMDB_API_KEY.'&language='.LANG.'&page=1');
            $movieList = json_decode($moviedb, TRUE)['results'];

            foreach($movieList as $movie)
            {
                $id = $movie['id'];
                $title = $movie['title'];
                $overview = $movie['overview'];
                $adult = $movie['adult'];
                $genres = new Genre();
                $genres = $movie['genres_ids'];
                $originalLanguage = $movie['original_language'];
                $popularity = $movie['popularity'];
                $posterPath = $movie['poster_path'];  
                $releaseDate = $movie['release_date'];
                $status = null;

                $newMovie = new Movie();
                
                $newMovie->setId($id);
                $newMovie->setTitle($title);
                $newMovie->setOverview($overview);
                $newMovie->setAdult($adult);
                $newMovie->setGenres($genres);
                $newMovie->setOriginalLanguage($originalLanguage);
                $newMovie->setPopularity($popularity);
                $newMovie->setPosterPath($posterPath);
                $newMovie->setReleaseDate($releaseDate);
                $newMovie->setStatus($status);

                $this->add($newMovie);
            }
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
                $arrayValue['genres'] = $movie->getGenres();
                $arrayValue['original_language'] = $movie->getOriginalLanguage();
                $arrayValue['popularity'] = $movie->getPopularity();
                $arrayValue['poster_Path'] = $movie->getPosterPath();
                $arrayValue['release_date'] = $movie->getReleaseDate();

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
                $genres = $arrayValue['genres'];
                $originalLanguage = $arrayValue['original_language'];
                $popularity = $arrayValue['popularity'];
                $posterPath = $arrayValue['poster_Path'];  
                $releaseDate = $arrayValue['release_date'];
                $status = null;

                $movie->setId($id);
                $movie->setTitle($title);
                $movie->setOverview($overview);
                $movie->setAdult($adult);
                $movie->setGenres($genres);
                $movie->setOriginalLanguage($originalLanguage);
                $movie->setPopularity($popularity);
                $movie->setPosterPath($posterPath);
                $movie->setReleaseDate($releaseDate);
                $movie->setStatus($status);

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