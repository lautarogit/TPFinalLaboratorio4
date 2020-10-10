<?php
    namespace DAO;

    class MovieAPI_DAO 
    {
        private $movieList = array();
        
        public function getAll()
        {
            $this->movieList = file_get_contents('https://api.themoviedb.org/3/movie/550?api_key='.TMDB_API_KEY.'&language=es-MX&page=1');
            $this->movieList = json_decode($this->movieList, true);
            return $this->movieList;
        }
    }
?>