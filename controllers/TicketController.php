<?php
    namespace Controllers;

    use Controllers\BillboardController as BillboardController;
    use Controllers\MovieController as MovieController;
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
        private $movieController;
        private $roomDAO;
        private $movieDAO;

        public function __construct ()
        {
            $this->showDAO = new ShowDAO();
            $this->ticketDAO = new TicketDAO();
            $this->billboardController = new BillboardController();
            $this->movieController = new MovieController();
            $this->roomDAO = new RoomDAO();
            $this->movieDAO = new MovieDAO();
        }
        
        public function showTicketsSelled ()
        {
            $ticketList = $this->ticketDAO->getTicketsPrices();
            $showList = $this->showDAO->getRemainingTickets();

            require_once(VIEWS_PATH."Tickets/tickets-selled.php");
        }

        public function showAllTicketsByUser ()
        {
            $user = $_SESSION["loggedUser"];
            $ticketList = $this->ticketDAO->getTickets($user->getDni());

            require_once(VIEWS_PATH."Tickets/tickets-by-user.php");
        }

        public function buyTicket ($quantity = '', $card = '', $idShow = '')
        {
            $user = $_SESSION['loggedUser'];
            
            if(!empty($quantity) && !empty($card) && !empty($idShow))
            {   
                $showMapper = $this->showDAO->getShowById($idShow);
                $idMovie = $showMapper->getIdMovie();
                                                            
                $show = new Show();
                $show->setId($showMapper->getId());
                $show->setRemainingTickets($showMapper->getRemainingTickets());
                $room = $this->roomDAO->getRoomByID($showMapper->getIdRoom());
                        
                $ticketsLeft = $show->getRemainingTickets();

                if($user->getRolId() != 1)
                {
                    if(($show->getRemainingTickets() - $quantity) >= 0)
                    {
                        date_default_timezone_set('America/Argentina/Buenos_Aires');
                        $dateDay = date('l');

                        for($i = 0; $i < $quantity; $i++)
                        {
                            $ticket = new Ticket();
    
                            $codeQR = rand(1000, 10000);
                            $ticket->setCodeQR($codeQR);
                            $ticket->setIdShow($idShow);
                            $ticket->setIdUser($user->getDni()); 
                            $ticket->setPrice($room->getPrice());

                            if($dateDay == "Tuesday" || $dateDay == "Wednesday") 
                            {
                                $discount = 0.75;
                                
                                $price = $room->getPrice();

                                $newPrice = $price * $discount;
                                $ticket->setPrice($newPrice);
                                var_dump($newPrice);
                            }
                            
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
                        $errorMessage = true;
                    }
                    else
                    {
                        $errorMessage = "Cantidad de entradas invalidas. Hay ".$ticketsLeft." entradas disponibles";
                        $this->billboardController->showBillboard($idMovie, $errorMessage);
                    }     
                }
                else
                {
                    $errorMessage = "No puede comprar entradas como administrador";
                    $this->billboardController->showBillboard($idMovie, $errorMessage);
                }
            }
            else
            {
                $errorMessage = "Los datos ingresados no son válidos, vuelva a consultar entradas";
                $this->movieController->showMovieDashboard($errorMessage);
            }
            
            $this->billboardController->showBillboard($idMovie, $errorMessage);
        }
    }
?>
