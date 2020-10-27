<?php 
    namespace Models;

    class Cinema
    {
        private $id;
        private $roomsId;
        private $location;
        private $name;
public function __construct($id=0,$location=' ',$name=' '){
    $this->id=$id;

    $this->location=$location;
    $this->name=$name;

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
    }
?>