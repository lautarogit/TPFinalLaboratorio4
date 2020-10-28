<?php 
    namespace Models;

    class Room
    {
        private $id;
        private $idCinema;
        private $capacity;
        private $price;
        private $name;

        public function __construct($id = ' ', $idCinema = ' ', $capacity = ' ', $price = ' ', $name = ' ')
        {
            $this->id = $id;
            $this->idCinema = $idCinema;
            $this->capacity = $capacity;
            $this->price = $price;
            $this->name = $name;
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

        public function getPrice ()
        {
            return $this->price;
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

        public function setPrice ($price)
        {
            $this->price = $price;
        }

        public function setName ($name)
        {
            $this->name = $name;
        }
}
?>