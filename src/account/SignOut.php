<?php
class SignOut{
    static function cleanCookieAndJump() {
        SignOut::cleanCookie();
        SignOut::jump();
    }
    static function cleanCookie() {
        setcookie("user_id", "",time()-3600,"/");
    }

    static function jump() {
        header("location:/");
    }
}

SignOut::cleanCookieAndJump();
?>