<?php
include_once __DIR__ . "/Database.php";

class AccountVerifyer extends Database{
    public $userName;
    public $userPasswd;
    public $verifyUserName;
    public $verifyUserPasswd;

    public $userId;


    function verifyAccount() {
        $this->getUserInputAccount();
        $this->getVerifyAccount();
        
        $isExistNullValue = empty($this->userName) || empty($this->userPasswd);
        if ($isExistNullValue) {
            $info = $this->existNullValue();
        }else{
            $info = $this->accountComparison();
        }

        $this->json_output($info);
    }


    function getUserInputAccount() {
        $this->userName = $_GET['username']?$_GET['username']:$_POST['username'];
        $this->userPasswd = $_GET['userpasswd']?$_GET['userpasswd']:$_POST['userpasswd'];
    }


    function getVerifyAccount() {
        if ($this->open()){
            $sql = "select userid, username, password from account where username=?";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("s",$this->userName);
            $stmt -> bind_result($this->userId, $this->verifyUserName, $this->verifyUserPasswd); 
			$stmt -> execute();
			while ($stmt -> fetch()) 
            {
            }
            $stmt->free_result();
            $stmt->close();
        }    
    }


    function existNullValue(){
        $info = json_encode(array('verify' => "exist null value"));
        return $info;
    }


    function accountComparison() {
        $isequal = ($this->userName == $this->verifyUserName) && ($this->verifyUserPasswd == $this->userPasswd);
        if ($isequal){
            $info = json_encode(array('verify' => "accept", 'userId' => $this->userId));
        }else{
            $info = json_encode(array('verify' => "reject"));
        }
        return $info;
    }

    
    function json_output($info) {
        header('Content-Type: application/json');
        echo ($info);
    }
}

$verifyer = new AccountVerifyer;
$verifyer->verifyAccount();
?>