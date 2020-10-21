<?php 
namespace Models;
class Type{
    /*precio	idType(PK)	tipodesala*/
    private $idType;
	private $price;
	private $tipeOfRoom;


	public function __construct($idType=0, $price=0, $tipeOfRoom=' ')
	{
		$this->idType = $idType;
		$this->price = $price;
		$this->tipeOfRoom = $tipeOfRoom;
	}
    public function getIdType()
    {
        return $this->idType;
    }

    public function setIdType($idType)
    {
        $this->idType = $idType;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getTipeOfRoom()
    {
        return $this->tipeOfRoom;
    }

 
    public function setTipeOfRoom($tipeOfRoom)
    {
        $this->tipeOfRoom = $tipeOfRoom;

        return $this;
    }
}



 ?>