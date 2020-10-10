<?php
    namespace DAO;
    
    use Models\Movie as Movie;
    use DAO\MovieAPI_DAO as MovieAPI_DAO;

    class MovieDAO 
    {
        private $movieAPI_DAO = new MovieAPI_DAO();
        private $movieList = array();

        public function setAll()
        {
            $this->movieList = $this->movieAPI_DAO->getAll();
            $this->saveData();
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
            $jsonPath = $this->getJsonFilePath();
            
            foreach ($this->movieList as $movie) 
            {
                $arrayValue['title'] = $movie->getTitle();

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
                $movie = new Movie($arrayValue['title']);
                
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