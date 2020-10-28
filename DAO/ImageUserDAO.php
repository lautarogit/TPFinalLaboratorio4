<?php
namespace DAO;

use DAO\Connection as Connection;
use \PDOException as PDOExepction;
use Models\User as User ;

class ImageUserDAO {
private $connection;
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
    $image = $this->mapout($resultSet);
}
else
{
    $image=IMG_PATH."logo.png" ;
}

return $image;
    }
public function mapout ($value)
{
    $value = is_array($value) ? $value : [];

    $resp = array_map(function($p){
        return $image=$p['linkImage'] ;
    }, $value);

    return count($resp) > 1 ? $resp : $resp['0'];
}
}

    

?>