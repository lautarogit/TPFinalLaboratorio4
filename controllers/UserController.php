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
        
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."login.php");
        }

        public function showListView()
        {
          require_once(VIEWS_PATH."validate-session.php");
            $userList = $this->userDAO->getAll();
    
        }
    }
?>