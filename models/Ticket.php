<?php
    namespace Models;

    class Ticket 
    {
        private $id;
        private $codeQR;
        private $idShow;
        private $idUser;
        
        public function __construct($id = '', $codeQR = '',$idShow = '', $idUser = '')
        {
            $this->id=$id;
            $this->codeQR=$codeQR;
            $this->idShow=$idShow;
            $this->idUser=$idUser;
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
    }
?>
