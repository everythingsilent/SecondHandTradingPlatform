<?php
header('Content-Type: application/json');

include_once __DIR__ . "/Database.php";

class RegisterAccount extends Database{
    public $accountName;
    public $password;


    function checkInformation() {
        $this->getInformation();

        $isExistNull = (empty($this->accountName) || empty($this->password));
        if($isExistNull){
            echo json_encode(array("information"=>"传输信息存在空值"));
        }else{
            $this->accountRegister();
        }
    }


    function getInformation() {
        $this->accountName = $_GET['username']?$_GET["username"]:$_POST["username"];
        $this->password = $_GET['userpasswd']?$_GET['userpasswd']:$_POST['userpasswd'];
    }


    function accountRegister() {
        if(empty($this->findAccount())){
            $this->insertAccount();
        }else{
            echo json_encode(array("information"=>"账号已存在"));
        }
    }


    function findAccount() {
        if ($this->open()){
            $userIds = array();

            $sql = "select userid from account where username=?";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("s",$this->accountName);
            $stmt -> bind_result($this->userId); 
			if ($stmt -> execute()) {
                while ($stmt -> fetch()) 
                {
                    array_push($userIds, $this->userId);
                }
                $stmt->free_result();
                $stmt->close();
            }
            return $userIds;
        }
    }

    
    function insertAccount() {
        if ($this->open()){
            $sql = "insert into account(username, password) values(?, ?)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("ss",$this->accountName, $this->password);
			if($stmt -> execute()) {
                echo json_encode(array("information"=>"注册成功"));
            }
            $stmt->close();
        }
    }
}
$register = new RegisterAccount;
$register->checkInformation();

?>