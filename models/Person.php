<?php 
    namespace Models;

    class Person
    {
        private $firstName;
        private $lastName;
        private $dni;
        private $email;
        
        public function __construct ($id=' ', $firstName=' ', $lastName = ' ', $dni= ' ', $email=' ')
        {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->dni = $dni;
            $this->email = $email;
        }

       

        public function getFirstName ()
        {
            return $this->firstName;
        }

        public function getlastName ()
        {
            return $this->lastName;
        }

        public function getDni ()
        {
            return $this->dni;
        }

        public function getEmail ()
        {
            return $this->email;
        }

       

        public function setFirstName ($firstName)
        {
            $this->firstName = $firstName;
        }

        public function setLastName ($lastName)
        {
            $this->lastName = $lastName;
        }

        public function setDni ($dni)
        {
            $this->dni = $dni;
        }

        public function setEmail ($email)
        {
            $this->email = $email;
        }
    }
?>