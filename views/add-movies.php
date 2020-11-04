 <?php
        /*use DAO\MovieDAO as MovieDAO;
        $movieDAO = new MovieDAO();
        var_dump($movieDAO->retrieveDataFromAPI());*/

        /*use DAO\GenreDAO as GenreDAO;
        $genreDAO= new GenreDAO();
        var_dump($genreDAO->retrieveDataFromApi());
        use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
        $moviesXGenresDAO=new MoviesXGenresDAO();
        var_dump($moviesXGenresDAO->retrieveDataFromApi());*/
use models\Ticket as Ticket;
use DAO\TicketDAO as TicketDAO;
$ticketDAO=new TicketDAO();

        
var_dump($ticketDAO->getTicketByUser($_SESSION["loggedUser"]->getDni()));
?>
