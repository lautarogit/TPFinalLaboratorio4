<?php
    namespace Controllers;

    use DAO\UserDAOJSON as UserDAOJSON;
    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Controllers\CinemaController as CinemaController;
    use Controllers\iValidation as iValidation;

    class HomeController implements iValidation
    {
        private $userDAO;
        private $cinemaController;

        public function __construct ()
        {
            //$this->userDAO = new UserDAOJSON();
            $this->userDAO = new UserDAO();
            $this->cinemaController = new CinemaController();
        }

        public function index ($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }

        public function showLoginView ($errorMessage = "")
        {
            require_once(VIEWS_PATH."login.php");
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
                        $this->cinemaController->showClientCinemaDashboard();
                    }
                    else
                    {
                        $this->cinemaController->showCinemaDashboard();
                    }  
                }
                else
                {
                    $errorMessage = true;
                    $this->showLoginView($errorMessage);
                }
            }
            else
            {
                $errorMessage = true;
                $this->showLoginView($errorMessage);
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

            if(!$validate 
            && $this->validateFormField($firstName) && $this->validateFormField($lastName)
            && $this->validateFormField($userName) && $this->validateFormField($email)
            && $this->validateFormField($dni) && $this->validateFormField($password)
            )
            {
                $user->setUserName($userName);
                $user->setPassword($password);
                $user->setRolId(0); //default ID for client
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setDni($dni); 
                $user->setEmail($email);
    
                $this->userDAO->add($user);
                $errorMessage = false;
                $this->showLoginView($errorMessage);
            }
            else
            {
                $errorMessage = true;
                $this->showLoginView($errorMessage);
            }   
        }

        public function validateFormField ($param_name) 
        {
            if(!empty(trim($param_name)))
            {
                $flag = true;
            }
            else
            {
                $flag = false;
            } 

            return $flag;
        }
    }
?>

