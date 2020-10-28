<?php 
    namespace Models;

    class Cinema
    {
        private $id;
        private $roomsId;
        private $location;
        private $name;
        private $status;

        public function __construct($id = 0, $location = ' ', $name = ' ', $status = TRUE)
        {
            $this->id = $id;
            $this->location = $location;
            $this->name = $name;
            $this->status = $status;
        }

        public function getId ()
        {
            return $this->id;
        }

        public function getRoomsId ()
        {
            return $this->roomsId;
        }

        public function getLocation ()
        {
            return $this->location;
        }

        public function getName ()
        {
            return $this->name;
        }

        public function getStatus ()
        {
            return $this->status;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setRoomsId ($roomsId)
        {
            $this->roomsId = $roomsId;
        }
        
        public function setLocation ($location)
        {
            $this->location = $location;
        }

        public function setName ($name)
        {
            $this->name = $name;
        }

        public function setStatus ($status)
        {
            $this->status = $status;
        }
    }
?>