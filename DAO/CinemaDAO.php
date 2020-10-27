<?php
    namespace DAO;
    
    use Models\Cinema as Cinema;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class CinemaDAO
    {
        private $connection;

        public function add (Cinema $cinema)
        {
            $sqlQuery = "INSERT INTO Cinemas (name,location) 
            VALUES (:name, :location)";

            $parameters['name'] = $cinema->getName();
            $parameters['location'] = $cinema->getLocation();

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
            $sqlQuery = "SELECT * FROM cinemas";
            
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
                $cinemaList = $this->mapout($result);
            }
            else 
            {
                $cinemaList =  false;
            }

            return $cinemaList;
        }

        public function getCinemaByID ($id)
        {
            $sqlQuery = "SELECT * FROM cinemas WHERE id = :id";

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
                $cinema = $this->mapout($resultSet);
            }
            else
            {
                $cinema = false;
            }

            return $cinema;
        }

        public function delete (Cinema $cinemaDeleted)
        {
            
        }

        public function edit (Cinema $cinemaUpdated)
        {
            $id = $cinemaUpdated->getId();
            $name = $cinemaUpdated->getName();
            $location = $cinemaUpdated->getLocation();

            $sqlQuery = "UPDATE cinemas SET name = :name, location = :location WHERE (id = :id)";

            $parameters['id'] = $id;
            $parameters['name'] = $name;
            $parameters['location'] = $location;

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

        public function addRooms (Cinema $cinema) /* --arreglar metodo-- */
        {   
            $sqlQuery = "SELECT * FROM rooms 
            WHERE idcinema = :id;";

            $parameters['id'] = $cinema;

            try
            {
                $this->connection = Connection::getInstance();
                $result = $this->connection->execute($sqlQuery, $parameters);
            }
            catch(PDOException $ex)
            {
                throw $ex;
            }

            if(empty($result))
            {
                return $this->mapout($result);
            }
            else 
            {
                return false;
            }
        }

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                return new Cinema($p['id'],/*$p['roomsId'],*/$p['location'], $p['name']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>


