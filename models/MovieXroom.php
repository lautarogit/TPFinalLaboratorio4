<?php
    namespace Models;

    class MovieXroom
    {
        private $date;
        private $movie;
        private $room;



    public function __construct($date=' ', $movie=' ', $room=' ')
    {
        $this->date = $date;
        $this->movie = $movie;
        $this->room = $room;
    }

        public function getDate (){
            return $this->date;
        }
        public function getMovie (){
            return $this->movie;
        }
        
        public function getRoom () {
           return  $this->room;
        }
        public function setRoom($room){
                $this->room = $room;
        }
        public function setMovie ($movie){
            $this->movie=$movie;
        }
        public function setDate ($date){
            $this->date=$date;
        }
        

    }
