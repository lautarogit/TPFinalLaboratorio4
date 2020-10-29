<?php   

    require_once("header.php"); 
     require_once("nav.php");

    // $ruta= $_FILES['img_prf']["tmp_name"];


    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?php echo FRONT_ROOT."User/addProfilePicture";?>" method="POST">
<input type="file" name='img_prf'>
<input type="submit" name 'sub_prf' value='enviar'>
</form>
    
</body>
</html>