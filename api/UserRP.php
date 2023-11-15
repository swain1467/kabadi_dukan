<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "gen_otp.php");
require_once(ASSET . "send_mail.php");
session_start();

$action = $_REQUEST['action'];

try{
    switch($action){
        case 'SendOTP':{
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
            $output = ChangePasswordModel::SendOTP($email, $captcha);
            break;
        }
        case 'UpdatePassword':{
            $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $output = ChangePasswordModel::UpdatePassword($otp, $password, $confirm_password, $email);
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
class ChangePasswordModel {
    public static function SendOTP($email, $captcha) {
        $output = array('status' => '', 'message' => '');
        if(!$email){
            throw new Exception('Email is required');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new Exception('Invalid email format');
        }
        if($_SESSION['CAPTCHA_CODE'] !== $captcha){
            throw new Exception('Invalid captcha');
        }
        $data = [
            'email' => $email,
            'status' => 1
        ];
        $selectQuery = "SELECT id FROM user_master WHERE mail_address = :email AND status = :status";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        //check for active user 
       if(COUNT($all_rows) > 0){
            $otp = OTP::genOTP();
            $data = [
                'otp' => $otp,
                'updated' => date("Y-m-d H:i:s"),
                'email' => $email
            ];
            //Insert user data
            $updateQuery = "UPDATE user_master SET otp = :otp, updated = :updated 
            WHERE mail_address = :email";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
            if($res == 1){
                //Send OTP to user
                $email_subject = "Password Change OTP";
                $email_body = "Hi! Your otp is <b>".$otp."</b><br><br><br><br>";
                $email_body .="Thanks<br>renthelpline.com";
                if(SendMail::sendEmail($email, $email_subject, $email_body)){
                    $output['status'] = 'Success';
                    $output['message'] = 'An OTP has been sent to your mail id';
                } else {
                    $output['status'] = 'Failure';
                    $output['message'] = 'Oops! something Went wrong. Please click on Resend OTP';
                }
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
       } else {
            $output['status'] = 'Failure';
            $output['message'] = 'This email id is not in our record';
       }
       return $output;
    }
    public static function UpdatePassword($otp, $password, $confirm_password, $email) {
        $output = array('status' => '', 'message' => '');
        if(!$otp){
            throw new Exception('OTP is required');
        }
        if(!$password){
            throw new Exception('Password is required');
        } 
        if(!$confirm_password){
            throw new Exception('Confirm password is required');
        }
        if($confirm_password != $password){
            throw new Exception('Create new password and Confirm password is not same');
        }
        $enc_password = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'enc_password' => $enc_password,
            'updated' => date("Y-m-d H:i:s"),
            'otp' => $otp,
            'email' => $email
        ];
        $updateQuery = "UPDATE user_master SET enc_password = :enc_password, updated = :updated 
                        WHERE otp = :otp AND mail_address = :email";
        $result = DBCore::executeQuery($updateQuery,$data);
        $res = DBCore::rowAffected($result);
    
        if($res == 1){
            $output['status'] = 'Success';
            $output['message'] = 'Password updated! Please login with credentials';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Invalid OTP';
        }
       return $output;
    }
}
?>