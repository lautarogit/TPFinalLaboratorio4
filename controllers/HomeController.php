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
           
            $userFinded = $this->userDAO->validateData($userName, $dni, $email);
            $validateFirstName = $this->validateFormField($firstName, 3, 25);
            $validateLastName = $this->validateFormField($lastName, 3, 25);
            $validateUserName = $this->validateFormField($userName, 4, 16);
            $validateEmail = $this->validateFormField($email, 10, 40);
            $validateDni = $this->validateFormField($dni, 8, 9);
            $validatePassword = $this->validateFormField($password, 6, 45);

            if(!$userFinded && $validateFirstName && $validateLastName && $validateUserName
            && $validateEmail && $validateDni && $validatePassword
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

        public function validateFormField ($paramName, $minLength = '', $maxLength = '') 
        {
            if(!empty(trim($paramName)))
            {
                if(!empty($minLenght) && !empty($maxLength))
                {
                    if((strlen($paramName) >= $minLength) && (strlen($paramName) <= $maxLength))
                    {
                        $flag = true;
                    } 
                    else
                    {
                        $flag = false;
                    } 
                }
                else
                {
                    $flag = true;
                }  
            }
            else
            {
                $flag = false;
            } 

            return $flag;
        }
    }
?>

