<?php
namespace DAO;
use Models\Type as Type;
class TypeDAO {
    private $typeList ;
    public function add (Type $type)
        {
            $this->retrieveData();
            $type->setIdType(sizeof($this->typeList)+1);
            array_push($this->typeList, $type);
            $this->saveData();
        }

        public function getAll ()
        {
            $this->retrieveData();
            return $this->typeList;
        }

        public function delete (Type $typeDeleted)
        {
            $this->retrieveData();
            $newList = array();

            foreach ($this->typeList as $type) 
            {
                if($type->getCode() != $type->getId())
                {
                    array_push($newList, $type);
                }
            }

            $this->typeList = $newList;
            $this->saveData();
        }

        public function saveData ()
        {
            $arrayToEncode = array();
            $jsonPath = $this->getJsonFilePath();

            foreach ($this->typeList as $type) 
            {
                $arrayValue['idType'] = $type->getId();
                $arrayValue['price'] = $type->getCodeQR();
                $arrayValue['tipeOfRoom'] = $type->getFunction();
             
                array_push($arrayToEncode,$arrayValue);
            }

            $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
            file_put_contents($jsonPath,$jsonContent);
        }

        public function retrieveData ()
        {
            $this->ticketList = array();
            $jsonPath = $this->getJsonFilePath();
            $jsonContent = file_get_contents($jsonPath);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $arrayValue) 
            {
                $type = new Type(
                $arrayValue['idType'],
                $arrayValue['price'],
                $arrayValue['tipeOfRoom']);
     
                        
                array_push($this->typeList, $type);
            }
        }

        public function getJsonFilePath ()
        {
            $initialPath = "Data/type.json";

            if(file_exists($initialPath))
            {
                $jsonFilePath = $initialPath;
            }
            else
            {
                $jsonFilePath = "../".$initialPath;
            }

            return $jsonFilePath;
        }
    }


}
?>