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
}
?>