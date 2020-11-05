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

        public function showCinemaPermissionBlocked ($rolId)
        {
            require_once(VIEWS_PATH."Cinemas/cinema-permission-blocked.php");
        }

        public function showCinemaDashboard ($errorMessage = "")
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."Cinemas/cinema-dashboard.php");
            }
            else
            {
                $this->showCinemaPermissionBlocked($rolId);
            }
        }

        public function showClientCinemaDashboard ()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php");

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."Cinemas/client-cinema-dashboard.php");
            }
            else
            {
                $this->showCinemaPermissionBlocked($rolId);
            } 
        }

        public function showDisabledCinemaDashboard ()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."Session/validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."Cinemas/disabled-cinema-dashboard.php");
            }
            else
            {
                $this->showCinemaPermissionBlocked($rolId);
            }
        }

        public function addCinema ($name, $location)
        {
            require_once(VIEWS_PATH."Session/validate-session.php");
            $cinema = new Cinema();

            $cinemaFinded = $this->cinemaDAO->validateData($name);
            $validateName = $this->validateFormField($name, 4, 20);
            $validateLocation = $this->validateFormField($location, 4, 45);

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
            require_once(VIEWS_PATH."Session/validate-session.php");
            $cinemaUpdated = new Cinema();

            $cinemaFinded = $this->cinemaDAO->validateData($name);
            $validateName = $this->validateFormField($name, 4, 20);
            $validateLocation = $this->validateFormField($location, 4, 45);

            if($cinemaFinded)
            {
                $cinemaUpdated = $this->cinemaDAO->getCinemaByName($name);

                if(!$cinemaUpdated->getStatus())
                {
                    $cinemaUpdated->setStatus(true);
                    $this->cinemaDAO->edit($cinemaUpdated);
                    $errorMessage = "Se ha rehabilitado un cine con el nombre ingresado";
                } 
                else
                {
                    $errorMessage = "Ya existe un cine habilitado con ese nombre";
                }  
            }
            else if($validateName && $validateLocation && $status!=null)
            {
                $cinemaUpdated->setId($id);
                $cinemaUpdated->setName($name);
                $cinemaUpdated->setLocation($location);
                $cinemaUpdated->setStatus($status);

                $this->cinemaDAO->edit($cinemaUpdated);
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
            require_once(VIEWS_PATH."Session/validate-session.php");
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