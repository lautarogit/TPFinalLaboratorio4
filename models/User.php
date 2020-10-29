<?php 
    namespace Models;
    
    use Models\Person as Person;

    class User extends Person
    {
        private $userName;
        private $password;
        private $rolId;
        private $image;

        public function __construct ($userName = ' ', $password = ' ', $rolId = ' ',$image=' ', $firstName = ' ', $lastName = ' ', $dni = ' ', $email = ' ')
        {
            parent::__construct($firstName, $lastName, $dni, $email);
            $this->userName = $userName;
            $this->password = $password;
            $this->rolId = $rolId;
            $this->image=$image;
        }
 public function getImage(){
     return $this->image;
 }
 public function setImage($image){
     $this->$image=$image;
 }
        public function getUserName ()
        {
            return $this->userName;
        }

        public function getPassword ()
        {
            return $this->password;
        }

        public function getRolId ()
        {
            return $this->rolId;
        }

        public function setUserName ($userName)
        {
            $this->userName = $userName;
        }

        public function setPassword ($password)
        {
            $this->password = $password;
        }

        public function setRolId ($rolId)
        {
            $this->rolId = $rolId;
        }
    }
?>