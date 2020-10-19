<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;

    class HomeController
    {
        private $userDAO;

        public function __construct()
        {
            $this->userDAO = new UserDAO();
        }

        public function index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function showCinemaDashboard()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."cinema-dashboard.php");
        }

        public function login($userName, $password)
        {
            $userList = $this->userDAO->GetAll();
            
            foreach($userList as $user)
            {
                if(($user->getUserName() === $userName) && ($user->getPassword() === $password))
                {
                    $_SESSION["loggedUser"] = $user;
                    $this->showCinemaDashboard();
                    break;
                }
                else
                {
                    $this->showLoginView();
                }
            }
        } 
            
        public function showLoginView()
        {
            require_once(VIEWS_PATH."login.php");
        }
        
        public function logout()
        {
            $_SESSION['loggedUser'] = null;
            session_destroy();
            $this->index();
        }

        public function signUp ($firstName, $lastName, $userName, $email, $dni, $password)
        {
            $user = new User();
            $userList = $this->userDAO->getAll();
            $userListDimension = count($userList);
            $index = $userListDimension-1;

            if($userListDimension == 0)
            {
                $id = 1;
            }
            else
            {
                $id = $userList[$index]->getId() + 1;
            }
            
            $user->setId($id);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUserName($userName);
            $user->setEmail($email);
            $user->setDni($dni);
            $user->setPassword($password);

            $this->userDAO->add($user);
            $this->showLoginView();
        }
    }
?>