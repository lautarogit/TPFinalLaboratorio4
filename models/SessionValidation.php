<?php
    namespace Models;

    class SessionValidation
    {
        public static function validateSession ()
        {
            if(!isset($_SESSION["loggedUser"]))
            {
                header("location:../index.php"); 
            }    
        }
    }
?>