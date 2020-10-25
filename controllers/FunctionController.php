<?php

    namespace Controllers;
    use DAO\MovieXRoomDAO as MovieXRoomDAO;

    class FUnctionController
    {
        private $functionDAO;

        /*valida si se puede agregar una funcion */
        public function checkAdd ($function)
        {
            $this->functionDAO->retrieveData();  

            foreach($this->functionDAO->functionList as $funct)
            {
                if($funct->getMovie()==$function->getMovie()&&$funct->getDate()==$function->getDate())
                {
            
                }
                else
                {
                    return true;
                }

            }

        }
    }
?>