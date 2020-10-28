<?php
    namespace Controllers;

    use DAO\CinemaDAOJSON as CinemaDAOJSON;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\RoomDAO as RoomDAO;
    use Controllers\iValidation as iValidation;

    class CinemaController implements iValidation
    {
        private $cinemaDAO;

        public function __construct ()
        {
            //$this->cinemaDAO = new CinemaDAOJSON();
            $this->cinemaDAO = new CinemaDAO();
            $this->roomDAO = new RoomDAO();
        }

        public function showCinemaPermissionBlocked ($rolId)
        {
            require_once(VIEWS_PATH."cinema-permission-blocked.php");
        }

        public function showCinemaDashboard ($errorMessage = "")
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();
            $roomList = $this->roomDAO->getAll();

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."cinema-dashboard.php");
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

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."client-cinema-dashboard.php");
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

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."disabled-cinema-dashboard.php");
            }
            else
            {
                $this->showCinemaPermissionBlocked($rolId);
            }
        }

        public function addCinema ($name, $location)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinema = new Cinema();

            $cinemaFinded = $this->cinemaDAO->validateData($name);
            $validateName = $this->validateFormField($name, 4, 20);
            $validateLocation = $this->validateFormField($location, 4, 45);

            if($cinemaFinded)
            {
                $cinema = $this->cinemaDAO->getCinemaByName($name);

                if(!$cinema->getStatus())
                {
                    $cinema->setStatus(true);
                    $this->cinemaDAO->edit($cinema);
                    $errorMessage = "<h4 class="."text-white m-2".">Se ha rehabilitado un cine con el nombre ingresado</h4>";
                } 
                else
                {
                    $errorMessage = "<h4 class="."text-white m-2".">Ya existe un cine habilitado con ese nombre</h4>";
                }  
            }
            else if($validateName && $validateLocation && $validateStatus)
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

        public function editCinema ($id, $name, $location, $status = '')
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinemaUpdated = new Cinema();

            $cinemaFinded = $this->cinemaDAO->validateData($name);
            $validateName = $this->validateFormField($name, 4, 20);
            $validateLocation = $this->validateFormField($location, 4, 45);
            $validateStatus = $this->validateFormField($status, 1, 25);

            if(!$cinemaFinded)
            {
                $cinema = $this->cinemaDAO->getCinemaByName($name);

                if(!$cinema->getStatus())
                {
                    $cinema->setStatus(true);
                    $this->cinemaDAO->edit($cinemaUpdated);
                    $errorMessage = "<h4 class="."text-white m-2".">Se ha rehabilitado un cine con el nombre ingresado</h4>";
                } 
                else
                {
                    $errorMessage = "<h4 class="."text-white m-2".">Ya existe un cine habilitado con ese nombre</h4>";
                }  
            }
            else if($validateName && $validateLocation && $validateStatus)
            {
                $cinema->setName($name);
                $cinema->setLocation($location);
                $cinema->setStatus($status);

                $this->cinemaDAO->edit($cinema);
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
            require_once(VIEWS_PATH."validate-session.php");
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

        public function validateFormField ($paramName, $minLength, $maxLength) 
        {
            if(!empty(trim($paramName)))
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
                $flag = false;
            } 

            return $flag;
        }
    }
?>