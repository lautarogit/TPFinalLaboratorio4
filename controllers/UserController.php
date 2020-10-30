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
        
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."login.php");
        }

        public function showListView ()
        {
            require_once(VIEWS_PATH."validate-session.php");
            $userList = $this->userDAO->getAll();
        }
        public function showLoginFacebook(){
            require_once("fbConfig.php");
            require_once __DIR__ . '/facebook-php-sdk/autoload.php';
            require_once __DIR__ . '/polyfills.php';

        }
    }
?>