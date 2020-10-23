<?php
    namespace Controllers;

    use DAO\CinemaDAO as CinemaDAO;
    use Models\Cinema as Cinema;

    class CinemaController
    {
        private $cinemaDAO;

        public function __construct ()
        {
            $this->cinemaDAO = new CinemaDAO();
        }

        public function showCinemaDashboard()
        {
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();

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
            require_once(VIEWS_PATH."validate-session.php");
            $rolId = $_SESSION['loggedUser']->getRolId();

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

        public function addCinema ($name, $location)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $cinema = new Cinema();
            $cinemaList = $this->cinemaDAO->getAll();
            $cinemaListDimension = count($cinemaList);
            $index = $cinemaListDimension-1;
    
            if($cinemaListDimension == 0)
            {
                $id = 1;
            }
            else
            {
                $id = $cinemaList[$index]->getId() + 1;
            }
                
            $cinema->setId($id);
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

            $this->$cinemaDAO->edit($cinemaUpdated);
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