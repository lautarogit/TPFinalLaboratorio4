<?php
    namespace Controllers;

    use DAO\userDAO as userDAO;
    use Models\user  as user;

  class userController
    {
        private $userDAO;

        public function __construct()
        {
            $this->userDAO = new userDAO();
        }

        public function showAddView($message=" ")
        {
        
      /*    require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."login.php");*/
        }

        public function showListView()
        {
          require_once(VIEWS_PATH."validate-session.php");
            $userList = $this->userDAO->getAll();
    
        }

        public function add($userName, $password)
        {
            // require_once(VIEWS_PATH."validate-session.php");
            $user = new User();
            $user->setuserName($userName);
            $user->setPassword($password);

            $this->userDAO->Add($user);

            $this->ShowAddView();
        }

        public function remove($user)
        {
            require_once(VIEWS_PATH."validate-session.php");
            
            //$this->userDAO->remove($user);

            $this->ShowListView();
        }
        public function showsignUP(){
            require_once(VIEWS_PATH."sign-Up.php");
            $this->userDAO->getAll();
        }
        public function signUp()
        {
        	
       

        }
    }
?>