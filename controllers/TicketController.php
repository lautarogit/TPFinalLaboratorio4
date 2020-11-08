<?php
    namespace Controllers;

    use Controllers\BillboardController as BillboardController;
    use DAO\TicketDAO as TicketDAO;
    use Models\Ticket as Ticket;
    use DAO\ShowDAO as ShowDAO;
    use Models\Show as Show;
    use Models\Room as Room;
    use DAO\RoomDAO as RoomDAO;
    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;

    class TicketController
    {
        private $showDAO;
        private $ticketDAO;
        private $billboardController;
        private $roomDAO;
        private $movieDAO;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->ticketDAO = new TicketDAO();
            $this->billboardController = new BillboardController();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAO();
        }
        
        public function showAllTicketsByUser()
        {
            require_once (VIEWS_PATH."Tickets/TicketsByUser.php");
        }

        public function buyTicket ($quantity, $idShow)
        {
            $user = $_SESSION['loggedUser'];
            $showMapper = $this->showDAO->getShowById($idShow);
            $idMovie = $showMapper->getIdMovie();

            $show = new Show();
            $show->setId($showMapper->getId());
            $show->setRemainingTickets($showMapper->getRemainingTickets());
            $ticketsLeft = $show->getRemainingTickets();

            if($user->getRolId() != 1)
            {
                if(($show->getRemainingTickets() - $quantity) >= 0)
                {
                    for($i = 0; $i < $quantity; $i++)
                    {
                        $ticket = new Ticket();

                        $codeQR = rand(1000, 10000);
                        $ticket->setCodeQR($codeQR);
                        $ticket->setIdShow($idShow);
                        $ticket->setIdUser($user->getDni()); 
                        
                        $this->ticketDAO->add($ticket);
                    }

                    $newRemainingTickets = $show->getRemainingTickets() - $quantity;
                    $show->setRemainingTickets($newRemainingTickets);
                    $room = $this->roomDAO->getRoomById($showMapper->getIdRoom());
                    $show->setRoom($room);
                    $movie = $this->movieDAO->getMovieById($showMapper->getIdMovie());
                    $show->setMovie($movie);
                    $show->setDateTime($showMapper->getDateTime());

                    $this->showDAO->edit($show);
                    $errorMessage = false;
                }
                else
                {
                    $errorMessage = "Cantidad de entradas invalidas. Hay ".$ticketsLeft." entradas disponibles";
                }     
            }
            else
            {
                $errorMessage = "No puede comprar entradas como administrador";
            }
            
            $this->billboardController->showBillboard($idMovie, $errorMessage);
        }
    }
?>
