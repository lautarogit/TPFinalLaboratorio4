<?php
    namespace DAO;
    
    use Models\User as User;

    class UserDAOJSON
    {
        private $userList = array();

        public function add (User $newUser)
        {
            $this->retrieveData();
            array_push($this->userList, $newUser);
            $this->saveData();
        }

        public function getAll()
        {
            $this->retrieveData();
            return $this->userList;
        }

        public function getUserByUserName (User $user)
        {
            $this->retrieveData();
            $result = null;

            foreach($this->userList as $userValue)
            {
                if(($userValue->getUserName() == $user->getUserName()) && ($userValue->getPassword() == $user->getPassword()))
                {
                    $result = $userValue;
                }
                else 
                {
                    $result = false;
                }
            }

            return $result;
        }

        private function saveData ()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->userList as $user) 
            {
                $arrayValue['userName'] = $user->getUserName();
                $arrayValue['password'] = $user->getPassword();
                $arrayValue['rolId'] = $user->getRolId();
                $arrayValue['firstName'] = $user->getFirstName();
                $arrayValue['lastName'] = $user->getLastName();
                $arrayValue['dni'] = $user->getDni();
                $arrayValue['email'] = $user->getEmail();

                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents($jsonPath, $jsonContent);
        }

        private function retrieveData ()
        {
            $this->userList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $user = new User();

                $userName = $arrayValue['userName'];
                $password = $arrayValue['password'];
                $rolId = $arrayValue['rolId'];
                $firstName = $arrayValue['firstName'];
                $lastName = $arrayValue['lastName'];
                $dni = $arrayValue['dni'];
                $email = $arrayValue['email'];

                $user->setUserName($userName);
                $user->setPassword($password);
                $user->setRolId($rolId);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setDni($dni);
                $user->setEmail($email);

                array_push($this->userList, $user);
            }
        }
        
        function getJsonFilePath ()
        {
            $initialPath = "Data/users.json";

            if(file_exists($initialPath))
            {
                $jsonFilePath = $initialPath;
            }
            else
            {
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }
?>