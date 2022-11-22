<?php
include_once dirname(__DIR__) . "\common\Database.php";

class RegisterAccount extends Database{
    public $userAccount;
    public $userPassword;
	

	function checkInformation() {
		$this->getUserInfomation();

		$isExistNull = empty($this->userAccount) || empty($this->userPassword);
		if ($isExistNull) {
			$this->backAndPrompt('注册信息存在空值，请输入账号及密码信息。');
		}else {
			$this->checkExistAccount();
		}
	}

	function getUserInfomation() {
		$this->userAccount = $_GET['userAccount'];
		$this->userPassword = $_GET['userPassword'];
	}

	function backAndPrompt($infomation) {
		$this->prompt($infomation);
		$this->historyBack();
	}

	function historyBack() {
		echo "<script language='JavaScript'>history.back();</script>";
	}

	function prompt($infomation) {
		echo "<script language='JavaScript'>alert('$infomation');</script>";
	}

	function checkExistAccount() {
		$isExistAccount = !empty($this->findAccount());
		if ($isExistAccount) {
			$this->backAndPrompt('账号已存在，注册失败。');
		}else {
			$this->register();
		}
	}

	function findAccount() {
		if ($this->open()){
            $userIds = array();

            $sql = "select user_id from account where user_account=?";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("s",$this->userAccount);
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

	function register() {
		if ($this->open()){
            $sql = "insert into account(user_account, user_password) values(?, ?)";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("ss",$this->userAccount, $this->userPassword);
			if($stmt -> execute()) {
                $this->Prompt('注册成功。');
				$this->jump('/account/login.html');
            }
            $stmt->close();
        }
	}

	function jump($path) {
		echo "<script>window.location.replace('$path')</script>";
	}
}


$register = new RegisterAccount;
$register->checkInformation();

?>