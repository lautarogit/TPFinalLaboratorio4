<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User  as User;

    class UserController
    {
        private $UserDAO;

        public function __construct()
        {
            $this->UserDAO = new UserDAO();
        }

        public function ShowAddView($message=" ")
        {
            var_dump($message);
      /*    require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."login.php");*/
        }

        public function ShowListView()
        {
          require_once(VIEWS_PATH."validate-session.php");
            $UserList = $this->UserDAO->getAll();
    
        }

        public function Add($UserName, $Password)
        {
                require_once(VIEWS_PATH."validate-session.php");
                $user =new User();
            $User->setUserName($UserName);
            $User->setPassword($Password);

            $this->UserDAO->Add($User);

            $this->ShowAddView();
        }

        public function Remove($User)
        {
            require_once(VIEWS_PATH."validate-session.php");
            
            $this->UserDAO->Remove($User);

            $this->ShowListView();
        }
        public function signUP(){
            require_once(VIEWS_PATH."sing-up.php");
            $this->UserDAO->getAll();
            $message= $this->UserDAO;
            $this->ShowAddView($message);
      /*   $userList = $this->userDAO->GetAll();
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
                }*/
            
        }
    }
?>