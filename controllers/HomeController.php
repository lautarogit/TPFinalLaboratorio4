<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;

    class HomeController
    {
        private $userDAO;
        private $cinemaController;

        public function __construct()
        {
            $this->userDAO = new UserDAO();
            $this->cinemaController = new CinemaController();
        }

        public function index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function login($userName, $password)
        {
            $userList = $this->userDAO->GetAll();
            
            foreach($userList as $user)
            {
                if(($user->getUserName() === $userName) && ($user->getPassword() === $password))
                {
                    $_SESSION["loggedUser"] = $user;
                    
                    if($user->getRolId() == 0)
                    {
                        $this->cinemaController->showClientCinemaDashboard();
                        break;
                    }

                    if($user->getRolId() == 1)
                    {
                        $this->cinemaController->showCinemaDashboard();
                        break;
                    }   
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

            $user->setUserName($userName);
            $user->setPassword($password);
            $user->setRolId(0); //default ID for client
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setDni($dni); 
            $user->setEmail($email);

            $this->userDAO->add($user);
            $this->showLoginView();
        }
    }
?>