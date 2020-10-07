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

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."login.php");
        }

     /*   public function Login($userName, $password)
        {
            $user = $this->$userDAO->GetAll();

            if(($user != null) && ($user->getPassword() === $password))
            {
                $_SESSION["loggedUser"] = $user;
                $this->ShowAddView();
            }
            else
                $this->Index("Usuario y/o Contraseña incorrectos");
        }*/

        public function Login()
        {
            $userList = $this->userDAO->GetAll();
   
            foreach($userList as $user)
            {
                if(($user->getUserName() === $_POST['userName']) && ($user->getPassword() === $_POST['password']))
                {

                    $_SESSION["loggedUser"] = $user;
                    $this->ShowAddView();
                }
                else
                {
                    $this->Index("Usuario y/o Contraseña incorrectos");
                }
            }  
        }
        
        public function Logout()
        {
            session_destroy();

            $this->Index();
        }
    }
?>