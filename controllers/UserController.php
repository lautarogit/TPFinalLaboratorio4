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
               // require_once(VIEWS_PATH."validate-session.php");
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
        public function ShowsignUP(){
            require_once(VIEWS_PATH."sign-Up.php");
            $this->UserDAO->getAll();
        }
        public function signUp(){
        	
       

        }
    }
?>