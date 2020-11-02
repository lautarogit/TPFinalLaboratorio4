<?php
    namespace Models;

    class Movie
    {
        private $id;
        private $title;
        private $overview;
        private $adult;
        private $genresId;
        private $originalLanguage;
        private $popularity;
        private $posterPath;
        private $releaseDate;
        private $status;
        private $runtime;

        public function __construct($id = '', $title = '', $overview = '', $adult = '', $genresId = '', 
        $originalLanguage = '', $popularity = '', $posterPath = '', $releaseDate = '', $status = '', $runtime = '')
        {
            $this->id = $id;
            $this->title = $title;
            $this->overview = $overview;
            $this->adult = $adult;
            $this->genresId = $genresId;
            $this->originalLanguage = $originalLanguage;
            $this->popularity = $popularity;
            $this->posterPath = $posterPath;
            $this->releaseDate = $releaseDate;
            $this->status = $status;
            $this->runtime = $runtime;
        }
        
        public function getId ()
        {
            return $this->id;
        }

        public function getTitle ()
        {
            return $this->title;
        }

        public function getOverview()
        {
            return $this->overview;
        }

        public function getAdult()
        {
            return $this->adult;
        }

        public function getGenresId ()
        {
            return $this->genresId;
        }

        public function getOriginalLanguage ()
        {
            return $this->originalLanguage;
        }

        public function getPopularity ()
        {
            return $this->popularity;
        }

        public function getPosterPath()
        {
            return $this->posterPath;
        }

        public function getReleaseDate()
        {
            return $this->releaseDate;
        }
        
        public function getStatus ()
        {
            return $this->status;
        }

        public function getRuntime ()
        {
            return $this->runtime;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setTitle ($title)
        {
            $this->title = $title;
        }

        public function setOverview ($overview)
        {
            $this->overview = $overview;
        }

        public function setAdult ($adult)
        {
            $this->adult = $adult;
        }

        public function setGenresId ($genresId)
        {
            $this->genresId = $genresId;
        }

        public function setOriginalLanguage ($originalLanguage)
        {
            $this->originalLanguage = $originalLanguage;
        }

        public function setPopularity ($popularity)
        {
            $this->popularity = $popularity;
        }

        public function setPosterPath ($posterPath)
        {
            $this->posterPath = $posterPath;
        }

        public function setReleaseDate ($releaseDate)
        {
            $this->releaseDate = $releaseDate;
        }
        
        public function setStatus ($status)
        {
            $this->status = $status;
        }

        public function setRuntime ($runtime)
        {
            $this->runtime = $runtime;
        }
    }

?>