<?php
    namespace Controllers;

    use DAO\userDAOJSON as userDAOJSON;
    use Models\user  as user;

  class userController
    {
        private $userDAO;

        public function __construct ()
        {
            $this->userDAO = new userDAOJSON();
        }

        public function showAddView ($message=" ")
        {
        
            require_once(VIEWS_PATH."Session/validate-session.php");
            require_once(VIEWS_PATH."Home/login.php");
        }

        public function showListView ()
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
            $userList = $this->userDAO->getAll();
        }
    }
?>