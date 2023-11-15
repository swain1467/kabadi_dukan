<?php
require_once("../config.php");
include(LIBS.'phpMailer/PHPMailerAutoload.php');
class SendMail{
	public static function sendEmail($to,$subject, $msg){
		$mail = new PHPMailer(); 
		$mail->IsSMTP(); 
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = "smtp.gmail.com";
		$mail->Port = "465"; 
		$mail->IsHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Username = EMAIL_ID;
		$mail->Password = EMAIL_PASSWORD;
		$mail->SetFrom(EMAIL_ID);
		$mail->Subject = $subject;
		$mail->Body =$msg;
		$mail->AddAddress($to);
		$mail->SMTPOptions=array('ssl'=>array(
			'verify_peer'=>false,
			'verify_peer_name'=>false,
			'allow_self_signed'=>false
		));
		if(!$mail->Send()){
			return 0;
		}else{
			return 1;
		}
	}
}
?>

