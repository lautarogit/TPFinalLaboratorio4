<?php
    namespace Models;
    use Models\User as User;

    class Ticket 
    {
        private $id;
        private $codeQR;
        private $idShow;
        private $idUser;

        public function getId()
        {
            return $this->id;
        }

        public function getCodeQR()
        {
            return $this->codeQR;
        }

        public function getIdShow()
        {
            return $this->idShow;
        }

        public function getIdUser()
        {
            return $this->idUser;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setCodeQR($codeQR)
        {
            $this->codeQR = $codeQR;

            return $this;
        }

        public function setIdShow($idShow)
        {
            $this->idShow = $idShow;

            return $this;
        }

        public function setIdUser($idUser)
        {
            $this->idUser = $idUser;

            return $this;
        }
    }
?>
