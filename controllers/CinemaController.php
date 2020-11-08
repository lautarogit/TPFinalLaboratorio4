<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\RoomDAO as RoomDAO;
    use Controllers\iValidation as iValidation;

    class CinemaController implements iValidation
    {
        private $cinemaDAO;
        private $roomDAO;

        public function __construct ()
        {
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
        }

        public function showCinemaDashboard ($errorMessage = "")
        {
            if(!empty($_SESSION['loggedUser']))
            {
                $rolId = $_SESSION['loggedUser']->getRolId();
            }
            
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."Cinemas/cinema-dashboard.php");
        }

        public function showDisabledCinemaDashboard ()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php"); 
            require_once(VIEWS_PATH."Cinemas/disabled-cinema-dashboard.php");
        }

        public function addCinema ($name, $location)
        {
            $cinema = new Cinema();

            $cinemaFinded = $this->cinemaDAO->validateData($name);
            $validateName = $this->validateFormField($name,3, 40);
            $validateLocation = $this->validateFormField($location, 3, 40);

            if($cinemaFinded)
            {
                $cinema = $this->cinemaDAO->getCinemaByName($name);

                if(!$cinema->getStatus())
                {
                    if($validateName && $validateLocation)
                    {
                        $cinema->setStatus(true);
                        $cinema->setName($name);
                        $cinema->setLocation($location);
                        $this->cinemaDAO->edit($cinema);

                        $errorMessage = "Se ha rehabilitado y modificado un cine con el nombre ingresado";
                    }
                    else
                    {
                        $errorMessage = "No se ha podido rehabilitar y modificar el cine ya existente por datos incorrectos.";
                    } 
                } 
                else
                {
                    if($validateName && $validateLocation)
                    {
                        $cinema->setName($name);
                        $cinema->setLocation($location);
                        $this->cinemaDAO->edit($cinema);
                        
                        $errorMessage = "Se ha modificado un cine ya existente con ese nombre";
                    }
                    else
                    {
                        $errorMessage = "No se ha podido modificar el cine ya existente por datos incorrectos.";
                    } 
                }  
            }
            else if($validateName && $validateLocation)
            {
                $cinema->setName($name);
                $cinema->setLocation($location);
                $cinema->setStatus(true);
                $this->cinemaDAO->add($cinema);
            }
            
            if(!empty($errorMessage))
            {
                $this->showCinemaDashboard($errorMessage);
            }
            else
            {
                $this->showCinemaDashboard();
            } 
        }

        public function editCinema ($id, $name, $location, $status)
        {
            $cinemaUpdated = new Cinema();

            $validateName = $this->validateFormField($name, 3, 40);
            $validateLocation = $this->validateFormField($location, 3, 40);

            if($validateName && $validateLocation && !empty($status))
            {
                $cinemaUpdated->setId($id);
                $cinemaUpdated->setName($name);
                $cinemaUpdated->setLocation($location);
                $cinemaUpdated->setStatus($status);
                $this->cinemaDAO->edit($cinemaUpdated);
            }
            else
            {
                $errorMessage = "No se ha podido modificar el cine por datos inválidos";
            }

            if(!empty($errorMessage))
            {
                $this->showCinemaDashboard($errorMessage);
            }
            else
            {
                $this->showCinemaDashboard();
            } 
        }

        public function disableCinema ($id)
        {
            $cinemaDisabled = new Cinema();
            
            $cinemaDisabled = $this->cinemaDAO->getCinemaByID($id);

            if($cinemaDisabled->getStatus())
            {
                $cinemaDisabled->setStatus(false);
                $this->cinemaDAO->edit($cinemaDisabled);
                $this->showCinemaDashboard();
            }
            else
            {
                $cinemaDisabled->setStatus(true);
                $this->cinemaDAO->edit($cinemaDisabled);
                $this->showDisabledCinemaDashboard();
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