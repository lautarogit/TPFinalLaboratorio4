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

        public function showAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."paginaNueva.php");
        }

        /*public function Login($userName, $password)
        {
            $user = $this->userDAO->GetByUserName($userName);

            if(($user != null) && ($user->getPassword() === $password))
            {
                $_SESSION["loggedUser"] = $user;
                $this->showAddView();
            }
            else
                $this->index("Usuario y/o Contraseña incorrectos");
        }*/

        public function login($userName, $password)
        {
            $userList = $this->userDAO->GetAll();
            
            foreach($userList as $user)
            {
                if(($user->getUserName() === $userName) && ($user->getPassword() === $password))
                {
                    $_SESSION["loggedUser"] = $user;
                    $this->showAddView();
                }
                else
                {
                    $this->index("Usuario y/o Contraseña incorrectos");
                }
            }  
        }

        public function showLogin()
        {
            require_once(VIEWS_PATH."login.php");
        }
        
        public function logout()
        {
            session_destroy();

            $this->index();
        }
    }
?>