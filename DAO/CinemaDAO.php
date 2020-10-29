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
            $parameters['status'] = $cinema->getStatus();

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
                $result = $this->mapout($result);

                $cinemaList = array();

                if(!is_array($result))
                {
                   array_push($cinemaList, $result);
                }
            }
            else 
            {
                $result =  false;
            }

            if(!empty($cinemaList))
            {
                $finalResult = $cinemaList;  
            }
            else
            {
                $finalResult = $result;
            }

            return $finalResult;
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

        public function getCinemaByName ($name)
        {
            $sqlQuery = "SELECT * FROM cinemas WHERE name = :name";

            $parameters['name'] = $name;

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

        public function edit (Cinema $cinemaUpdated)
        {
            $id = $cinemaUpdated->getId();
            $name = $cinemaUpdated->getName();
            $location = $cinemaUpdated->getLocation();
            $status = $cinemaUpdated->getStatus();

            $sqlQuery = "UPDATE cinemas SET name = :name, location = :location, status = :status WHERE (id = :id)";

            $parameters['id'] = $id;
            $parameters['name'] = $name;
            $parameters['location'] = $location;
            $parameters['status'] = $status;

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

        public function validateData ($name)
        {
            $sqlQuery = "SELECT * FROM cinemas
            WHERE name = :name";

            $parameters['name'] = $name;

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
                return new Cinema($p['id'], $p['location'], $p['name'], $p['status']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>


