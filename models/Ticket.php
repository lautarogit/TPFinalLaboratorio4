<?php
    namespace Models;

    class Ticket 
    {
        private $id;
        private $codeQR;
        private $function;
        private $user;



    public function __construct($id=' ', $codeQR=' ', $function=' ', $user=' ')
    {
        $this->id = $id;
        $this->codeQR = $codeQR;
        $this->function = $function;
        $this->user = $user;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getCodeQR()
    {
        return $this->codeQR;
    }


    public function setCodeQR($codeQR)
    {
        $this->codeQR = $codeQR;

        return $this;
    }

    public function getFunction()
    {
        return $this->function;
    }

    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
?>
