<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    use DAO\MovieDAO as MovieDAO;
   $MovieDAO =new MovieDAO();
    var_dump($MovieDAO->retrieveDataFromAPI());
    ?>
</body>
</html>
