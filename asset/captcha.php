<?php
require_once("../config.php");
require_once(ASSET . "gen_otp.php");
  session_start();
  // Generate captcha code
  $random_num    = OTP::genOTP();
  $captcha_code  = substr($random_num, 0, 6);
  // Assign captcha in session
  $_SESSION['CAPTCHA_CODE'] = $captcha_code;
  // Create captcha image
  $layer = imagecreatetruecolor(168, 37);
  $captcha_bg = imagecolorallocate($layer, 141, 170, 62);
  imagefill($layer, 0, 0, $captcha_bg);
  $captcha_text_color = imagecolorallocate($layer, 255, 255, 255);
  imagestring($layer, 5, 55, 10, $captcha_code, $captcha_text_color);
  header("Content-type: image/jpeg");
  imagejpeg($layer);
?>