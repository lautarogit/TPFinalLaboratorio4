<?php 
    namespace Models;

    class Room
    {
        private $id;
        private $idCinema;
        private $capacity;
        private $type;
        private $name;
public function __construct($id=0,$idCinema=0,$capacity=0,$type=' ',$name=' ')
{
    $this->id=$id;
    $this->idCinema=$idCinema;
    $this->capacity=$capacity;
    $this->type=$type;
    $this->name=$name;
}
        public function getId ()
        {
            return $this->id;
        }

        public function getIdCinema ()
        {
            return $this->idCinema;
        }

        public function getCapacity ()
        {
            return $this->capacity;
        }

        public function getType()
        {
            return $this->type;
        }

        public function getName ()
        {
            return $this->name;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setIdCinema ($idCinema)
        {
            $this->idCinema = $idCinema;
        }

        public function setCapacity ($capacity)
        {
            $this->capacity = $capacity;
        }

        public function setType($type)
        {
            $this->type = $type;
        }

        public function setName ($name)
        {
            $this->name = $name;
        }
}
?>