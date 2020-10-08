<?php
    namespace DAO;
    
    use Models\User as User;

    class UserDAO implements IUserDAO
    {
        private $userList = array();

        public function add($newUser)
        {
          $this->userList->getAll();
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
    
                array_push($arrayToEncode, $arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            file_put_contents('../Data/users.json', $jsonContent);
        }

        private function retrieveData()
        {
            $this->userList = array();
            $jsonPath = $this->GetJsonFilePath();
            echo $this->GetJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $user = new User(
                $arrayValue['userName'], 
                $arrayValue['password'] );
       
                array_push($this->userList, $user);
            }
        }

        function GetJsonFilePath()
        {
            $initialPath = "TPFinalMoviePass/Data/users.json";

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