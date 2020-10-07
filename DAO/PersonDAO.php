<?php 
namespace DAO
use Models\Person as Person;
class PersonDao /*implements IPersonDao*/{
	private $personList= array();
	function add($person){
		$this->retrieveData();
		array_push($personList,$person);
		$this->saveData();
	}
	function retrieveData(){

	}
	function saveData(){
		
	}

}

 ?>