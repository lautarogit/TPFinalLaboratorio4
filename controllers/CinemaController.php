<?php
    namespace Controllers;

    use DAO\CinemaDAOJSON as CinemaDAOJSON;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaController
    {
        private $cinemaDAO;

        public function __construct ()
        {
            //$this->cinemaDAO = new CinemaDAOJSON();
            $this->cinemaDAO = new CinemaDAO();
        }

        public function showPermissionBlocked ($rolId)
        {
            require_once(VIEWS_PATH."permission-blocked.php");
        }

        public function showCinemaDashboard ()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 1)
            {
                require_once(VIEWS_PATH."cinema-dashboard.php");
            }
            else
            {
                $this->showPermissionBlocked($rolId);
            }
        }

        public function showClientCinemaDashboard ()
        {
            $rolId = $_SESSION['loggedUser']->getRolId();
            $cinemaList = $this->cinemaDAO->getAll();

            require_once(VIEWS_PATH."validate-session.php");

            if($rolId == 0)
            {
                require_once(VIEWS_PATH."client-cinema-dashboard.php");
            }
            else
            {
                $this->showPermissionBlocked($rolId);
            } 
        }

        public function addCinema ($name, $location)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinema = new Cinema();
            $cinemaList = $this->cinemaDAO->getAll();
    
            $cinema->setName($name);
            $cinema->setLocation($location);
    
            $this->cinemaDAO->add($cinema);

            $this->showCinemaDashboard();
        }

        public function editCinema ($id, $name, $location)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinemaUpdated = new Cinema();
            $cinemaUpdated->setId($id);
            $cinemaUpdated->setName($name);
            $cinemaUpdated->setLocation($location);

            //$this->$cinemaDAO->edit($cinemaUpdated);

            $cinemaSQL = new CinemaDAO();
            $cinemaSQL->edit($cinemaUpdated);
            $this->showCinemaDashboard();
        }

        public function deleteCinema ($id)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinemaDeleted = new Cinema();
            $cinemaDeleted->setId($id);

            $this->cinemaDAO->delete($cinemaDeleted);
            $this->showCinemaDashboard();
        }
    }
?>