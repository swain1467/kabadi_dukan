<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "gen_otp.php");
require_once(ASSET . "send_mail.php");
session_start();
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'InsertUser':{
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : '';
            $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
            $output = SignupModel::InsertUser($name, $contact_no, $email, $captcha);
            break;
        }
        case 'UpdatePassword':{
            $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $output = SignupModel::UpdatePassword($otp, $password, $confirm_password, $email);
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
class SignupModel {
    public static function InsertUser($name, $contact_no, $email, $captcha) {
        $output = array('status' => '', 'message' => '');
        if(!$name){
            throw new Exception('Name is required');
        }
        if(!$contact_no){
            throw new Exception('Contact number is required');
        } 
        if (filter_var($contact_no, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid contact number');
        }
        if(!$email){
            throw new Exception('Email is required');
        } 
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
            'emal_address' => $email
        ];
        $selectQuery = "SELECT id FROM user_master WHERE mail_address = :emal_address";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        //Check duplicate email 
       if(COUNT($all_rows) == 0){
            $otp = OTP::genOTP();
            $data = [
                'name' => $name,
                'contact_no' => $contact_no,
                'email' => $email,
                'otp' => $otp,
                'created' => date("Y-m-d H:i:s"),
                'updated' => date("Y-m-d H:i:s")
            ];
            //Insert user data
            $inserQuery = "INSERT INTO user_master(name, contact_no, mail_address, otp, created, updated)
            VALUES (:name, :contact_no, :email, :otp, :created, :updated)";
            $result = DBCore::executeQuery($inserQuery,$data);

            if($result['status']){
                //Send OTP to user
                $email_subject = "Verification Code";
                $email_body = "Hi ".$name.". Your otp is <b>".$otp."</b><br><br><br><br>";
                $email_body .="Thanks<br>kabadidukan.com";
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
            $output['message'] = 'This email id is already exist';
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
            throw new Exception('Password and Confirm password is not same');
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
            $output['message'] = 'Password created! Please login with credentials';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! something Went wrong. Please try again';
        }
       return $output;
    }
}
?>