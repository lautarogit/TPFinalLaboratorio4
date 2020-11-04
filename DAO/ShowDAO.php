<?php
    namespace DAO;
    
    use Models\Show as Show;
    use Models\ShowMapout  as ShowMapout;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class ShowDAO
    {
        private $connection;

        public function add (Show $show)
        {
            $id = $show->getId();
            $idRoom = $show->getRoom()->getId();
            $idMovie = $show->getMovie()->getId();
            $dateTime = $show->getDateTime();
            $remainingTickets = $show->getRemainingTickets();

            $sqlQuery = "INSERT INTO shows (id, idRoom, idMovie, dateTime, remainingTickets) 
            VALUES (:id, :idRoom, :idMovie, :dateTime, :remainingTickets)";

            $parameters['id'] = $id;
            $parameters['idRoom'] = $idRoom;
            $parameters['idMovie'] = $idMovie;
            $parameters['dateTime'] = $dateTime;
            $parameters['remainingTickets'] = $remainingTickets;

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
            $sqlQuery = "SELECT * 
            FROM shows";
            
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

                $showList = array();

                if(!is_array($result))
                {
                   array_push($showList, $result);
                }
            }
            else 
            {
                $result =  false;
            }

            if(!empty($showList))
            {
                $finalResult = $showList;  
            }
            else
            {
                $finalResult = $result;
            }

            return $finalResult;
        }

        public function getShowByIdRoom ($idRoom)
        {
            $sqlQuery = "SELECT * 
            FROM shows 
            WHERE idRoom = :idRoom";

            $parameters['idRoom'] = $idRoom;

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
                $show = $this->mapout($resultSet);
            }
            else
            {
                $show = false;
            }

            return $show;
        }

        public function getShowByIdCinemaAndIdMovie ($idCinema, $idMovie)
        {
            $sqlQuery = "SELECT *
            FROM shows s
            INNER JOIN rooms r 
            ON s.idRoom = r.id
            WHERE r.idCinema = :idCinema
            AND s.idMovie = :idMovie";

            $parameters['idCinema'] = $idCinema;
            $parameters['idMovie'] = $idMovie;

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
                $show = $this->mapout($resultSet);
            }
            else
            {
                $show = false;
            }

            return $show;
        }

        public function getShowByIdMovie ($idMovie)
        {
            $sqlQuery = "SELECT * 
            FROM shows 
            WHERE idMovie = :idMovie";

            $parameters['idMovie'] = $idMovie;

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
                $show = $this->mapout($resultSet);
            }
            else
            {
                $show = false;
            }

            return $show;
        }

        public function getShowMovieByIdCinema ($idMovie, $idCinema)
        {
            $sqlQuery = "SELECT s.idMovie
            FROM shows s
            INNER JOIN rooms r 
            ON s.idRoom = r.id
            WHERE r.idCinema = :idCinema
            AND s.idMovie = :idMovie";

            $parameters['idMovie'] = $idMovie;
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
                $movie = true;
            }
            else
            {
                $movie = false;
            }

            return $movie;
        }

        public function getShowById ($id)
        {
            $sqlQuery = "SELECT * 
            FROM shows 
            WHERE id = :id";

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
                $show = $this->mapout($resultSet);
            }
            else
            {
                $show = false;
            }

            return $show;
        }

        public function edit (show $showUpdated)
        {
            $id = $showUpdated->getId();
            $idRoom = $showUpdated->getRoom()->getId();
            $idMovie = $showUpdated->getMovie()->getId();
            $dateTime = $showUpdated->getDateTime();
            $remainingTickets = $showUpdated->getRemainingTickets();

            $sqlQuery = "UPDATE shows 
            SET idRoom = :idRoom, idMovie = :idMovie, dateTime = :dateTime, remainingTickets = :remainingTickets 
            WHERE (id = :id)";

            $parameters['id'] = $id;
            $parameters['idRoom'] = $idRoom;
            $parameters['idMovie'] = $idMovie;
            $parameters['dateTime'] = $dateTime;
            $parameters['remainingTickets'] = $remainingTickets;

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

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p)
            {
                return new ShowMapout ($p['id'], $p['idRoom'], $p['idMovie'], $p['dateTime'], $p['remainingTickets']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>