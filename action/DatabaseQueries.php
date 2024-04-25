<?php

trait DatabaseQueries{

    var $host = 'localhost';
    var $dataBaseName = 'bank-chris';
    var $userName = 'root';
    var $dataBasePassword = '';
    var $dbConnection;

    //connection to data base
    public function connectToDb(){

        $this->dbConnection = mysqli_connect($this->host,$this->userName, $this->dataBasePassword,$this->dataBaseName) or die(mysqli_error($this->dbConnection));

    }

    function createDb($dataBaseName){
        $query = "CREATE DATABASE $dataBaseName";
        $result = $this->runMysqliQuery($query);
        return $result;
    }
    function createUniqueIdD($table_name, $column)
	{

		$unique_id = $this->picker();
		$query = "SELECT * FROM " . $table_name . " WHERE " . $column . " = '$unique_id'";

		//check for the database count from the database"unique_id"
		$this->generalSelectStatement($query);
		$rowcount = $this->_general_count;
		if ($rowcount == 0) {
			return $unique_id;
		} else {
			$this->createUniqueId($query);
		}
	}

    //runs our query
    function runMysqliQuery(string $query) : array{
        //mysqli_query function will excute the query passed to it
        $result = mysqli_query($this->dbConnection, $query);
        if($result){
            return ['error_code'=>0, 'data'=>$result];//no error
        }else{
            return ['error_code'=>1, 'error'=>mysqli_error($this->dbConnection)];//error dey
        }

    }

    function checkUniqueValueInDatabase($table, $columnName, $value){

        $query = "SELECT * FROM $table WHERE $columnName = '$value'";
        $result = $this->runMysqliQuery($query);
        return mysqli_num_rows($result['data']);
     }

     function createUniqueID($tableName, $columnName){
         $unique_id = uniqid();
         $result = $this->checkUniqueValueInDatabase($tableName, $columnName, $unique_id);
         if($result > 0){
             $this->createUniqueID($tableName, $columnName);//recursion
         }else{
             return $unique_id;
         }
     }



     //hash password
    public function hasHer($password){
        return hash('sha256', md5($password));
    }

    //run login query select
    function loginHandler($email, $password){
        $query = "SELECT * FROM user WHERE password = '$password' AND email = '$email'";
        $result = $this->runMysqliQuery($query);
        return $result;
    }
    function loginAdminsHandler($email, $password){
        $query = "SELECT * FROM admin WHERE password = '$password' AND email = '$email'";
        $result = $this->runMysqliQuery($query);
        return $result;
    }



}



?>
