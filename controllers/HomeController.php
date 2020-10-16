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
            require_once(VIEWS_PATH."cinema-dashboard.php");

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
                    $this->showCinemaDashboard();

                }
                else
                { 
                    $this->showLoginView(); 
                ?> 
                    <div class="alert alert-danger d-flex justify-content-center" role="alert">
                    Usuario y/o contraseña incorrectos
                    </div>
                <?php 
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
    }
?>