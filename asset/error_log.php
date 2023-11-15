<?php
require_once("../config.php");

function arrayToStr($arr){
    return json_encode($arr);
}

class ErrorLog{
    public static function log($content){
        if(is_array($content))
        {
            $content = arrayToStr($content);
        }
        $user_name = $_SESSION['id']; 
        $date = date('d-m-y');
        $time = date('d-m-y h:i:s');
        
        if(file_exists(LOG.$date.".txt")){
            $file = fopen(LOG.$date.".txt","a");
            fwrite($file,$time."::".$user_name."\n");
            fwrite($file,$content."\n\n");
            fclose($file);
        } else{
            $file = fopen(LOG.$date.".txt","w");
            fwrite($file,$time."::".$user_name."\n");
            fwrite($file,$content."\n\n");
            fclose($file);
        }
    }
}
?>