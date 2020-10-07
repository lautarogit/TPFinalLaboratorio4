<?php
    namespace DAO;
    
    use Models\User as User;

    class UserDAO// implements IUserDao
    {
        private $userList = array();

        public function add(User $newUser)
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


        private function saveData()
        {
            $arrayToEncode = array();

            foreach ($this->userList as $user) 
            {
                $arrayValue['userName'] = $user->getUserName();
                $arrayValue['password'] = $user->getPassword();
                $arrayValue['id'] = $user->getId();
                $arrayValue['firstName'] = $user->getFirstName();
                $arrayValue['lastName'] = $user->getLastName();
                $arrayValue['dni'] = $user->getDni();
                $arrayValue['email'] = $user->getEmail();

                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents('../Data/users.json', $jsonContent);
        }

        private function retrieveData()
        {
            $this->userList = array();
            $jsonPath = $this->GetJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $user = new User(
                $arrayValue['userName'], 
                $arrayValue['password'], 
                $arrayValue['id'], 
                $arrayValue['firstName'], 
                $arrayValue['lastName'],
                $arrayValue['dni'],
                $arrayValue['email']);
                
                array_push($this->userList, $user);
            }
        }

        function GetJsonFilePath()
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