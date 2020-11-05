<?php
    namespace DAO;
    
    use Models\Genre as Genre;
    
    class GenreDAOJSON
    {
        private $genreList = array();
        
        public function add(Genre $newGenre)
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
            $genre = new Genre();

            foreach($this->genreList as $genreValue)
            {
                if($genreValue->getId() == $idGenre)
                {
                    $genre = $genreValue;
                }
            }

            return $genre;
        }
/*
        public function retrieveDataFromAPI()
        {
            $genresdb = file_get_contents(API_HOST.'/genre/movie/list?api_key='.TMDB_API_KEY.'&language='.LANG);
            $this->genreList = ($genresdb) ? json_decode($genresdb, TRUE)['genres'] : array();

            foreach($this->genreList as $genre)
            {
                $id = $genre['id'];
                $name = $genre['name'];

                $newGenre = new Genre();

                $newGenre->setId($id);
                $newGenre->setName($name);

                $this->add($newGenre);
            }
        }*/

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

        private function retrieveData()
        {
            $this->genreList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $genre = new Genre();
                $id = $arrayValue['id'];
                $name = $arrayValue['name'];

                $genre->setId($id);
                $genre->setName($name);

                array_push($this->genreList, $genre);
            }
        }
        public function retrieveDataFromApi ()
        {
            $moviedb = file_get_contents(API_HOST.'/genre/movie/list?api_key='.TMDB_API_KEY.'&language='.LANG);
            $genreList = ($moviedb) ? json_decode($moviedb, true)['genres']: array();
            $finalList=array();
            foreach ($genreList as $genreValue) 
            {
                $name = $genreValue['name'];
                $IdGenre = $genreValue['id'];
                $genre = new Genre($IdGenre, $name);
              
                array_push($finalList,$genre);
            }    
            return $finalList;
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