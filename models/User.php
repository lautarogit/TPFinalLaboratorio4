<?php 
    namespace Models;
    
    use Models\Person as Person;

    class User extends Person
    {
        private $userName;
        private $password;

        public function __construct ($userName = ' ', $password = ' ', $firstName = ' ', $lastName = ' ', $dni = ' ', $email = ' ')
        {
            parent::__construct($id, $firstName, $lastName, $dni, $email);
            $this->userName = $userName;
            $this->password = $password;
        }
 
        public function getUserName ()
        {
            return $this->userName;
        }

        public function getPassword ()
        {
            return $this->password;
        }

        public function setUserName ($userName)
        {
            $this->userName = $userName;
        }

        public function setPassword ($password)
        {
            $this->password = $password;
        }
    }
?>