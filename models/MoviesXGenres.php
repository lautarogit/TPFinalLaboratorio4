<?php
namespace Models;
class MoviesXGenres
{
    private $idMovie;
    private $idGenre;
    public function __construct($idMovie=0,$idGenre=0)
    {
        $this->idMovie=$idMovie;

        $this->idGenre=$idGenre;
    }
    public function getIdMovie(){return $this->idMovie; }
    public function getIdGenre(){ return $this->idGenre;}
    public function setIdMovie($idMovie){ $this->idMovie=$idMovie;}
    public function setIdGenre ($idGenre){$this->idGenre=$idGenre;} 

    }


?>