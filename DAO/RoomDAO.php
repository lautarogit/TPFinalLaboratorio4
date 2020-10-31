<?php
    namespace DAO;
    
    use Models\Room as Room;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class RoomDAO
    {
        private $connection;

        public function add (Room $room)
        {
            $sqlQuery = "INSERT INTO rooms (idCinema, capacity, price, name, status) 
            VALUES (:idCinema, :capacity, :price, :name, :status)";

            $parameters['idCinema'] = $room->getIdCinema();
            $parameters['capacity'] = $room->getCapacity();
            $parameters['price'] = $room->getPrice();
            $parameters['name'] = $room->getName();
            $parameters['status'] = $room->getStatus();

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

        public function getAll ()
        {
            $sqlQuery = "SELECT * FROM rooms";
            
            try
            {
                $this->connection = Connection::getInstance();
            
                $result = $this->connection->execute($sqlQuery);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($result))
            {
                $result = $this->mapout($result);

                $roomList = array();

                if(!is_array($result))
                {
                   array_push($roomList, $result);
                }
            }
            else 
            {
                $result =  false;
            }

            if(!empty($roomList))
            {
                $finalResult = $roomList;  
            }
            else
            {
                $finalResult = $result;
            }

            return $finalResult;
        }

        public function getRoomByID ($id)
        {
            $sqlQuery = "SELECT * FROM rooms WHERE id = :id";

            $parameters['id'] = $id;

            try
            {
                $this->connection = Connection::getInstance();
                
                $resultSet = $this->connection->execute($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($resultSet))
            {
                $room = $this->mapout($resultSet);
            }
            else
            {
                $room = false;
            }

            return $room;
        }

        public function getRoomListByIdCinema ($idCinema)
        {
            $sqlQuery = "SELECT * FROM rooms WHERE idCinema = :idCinema";

            $parameters['idCinema'] = $idCinema;

            try
            {
                $this->connection = Connection::getInstance();
                
                $result = $this->connection->execute($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($result))
            {
                $result = $this->mapout($result);

                $roomList = array();

                if(!is_array($result))
                {
                   array_push($roomList, $result);
                }
            }
            else 
            {
                $result =  false;
            }

            if(!empty($roomList))
            {
                $finalResult = $roomList;  
            }
            else
            {
                $finalResult = $result;
            }

            return $finalResult;
        }

        public function getRoomByName ($name, $idCinema)
        {
            $sqlQuery = "SELECT * FROM rooms WHERE name = :name AND idCinema = :idCinema";

            $parameters['name'] = $name;
            $parameters['idCinema'] = $idCinema;

            try
            {
                $this->connection = Connection::getInstance();
                
                $resultSet = $this->connection->execute($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }
            
            if(!empty($resultSet))
            {
                $room = $this->mapout($resultSet);
            }
            else
            {
                $room = false;
            }

            return $room;
        }

        public function edit (Room $roomUpdated)
        {
            $id = $roomUpdated->getId();
            $capacity = $roomUpdated->getCapacity();
            $price = $roomUpdated->getPrice();
            $name = $roomUpdated->getName();
            $status = $roomUpdated->getStatus();
            $idShow = $roomUpdated->getIdShow();

            $sqlQuery = "UPDATE rooms SET capacity = :capacity, price = :price, name = :name, status = :status, idShow = :idShow WHERE (id = :id)";

            $parameters['id'] = $id;
            $parameters['capacity'] = $capacity;
            $parameters['price'] = $price;
            $parameters['name'] = $name;
            $parameters['status'] = $status;
            $parameters['idShow'] = $idShow;

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

        public function validateData ($name, $idCinema)
        {
            $sqlQuery = "SELECT * FROM rooms
            WHERE name = :name AND idCinema = :idCinema";

            $parameters['name'] = $name;
            $parameters['idCinema'] = $idCinema;

            try
            {
                $this->connection = Connection::getInstance();
                
                $resultSet = $this->connection->execute($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($resultSet))
            {
                $flag = true;
            }
            else
            {
                $flag = false;
            }
            
            return $flag;
        }

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                return new Room ($p['id'], $p['idCinema'], $p['capacity'], $p['price'], $p['name'], $p['status'], $p['idShow']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>


