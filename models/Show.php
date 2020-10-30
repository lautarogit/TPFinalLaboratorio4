<?php
    namespace Models;

    use Models\Room as Room;
    use Models\Movie as Movie;

    class Show
    {          
        private $id;
        private $room;
        private $movie;
        private $dateTime;            
        private $remainingTickets; 

        public function __construct ()
        {
            $this->room = new Room();
            $this->movie = new Movie();
        }

        public function getId ()
        {
            return $this->id;
        }

        public function getRoom ()
        {
            return $this->room;
        }

        public function getMovie ()
        {
            return $this->movie;
        }

        public function getDateTime ()
        {
            return $this->dateTime;
        }

        public function getRemainingTickets ()
        {
            return $this->remainingTickets;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setRoom ($room)
        {
            $this->room = $room;
        }

        public function setMovie ($movie)
        {
            $this->movie = $movie;
        }

        public function setDateTime ($dateTime)
        {
            $this->dateTime = $dateTime;
        }

        public function setRemainingTickets ($remainingTickets)
        {
            $this->remainingTickets = $remainingTickets;
        }
    }
?>