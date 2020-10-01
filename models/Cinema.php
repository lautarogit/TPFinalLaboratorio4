<?php 
    namespace Models;

    class Cinema
    {
        private $capacity;
        private $location;
        private $name;

        public function __construct ($capacity, $location, $name)
        {
            $this->capacity = $capacity;
            $this->location = $location;
            $this->name = $name;
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