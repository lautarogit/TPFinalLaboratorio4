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

        public function showCinemaDashboard ()
        {
            require_once(VIEWS_PATH."cinema-dashboard.php");
        }

        public function addCinema ($name, $location, $capacity)
        {
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
            $cinema->setCapacity($capacity);

            $this->cinemaDAO->add($cinema);
            $this->showCinemaDashboard();
        }

        public function deleteCinema ($id)
        {
            $cinemaDAO = new CinemaDAO();

            $cinemaDAO->delete($id);
            $this->showCinemaDashboard();
        }
    }
?>