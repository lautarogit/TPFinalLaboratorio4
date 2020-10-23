<?php
    namespace Models;
    use Models\User as User;

    class Ticket 
    {
        private $id;
        private $codeQR;
        private $function;
        private $idUser;

        public function getId()
        {
            return $this->id;
        }

        public function getCodeQR()
        {
            return $this->codeQR;
        }

        public function getFunction()
        {
            return $this->function;
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

        public function setFunction($function)
        {
            $this->function = $function;

            return $this;
        }

        public function setIdUser($idUser)
        {
            $this->idUser = $idUser;

            return $this;
        }
    }
?>
