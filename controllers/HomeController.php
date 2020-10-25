<?php
    namespace Controllers;

    use DAO\UserDAOJSON as UserDAOJSON;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;

    class HomeController
    {
        private $userDAO;

        public function __construct ()
        {
            //$this->userDAO = new UserDAOJSON();
            $this->userDAO = new UserDAO();
        }

        public function index ($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function showLoginView ($errorMessage = "")
        {
            if(!empty($errorMessage))
            {
                echo $errorMessage;
            }
            require_once(VIEWS_PATH."login.php");
        }

        public function showCinemaDashboard ()
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

        public function showClientCinemaDashboard ()
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

        public function setSession ($user)
        {
            $_SESSION["loggedUser"] = $user;
        }
       
        public function login ($userName, $password)
        {
            $user = $this->userDAO->getUserByUserName($userName);

            if($user)
            {
                if($user->getPassword() == $password)
                {
                    $this->setSession($user);

                    if($user->getRolId() == 0)
                    {
                        $this->showClientCinemaDashboard();
                    }
                    else
                    {
                        $this->showCinemaDashboard();
                    }  
                }
            }
            else
            {
                $this->showLoginView("<p class="."text-white align-center".">Datos incorrectos. Ingrese nuevamente</p>");
            }
        } 

        public function logout ()
        {
            $_SESSION['loggedUser'] = null;
            session_destroy();
            $this->index();
        }

        public function signUp ($firstName, $lastName, $userName, $email, $dni, $password)
        {
            $user = new User();
           
            $validate = $this->userDAO->validateData($userName, $dni, $email);

            if(!$validate)
            {
                $user->setUserName($userName);
                $user->setPassword($password);
                $user->setRolId(0); //default ID for client
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setDni($dni); 
                $user->setEmail($email);
    
                $this->userDAO->add($user);
                $this->showLoginView("<p class="."text-white align-center".">Cuenta registrada con éxito.</p>");
            }
            else
            {
                $this->showLoginView("<p class="."text-white align-center".">Datos incorrectos. Ingrese nuevamente</p>");
            }   
        }
    }
?>

