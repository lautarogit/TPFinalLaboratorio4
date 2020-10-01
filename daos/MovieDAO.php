<?php
    namespace DAO;
    
    use Models\Movie as Movie;

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
            $this->retrieveData();
            return $this->movieList;
        }

        /*public function delete($code)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->movieList as $movie) 
            {
                if($movie->getCode() != $code)
                {
                    array_push($newList, $movie);
                }
            }

            $this->movieList = $newList;
            $this->saveData();
        }*/

        private function saveData()
        {
            $arrayToEncode = array();

            foreach ($this->movieList as $movie) 
            {
                $arrayValue['title'] = $movie->getTitle();
                $arrayValue['id'] = $movie->getId();

                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents('../data/movies.json', $jsonContent);
        }

        private function retrieveData()
        {
            $this->movieList = array();
            $jsonPath = $this->GetJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $movie = new Movie($arrayValue['title'], $arrayValue['id']);
                
                array_push($this->movieList, $movie);
            }
        }

        function GetJsonFilePath()
        {
            $initialPath = "data/movies.json";

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