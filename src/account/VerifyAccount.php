<?php
include_once dirname(__DIR__) . "\common\Database.php";

class AccountVerifyer extends Database{
    public $userAccount;
    public $userPassword;
	
    public $userId;
    public $verifyUserAccount;
    public $verifyUserPasswd;

	function checkInformation() {
		$this->getUserInfomation();

		$isExistNull = empty($this->userAccount) || empty($this->userPassword);
		if ($isExistNull) {
			$this->backAndPrompt('登录信息存在空值，请输入账号及密码信息。');
		}else {
			$this->verifyAccount();
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

    function verifyAccount() {
        $this->getVerifyInformation();

        $isExistVerifyAccount = empty($this->userId);
        if($isExistVerifyAccount) {
            $this->backAndPrompt('不存在该用户。');
        }else {
            $this->comparison();
        }
    }

    function getVerifyInformation() {
        if ($this->open()){
            $sql = "select user_id, user_account, user_password from account where user_account=?";
            $stmt = $this -> conn -> prepare($sql);
            $stmt -> bind_param("s",$this->userAccount);
            $stmt -> bind_result($this->userId, $this->verifyUserAccount, $this->verifyUserPassword); 
			$stmt -> execute();
			while ($stmt -> fetch()) 
            {
            }
            $stmt->free_result();
            $stmt->close();
        }    
    }

    function comparison() {
        $comparisonAccount = $this->userAccount == $this->verifyUserAccount;
        $comparisonPassword = $this->userPassword == $this->verifyUserPassword;
        $isComparisonSuccess = $comparisonAccount && $comparisonPassword;
        if ($isComparisonSuccess) {
            $this->comparisonSuccess();
        }else {
            $this->backAndPrompt('账号或密码错误');
        }
    }

    function comparisonSuccess() {
        $this->cookieSetUserID();
        $this->prompt('登录成功');
        $this->jump();
    }

    function cookieSetUserID() {
        setcookie("user_id", $this->userId,time()+3600*12,'/');
    }

    function jump() {
        echo "<script>window.location.replace('/')</script>";
    }
}

$verifyer = new AccountVerifyer;
$verifyer->checkInformation();
?>