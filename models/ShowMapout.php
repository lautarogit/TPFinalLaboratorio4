<?php
    namespace Models;

    class ShowMapout 
    {          
        private $id;
        private $idRoom;
        private $idMovie;
        private $dateTime;            
        private $remainingTickets; 
        private $status;

        public function __construct ($id = '', $idRoom = '', $idMovie = '', $dateTime = '', $remainingTickets = '', $status = '')
        {
            $this->id = $id;
            $this->idRoom = $idRoom;
            $this->idMovie = $idMovie;
            $this->dateTime = $dateTime;
            $this->remainingTickets = $remainingTickets;
            $this->status = $status;
        }

        public function getId ()
        {
            return $this->id;
        }

        public function getIdRoom ()
        {
            return $this->idRoom;
        }

        public function getIdMovie ()
        {
            return $this->idMovie;
        }

        public function getDateTime ()
        {
            return $this->dateTime;
        }

        public function getRemainingTickets ()
        {
            return $this->remainingTickets;
        }

        public function getStatus ()
        {
            return $this->status;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setIdRoom ($idRoom)
        {
            $this->idRoom = $idRoom;
        }

        public function setMovie ($idMovie)
        {
            $this->idMovie = $idMovie;
        }

        public function setDateTime ($dateTime)
        {
            $this->dateTime = $dateTime;
        }

        public function setRemainingTickets ($remainingTickets)
        {
            $this->remainingTickets = $remainingTickets;
        }

        public function setStatus ($status)
        {
            $this->status = $status;
        }
    }
?>