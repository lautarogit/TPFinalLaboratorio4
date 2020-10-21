<?php 
    namespace Models;
    
    class Rol
    {
        private $id;
        private $rolType;
 
        public function getId ()
        {
            return $this->id;
        }

        public function getRolType ()
        {
            return $this->rolType;
        }

        public function setId ($id)
        {
            $this->id = $id;
        }

        public function setRolType ($rolId)
        {
            if($rolId == 0)
            {
                $this->rolType = "Cliente";
            }

            if($rolId == 1)
            {
                $this->rolType = "Administrador";
            }   
        }
    }
?>