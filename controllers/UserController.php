<?php
    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User  as User;

    class UserController
    {
        private $UserDAO;

        public function __construct()
        {
            $this->$UserDAO = new UserDAO();
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            //require_once(VIEWS_PATH."add-User.php");
        }

        public function ShowListView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            $UserList = $this->UserDAO->getAll();
            
            //require_once(VIEWS_PATH."cellphone-list.php");
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
    }
?>