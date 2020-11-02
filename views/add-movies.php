 <?php
      use DAO\MovieDAO as MovieDAO;
      use DAO\MoviesXGenresDAO as MoviesXGenresDAO;
      #use DAO\GenreDAO as GenreDAO;

      $movieDAO = new MovieDAO();
      #$genreDAO= new GenreDAO();
      #var_dump($genreDAO->retrieveDataFromApi());
      #$moviesXGenresDAO=new MoviesXGenresDAO();
      #var_dump($moviesXGenresDAO->retrieveDataFromApi());

      $movieDAO->retrieveDataFromAPI();
?>