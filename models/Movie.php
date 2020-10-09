<?php
<<<<<<< HEAD
namespace Models;

class Movie
{
    private $adult;
    private $backdrop_path;
    private $belongs_to_collection;
    private $budget;
    private $genres; //object {id, name}
    private $homepage ;
    private $id;
    private $imdb_id;
    private $original_language;
    private $original_title;
    private $overview;
    private $popularity;
    private $poster_path;
    private $production_companies; //object {id, name, logo_path, origin_country}
    private $production_countries; //object {iso_3166_1, name}
    private $release_date;
    private $revenue;
    private $runtime;
    private $spoken_languages; //object {iso_639_1, name}
    private $status;
    private $tagline;
    private $title;
    private $video;
    private $vote_average;
    private $vote_count;

    public function getTitle ()
    {
        return $this->title;
    }

    public function getId ()
    {
        return $this->id;
    }

     public function setTitle ($title)
    {
        $this->title = $title;
    }

    public function setId ($id)
    {
        $this->id = $id;
    }
}
=======
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
>>>>>>> b3fd2d9fb23f10ec7d68377539251a77806cdee7
?>