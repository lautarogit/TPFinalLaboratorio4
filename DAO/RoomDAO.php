<?php
namespace DAO;
use Models\Room as Room;
use models\Cinema as cinema;
use \PDOException as PDOException;
use DAO\Connection as Connection;
use Exception;
class RoomDAO{
private $connection;
    public function addRooms(Cinema $cinema){
    
        $sqlQuery ="SELECT * FROM rooms where idCinema = :id";
    $parameters['id']=$cinema->getId();
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
        return new Room($p['id'],$p['idCinema'],$p['idType'],$p['capacity'],$p['name']);
    }, $value);

    return count($resp) > 1 ? $resp : $resp['0'];
}

}

?>