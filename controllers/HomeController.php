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
            $rolId = $_SESSION['loggedUser']->getRolId();

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."cinema-dashboard.php");
            }
            else
            {
                ?>
                    <h4 class="text-white">No tiene los permisos necesarios para ingresar a esta página</h4>
                <?php   
            }
        }

        public function showClientCinemaDashboard()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."client-cinema-dashboard.php");
            }
            else
            {
                ?>
                    <h4 class="text-white">No tiene los permisos necesarios para ingresar a esta página</h4>
                <?php   
            } 
        }

        public function login($userName, $password)
        {
            $userList = $this->userDAO->GetAll();
            
            foreach($userList as $user)
            {
                if(($user->getUserName() === $userName) && ($user->getPassword() === $password))
                {
                    $_SESSION["loggedUser"] = $user;
                    
                    if($user->getRolId() == 0)
                    {
                        $this->showClientCinemaDashboard();
                    }

                    if($user->getRolId() == 1)
                    {
                        $this->showCinemaDashboard();
                        break;
                    }   
                }
                else
                {
                    $this->showLoginView();
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

        public function signUp ($firstName, $lastName, $userName, $email, $dni, $password)
        {
            $user = new User();
            $userList = $this->userDAO->getAll();

            $user->setUserName($userName);
            $user->setPassword($password);
            $user->setRolId(0); //default ID for client
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setDni($dni); 
            $user->setEmail($email);

            $this->userDAO->add($user);
            $this->showLoginView();
        }
    }
?>