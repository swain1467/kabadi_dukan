<?php
class OTP {
    public static function genOTP(){
        $length = 6;
        $str = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
        return substr(str_shuffle($str), 0, $length);
    }
} 
?>