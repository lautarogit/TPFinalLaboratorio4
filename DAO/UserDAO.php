<?php
    namespace DAO;
    
    use Models\User as User;
    use \PDOException as PDOException;
    use DAO\Connection as Connection;

    class UserDAO
    {
        private $connection;

        public function getAll()
        {
            
        }

        public function add (User $user)
        {
            $sqlQuery = "INSERT INTO users (userName, password, rolId, firstName, lastName, dni, email) 
            VALUES (:userName, :password, :rolId, :firstName, :lastName, :dni, :email)";

            $parameters['userName'] = $user->getUserName();
            $parameters['password'] = $user->getPassword();
            $parameters['rolId'] = $user->getRolId();
            $parameters['firstName'] = $user->getFirstName();
            $parameters['lastName'] = $user->getLastName();
            $parameters['dni'] = $user->getDni();
            $parameters['email'] = $user->getEmail();

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

        public function getUserByUserName ($userName)
        {
            $sqlQuery = "SELECT * FROM users WHERE userName = :userName";

            $parameters['userName'] = $userName;

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
                $mappedResultSet = $this->mapout($resultSet);
            }
            else
            {
                $mappedResultSet = false;
            }

            return $mappedResultSet;
        }

        public function mapout ($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                return new User($p['userName'], $p['password'], $p['rolId'], $p['firstName'], $p['lastName'], $p['dni'], $p['email']);
            }, $value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>