<?php
  require_once(VIEWS_PATH."header.php");
  require_once(VIEWS_PATH."nav.php");

?>
<form action="<?php echo FRONT_ROOT."Movie/addGenresToDB"; ?>" method="post">
        <button type="submit" class="btn btn-success">Consultar Generos</button>
</form>
<br>
<form action="<?php echo FRONT_ROOT."Movie/addMoviesXGenresToDB"; ?>" method="post">
        <button type="submit" class="btn btn-success">Consultar generos por peliculas</button>
</form>
<br>
<form action="<?php echo FRONT_ROOT."Movie/addMovies"?>" method="post">
        <button type="submit" class="btn btn-success">Consultar peliculas</button>
</form>