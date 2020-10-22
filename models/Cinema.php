<?php 
    namespace Models;

    class Cinema
    {
        private $id;
        private $roomsId;
        private $capacity;
        private $location;
        private $name;

        public function getId ()
        {
            return $this->id;
        }

        public function getRoomsId ()
        {
            return $this->roomsId;
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

        public function setRoomsId ($roomsId)
        {
            $this->roomsId = $roomsId;
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