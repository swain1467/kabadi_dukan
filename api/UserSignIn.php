<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
session_start();
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'VerifyUser':{
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
            $output = LoginModel::VerifyUser($email, $password, $captcha);
            break;
        }
    }
}catch(Exception $e){
    $output = array(	
        'status' => 'Error',
        'message' => $e->getMessage(),
    );
}finally{
    echo json_encode($output);
}
//Model Start From Here
class LoginModel {
    public static function VerifyUser($email, $password, $captcha) {
        $output = array('status' => '', 'message' => '');
        if(!$email){
            throw new Exception('Email is required');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new Exception('Invalid email format');
        }
        if(!$password){
            throw new Exception('Passsword is required');
        }
        if($_SESSION['CAPTCHA_CODE'] !== $captcha){
            throw new Exception('Invalid captcha');
        }
        $data = [
            'email' => $email,
            'status' => 1
        ];
        $selectQuery = "SELECT * FROM user_master WHERE mail_address = :email AND status = :status";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        //Check duplicate email 
       if(COUNT($all_rows) > 0){
            foreach($all_rows as $row){
                $_SESSION['id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['mail_address'] = $row['mail_address'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['status'] = $row['status'];
                $enc_password = $row['enc_password'];
            }
            $verify = password_verify($password, $enc_password);
            if($verify && $_SESSION['status'])
            {    
                $output['status'] = 'Success';
                $output['message'] = 'Login successful';
            }
            else
            {
                $output['status'] = 'Failure';
                $output['message'] = 'Invalid  password';
            }
       } else {
            $output['status'] = 'Failure';
            $output['message'] = 'Invalid  email address';
       }
       return $output;
    }
}
?>