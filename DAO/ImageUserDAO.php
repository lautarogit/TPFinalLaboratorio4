<?php
use DAO\Connection as Connection;
use \PDOException as PDOExepction;
use Models\User as User ;
use DAO\UserDAO as UserDAO;
class ImageUserDAO {
private $connection;
public function setImage($user,$image){
    $sqlQuery = "INSERT INTO imageUser (idUser,image) VALUES(:idUser,:image)";
    $parameter['idUser']=$user->getId();
    $parameter['image']=$image;
    
    try 
    {
        $this->connection = Connection::getInstance();

        return $this->connection->executeNonQuery($sqlQuery, $parameter);
    }   
    catch(PDOException $ex)
    {
        throw $ex;
    } 
}

    public function getImage(User $user){
$sqlQuery=" SELECT  * FROM ImageUser  where dni=:dni ";

$parameter['dni']=$user->getDni();

try
{
    $this->connection = Connection::getInstance();
    
    $resultSet = $this->connection->execute($sqlQuery, $parameter);
}
catch(PDOException $ex)
{
    throw $ex;
}

if(!empty($resultSet))
{
    $image = $resultSet;
}
else
{
    $image= false;
}

return $image;
    }
}


    

?>