<?php   
use DAO\UserDAO as UserDAO;
    require_once("header.php"); 
     require_once("nav.php");

    $ruta =IMG_PATH.$_FILES['img_prf']['name'];
echo $ruta;

$userDao= new UserDAO();
$userDao->setImage($_SESSION["loggedUser"],$ruta);

?>
  
<img src="<?php echo $ruta;?>" alt="">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<form action="<?php echo FRONT_ROOT."User/addProfilePicture";?>" method="POST" enctype="multipart/form-data">
<input type="file" name='img_prf'>
<input type="submit" name "sub_prf" value='enviar'>
</form>
    
</body>
</html>