<?php
namespace DAO;
use Models\Cinema as Cinema;
use \PDOException as PDOException;
use DAO\Connection as Connection;
use Exception;

class CinemaDAO{
private $connection;

public function add (Cinema $cinema)
{
    $sqlQuery = "INSERT INTO Cinemas (name,location) 
    VALUES (:name, :location)";

    $parameters['name'] = $cinema->getName();
    $parameters['location']=$cinema->getLocation();


    try
    {
        $this->connection = Connection::getInstance();

        return $this->connection->executeNonQuery($sqlQuery, $parameters);
    }
    catch(PDOException $ex)
    {
        throw $ex;
    }
}
public function addRooms(Cinema $cinema){
    
    $sqlQuery ="SELECT * FROM rooms where idcinema = :id;";
$parameters['id']=$cinema;
    try{
        $this->connection= Connection::getInstance();
        $result =$this->connection->execute($sqlQuery,$parameters);

    }
    catch(Exception $ex)
    {
        throw $ex;
    }
    if(empty($result)){
        return $this->mapout($result);
    }
    else {
        return false;
    }
}

    public function mapout ($value)
    {
        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            return new Cinema($p['id'],$p['roomsId'], $p['location'],)$p['name'];
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

}
?>
