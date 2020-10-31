<?php

    namespace Models;
    use Models\Genre as Genre;

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
    }

?>