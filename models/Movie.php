<?php
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
    public function getAdult()
    {
        return $this->adult;
    }

    public function setAdult($adult)
    {
        $this->adult = $adult;

    }

    public function getBackdropPath()
    {
        return $this->backdrop_path;
    }

    public function setBackdropPath($backdrop_path)
    {
        $this->backdrop_path = $backdrop_path;

    }


    public function getBelongsToCollection()
    {
        return $this->belongs_to_collection;
    }

   
    public function setBelongsToCollection($belongs_to_collection)
    {
        $this->belongs_to_collection = $belongs_to_collection;

      
    }

    public function getBudget()
    {
        return $this->budget;
    }

 
    public function setBudget($budget)
    {
        $this->budget = $budget;

    }


    public function getGenres()
    {
        return $this->genres;
    }

  
    public function setGenres($genres)
    {
        $this->genres = $genres;

    }

    public function getHomepage()
    {
        return $this->homepage;
    }


    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

  
    }

    public function getId()
    {
        return $this->id;
    }

   
    public function setId($id)
    {
        $this->id = $id;

    }

    public function getImdbId()
    {
        return $this->imdb_id;
    }


    public function setImdbId($imdb_id)
    {
        $this->imdb_id = $imdb_id;

       
    }

   
    public function getOriginalLanguage()
    {
        return $this->original_language;
    }

    public function setOriginalLanguage($original_language)
    {
        $this->original_language = $original_language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    /**
     * @param mixed $original_title
     *
     * @return self
     */
    public function setOriginalTitle($original_title)
    {
        $this->original_title = $original_title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param mixed $overview
     *
     * @return self
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param mixed $popularity
     *
     * @return self
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosterPath()
    {
        return $this->poster_path;
    }

    /**
     * @param mixed $poster_path
     *
     * @return self
     */
    public function setPosterPath($poster_path)
    {
        $this->poster_path = $poster_path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductionCompanies()
    {
        return $this->production_companies;
    }

    /**
     * @param mixed $production_companies
     *
     * @return self
     */
    public function setProductionCompanies($production_companies)
    {
        $this->production_companies = $production_companies;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductionCountries()
    {
        return $this->production_countries;
    }

    /**
     * @param mixed $production_countries
     *
     * @return self
     */
    public function setProductionCountries($production_countries)
    {
        $this->production_countries = $production_countries;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * @param mixed $release_date
     *
     * @return self
     */
    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @param mixed $revenue
     *
     * @return self
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param mixed $runtime
     *
     * @return self
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpokenLanguages()
    {
        return $this->spoken_languages;
    }

    /**
     * @param mixed $spoken_languages
     *
     * @return self
     */
    public function setSpokenLanguages($spoken_languages)
    {
        $this->spoken_languages = $spoken_languages;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * @param mixed $tagline
     *
     * @return self
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     *
     * @return self
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    /**
     * @param mixed $vote_average
     *
     * @return self
     */
    public function setVoteAverage($vote_average)
    {
        $this->vote_average = $vote_average;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoteCount()
    {
        return $this->vote_count;
    }

    /**
     * @param mixed $vote_count
     *
     * @return self
     */
    public function setVoteCount($vote_count)
    {
        $this->vote_count = $vote_count;

        return $this;
    }
}
?>