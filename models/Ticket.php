<?php
    namespace Models;

    class Ticket 
    {
        private $id;
        private $codeQR;
        private $idShow;
        private $idUser;
        private $price;
        
        public function __construct($id = '', $codeQR = '',$idShow = '', $idUser = '', $price = '')
        {
            $this->id = $id;
            $this->codeQR = $codeQR;
            $this->idShow = $idShow;
            $this->idUser = $idUser;
            $this->price = $price;
        }

        public function getId ()
        {
            return $this->id;
        }

        public function getCodeQR ()
        {
            return $this->codeQR;
        }

        public function getIdShow ()
        {
            return $this->idShow;
        }

        public function getIdUser ()
        {
            return $this->idUser;
        }

        public function getPrice ()
        {
            return $this->price;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setCodeQR ($codeQR)
        {
            $this->codeQR = $codeQR;
        }

        public function setIdShow ($idShow)
        {
            $this->idShow = $idShow;
        }

        public function setIdUser ($idUser)
        {
            $this->idUser = $idUser;
        }
        
        public function setPrice ($price)
        {
            $this->price = $price;
        }
    }
?>
