<?php 
    namespace Models;

    class Room
    {
        private $id;
        private $idCinema;
        private $capacity;
        private $price;
        private $name;
        private $status;
        private $idShow;

        public function __construct($id = '', $idCinema = '', $capacity = '', $price = '', $name = '', $status = TRUE, $idShow = '')
        {
            $this->id = $id;
            $this->idCinema = $idCinema;
            $this->capacity = $capacity;
            $this->price = $price;
            $this->name = $name;
            $this->status = $status;
            $this->idShow = $idShow;
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

        public function getStatus ()
        {
            return $this->status;
        }

        public function getIdShow ()
        {
            return $this->idShow;
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

        public function setStatus ($status)
        {
            $this->status = $status;
        }

        public function setIdShow ($idShow)
        {
            $this->idShow = $idShow;
        }
}
?>