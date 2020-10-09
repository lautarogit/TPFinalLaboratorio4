<?php
    namespace Models;

    class Movie
    {
        private $id;
        private $title;
        private $adult;
        private $price;
        private $genres; //object {id, name}
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

        public function getAdult ()
        {
            return $this->adult;
        }

        public function getPrice ()
        {
            return $this->price;
        }

        public function getGenres ()
        {
            return $this->genres;
        }

        public function getOriginalLanguage ()
        {
            return $this->originalLanguage;
        }

        public function getPopularity ()
        {
            return $this->popularity;
        }

        public function getPosterPath ()
        {
            return $this->posterPath;
        }

        public function getReleaseDate ()
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

        public function setAdult ($adult)
        {
            $this->adult = $adult;
        }

        public function setPrice ($price)
        {
            $this->price = $price;
        }

        public function setGenres (Genre $genres)
        {
            $this->genres = $genres;
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