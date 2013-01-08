<?php

include("./config/DbConfig.php");

class DbConnection extends DbConfig {

	public $dbConnection;
	public $sqlQuery;
	
	protected $hostName;
	protected $userName;
	protected $password;
	protected $databaseName;
	
	function __construct() {
			
		$dbObj = new DbConfig();
		$this->hostName =  $dbObj->hostName;
		$this->userName =  $dbObj->userName;
		$this->password =  $dbObj->password;
		$this->databaseName =  $dbObj->databaseName;
		
	}
	
	function  connect_db() {
		
		$this->dbConnection = mysql_pconnect($this->hostName, $this->userName, $this->password) or die("Couldnot Connect to Database.".mysql_error());
		if($this->dbConnection) {
			mysql_select_db($this->databaseName, $this->dbConnection) or die("Wrong Database".mysql_error());
		}
	}
	
	function  close_db() {
		
		mysql_close($this->dbConnection);
		$this->sqlQuery =null;
		
	}
	
	function insertDb($tableName, $values) {
	
		$this->sqlQuery = "INSERT INTO $tableName SET ";
		foreach($values as $key=>$val) {
			$this->sqlQuery = $this->sqlQuery.$key." = '".mysql_real_escape_string((strtolower($val)))."' , ";
		}
		$this->sqlQuery = substr($this->sqlQuery, 0, (strlen($this->sqlQuery)-2));
		return mysql_query($this->sqlQuery);
	}
	
	function selectDb_count($tableName, $whereValues) {
	
		$selQueryCNT = "SELECT COUNT(*) as CNT FROM $tableName WHERE ";
		foreach($whereValues as $key=>$val) {
			$selQueryCNT = $selQueryCNT.$key." = '".mysql_real_escape_string((strtolower($val)))."' && ";
		}
		$selQueryCNT = substr($selQueryCNT, 0, (strlen($selQueryCNT)-3));
		$rsQuerySelectCNT =  mysql_query($selQueryCNT);
		$rowQuerySelectCNT = mysql_fetch_object($rsQuerySelectCNT);
		return $rowQuerySelectCNT->CNT;
	}
}

?>