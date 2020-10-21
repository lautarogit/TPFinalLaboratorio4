<?php 
    namespace Models;

    class Room
    {
        private $id;
        private $capacity;
        private $location;
        private $name;

        public function __construct ($id = ' ', $name = ' ', $location = ' ', $capacity = ' ')
        {
            $this->id = $id;
            $this->capacity = $capacity;
            $this->location = $location;
            $this->name = $name;
        }
        
        public function getId ()
        {
            return $this->id;
        }

        public function getCapacity ()
        {
            return $this->capacity;
        }

        public function getLocation ()
        {
            return $this->location;
        }

        public function getName ()
        {
            return $this->name;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setCapacity ($capacity)
        {
            $this->capacity = $capacity;
        }

        public function setLocation ($location)
        {
            $this->location = $location;
        }

        public function setName ($name)
        {
            $this->name = $name;
        }
    }
?>