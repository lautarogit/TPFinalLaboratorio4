<?php
    namespace DAO;
    
    use Models\MoviesXGenres as MoviesXGenres;
    
    class GenreDAOJSON
    {
        private $genreList = array();
        
        public function add(MoviesXGenres $newGenre)
        {
            $this->retrieveData();
            array_push($this->genreList, $newGenre);
            $this->saveData();
        }

        public function getAll()
        {
            if($this->genreList !== [])
            {
                $this->retrieveDataFromAPI();
            }
            else
            {
                $this->retrieveData();
            }
            
            return $this->genreList;
        }

        public function getGenreById ($idGenre)
        {
            $this->retrieveData();
            $genre = new MoviesXGenres();

            foreach($this->genreList as $genreValue)
            {
                if($genreValue->getId() == $idGenre)
                {
                    $genre = $genreValue;
                }
            }

            return $genre;
        }


        private function saveData()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();
            
            foreach ($this->genreList as $genre) 
            {
                $arrayValue['id'] = $genre->getId();
                $arrayValue['name'] = $genre->getName();

                array_push($arrayToEncode, $arrayValue);
            }
            
            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }
        public function retrieveDataFromApi ()
        {
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
                   array_push($finalList,$genre);
                }
            }
        }


        private function retrieveData()
        {
            $this->genreList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $genre = new MoviesXGenres();
                $idGenre = $arrayValue['idGenre'];
                $idMovie = $arrayValue['IdMovie'];

                $genre->setIdGenre($idGenre);
                $genre->setIdMovie($idMovie);

                array_push($this->genreList, $genre);
            }
        }
     

        function getJsonFilePath()
        {
            $initialPath = "Data/genres.json";

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