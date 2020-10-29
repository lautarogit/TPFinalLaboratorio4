<?php
    namespace Controllers; 
    
    interface iValidation
    {
        function validateFormField ($param_name, $minLength = '', $maxLength = ''); 
    }
?>