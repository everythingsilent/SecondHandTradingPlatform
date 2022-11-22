<?php
class Database{
	static $host="localhost";
	static $dbname="usedGoods";
	static $user="root";
	static $pass="123456";
	public $conn;
	
	function __destruct(){
		if($this->conn){
			@$this->conn->close();
		}
	}

	function open(){
		$this->conn=@new mysqli(self::$host, self::$user, self::$pass, self::$dbname);
		if(mysqli_connect_errno()){
			return false;
		}
        $this->conn->query("SET NAMES utf8");
        return true;
	}
}
?>