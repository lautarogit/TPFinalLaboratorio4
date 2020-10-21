<?php 
    namespace Models;

    class Cinema
    {
        private $id;
        private $location;
        private $name;

        public function __construct ($id = ' ', $name = ' ', $location = ' ')
        {
            $this->id = $id;
          
            $this->location = $location;
            $this->name = $name;
        }
        
        public function getId ()
        {
            return $this->id;
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