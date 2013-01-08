<?php

class DbConfig {
	
	protected $hostName;
	protected $userName;
	protected $password;
	protected $databaseName; 
	
	function  __construct() {
		$this->hostName = "localhost";
		$this->userName = "root";
		$this->password = "";
		$this->databaseName = "fakruddin_biryani_uk";
	}

}

?>