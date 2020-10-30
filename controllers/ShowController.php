<?php
    namespace Controllers;

    use Models\Room as Room;
    use Models\Show as Show;
    use DAO\RoomDAO as RoomDAO;
    use Controllers\iValidation as iValidation;

    class ShowController implements iValidation
    {
        private $roomDAO;

        public function __construct ()
        {
            $this->roomDAO = new RoomDAO();
        }

        public function showAddView ()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-show.php");
        }

        public function showClientCinemaDashboard ()
        {
            
        }

        public function addShow ($name, $location)
        {
            
        }

        public function editShow ($id, $name, $location, $status)
        {
            
        }

        public function validateFormField ($paramName, $minLength = '', $maxLength = '') 
        {
            if(!empty(trim($paramName)))
            {
                if(!empty($minLenght) && !empty($maxLength))
                {
                    if((strlen($paramName) >= $minLength) && (strlen($paramName) <= $maxLength))
                    {
                        $flag = true;
                    } 
                    else
                    {
                        $flag = false;
                    } 
                }
                else
                {
                    $flag = true;
                }  
            }
            else
            {
                $flag = false;
            } 

            return $flag;
        }
    }
?>