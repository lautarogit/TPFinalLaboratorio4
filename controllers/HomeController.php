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

        public function showAddView($message = "")
        {
            require_once(VIEWS_PATH."validate-session.php");
            echo $message;
           // require_once(VIEWS_PATH."paginaNueva.php");
        }


        public function login()
        {

             require_once(VIEWS_PATH."login.php");
             require_once(VIEWS_PATH."validate-session.php");
            $userList = $this->userDAO->GetAll();

            

            foreach($userList as $user)
            {
                if(($user->getUserName() === $_POST["userName"]) && ($user->getPassword() === $_POST["password"]))
                {

                    $_SESSION["loggedUser"] = $user;
                    $message="hello";
                    $this->showAddView($message);
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
            if(isset($_POST["send"])){
            require_once(VIEWS_PATH."validate-session.php");
            $userList = $this->userDAO->GetAll();
            foreach($userList as $user)
            {
                if(($user->getUserName() === $_POST["userName"]) && ($user->getPassword() === $_POST["password"]))
                {

                    $_SESSION["loggedUser"] = $user;
                    $message="hello";
                    $this->showAddView($message);
                }
                else
                {
                    $this->index("Usuario y/o Contraseña incorrectos");
                }
            }
            }  
        }
        
        
        public function logout()
        {
            session_destroy();

            $this->index();
        }
    }
?>