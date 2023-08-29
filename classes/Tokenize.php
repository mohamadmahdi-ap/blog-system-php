<?php
class Tokenize{
    public static function start_sesstion(){
        if(!isset($_SESSION)){
            session_start();
        }
    }
    public static function generate($token){
        self::start_sesstion();
        $_SESSION['csrf_token'] = $token;
    }
    public static function validate_token($token = '') :bool{
        self::start_sesstion();
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        if ($_SESSION['csrf_token'] == '') {
            return false;
        }
        if(!empty($token)){
            if ($_SESSION['csrf_token'] !== $token) {
                return false;
            }
        }
        return True;
    }
    public static function get_token(){
        self::start_sesstion();
        return $_SESSION['csrf_token'];
    }
    public static function remove_token(){
        self::generate("");
        unset($_SESSION['csrf_token']);
    }
}