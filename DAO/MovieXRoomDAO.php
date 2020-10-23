<?php
namespace DAO;
use Models\Room as MovieXRoom;

class MovieXRoomDAO {
 private $functionList;
 public function add (MovieXRoom $function)
 {
    $this->retrieveData();
    $function->setId(sizeof($this->functionList)+1);
     array_push($this->functionList, $function);
     $this->saveData();
   
 }

 public function getAll ()
 {
     $this->retrieveData();
     return $this->functionList;
 }

 public function delete (MovieXRoom $functionDeleted)
 {
     $this->retrieveData();
     $newList = array();

     foreach ($this->functionList as $function) 
     {
         if($function->getCode() != $functionDeleted->getId())
         {
             array_push($newList, $function);
         }
     }

     $this->functionList = $newList;
     $this->saveData();
 }
 public function saveData ()
 {
     $arrayToEncode = array();
     $jsonPath = $this->getJsonFilePath();

     foreach ($this->functionList as $function) 
     {
     
         $arrayValue['id'] = $function->getId();
        $arrayValue['date']=$function->getDate();
        $arrayValue['movie']=$function->getMovie();
        $arrayValue['room']=$function->getRoom();

        
         array_push($arrayToEncode,$arrayValue)
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
         $function = new MovieXRoom(
        $arrayValue['id'],
         $arrayValue['Date'],
         $arrayValue['movie'],
         $arrayValue['room']);
                 
         array_push($this->functionList, $function );
     }
 }

 public function getJsonFilePath ()
 {
     $initialPath = "Data/function.json";

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



?>