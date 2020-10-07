<?php
namespace Models;

class Ticket
{
    private $seat;
    private $date;
    private $value;
	public function __construct()
	{
		
	}
    
    public function getSeat()
    {
        return $this->seat;
    }

    public function setSeat($seat)
    {
        $this->seat = $seat;

    }

    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = $value;
    }
}
?>