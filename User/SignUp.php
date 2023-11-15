<?php
require_once("../config.php");
require_once(ASSET . "cdn_links.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo LOGO ?>
    <title><?php echo TITLE ?></title>
    <?php cssLink(); ?>
    <link href=<?php echo URL_ASSET."css/custom/user_auth_style.css"; ?> rel="stylesheet">
</head>
<body>
	<div class="container"> 
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="logo">
                    <a href="Home">
                        <img src="../asset/img/Logo.png" alt="Logo">
                    </a>
                </div>
                <div class="text-center mt-4 name">
                    <b><?php echo TITLE ?></b>
                </div>
                <br>
                <div id="RegDiv">
                    <div class="form-field align-items-center">
                        <span class="fa fa-user"></span>
                        <input type="text" name="txtName" id="txtName" placeholder="Enter Name" autocomplete="off" />
                    </div>
                    <br>
                    <div class="form-field align-items-center">
                        <span class="fa fa-phone"></span>
                        <input type="text" name="txtContactNo" id="txtContactNo" placeholder="Enter Contact No." autocomplete="off" />
                    </div>
                    <br>
                    <div class="form-field align-items-center">
                        <span class="fa fa-envelope"></span>
                        <input type="text" name="txtEmail" id="txtEmail" placeholder="Enter Email Address (Required for verification)" autocomplete="off" />
                    </div>
                    <br>
                    <div class="form-field align-items-center">
                        <span class="fa fa-refresh"></span>
                        <input type="text" name="txtCaptcha" id="txtCaptcha" placeholder="Enter Captcha" autocomplete="off" />
                        <img src="../asset/captcha" alt="Captcha">
                    </div>
                    <br>
                    <button style="width:100%; margin-top:10px" id="btnSendOTP" class="btn btn-dark">Send OTP <i class="fa fa-paper-plane fa-lg"></i></button>
                    <br>
                    <button style="width:100%; margin-top:10px" id="btnSignIn" class="btn btn-warning">Sign In <i class="fa fa-arrow-circle-right fa-lg"></i></button>
                </div>
                <div id="OTP">
                    <div class="form-field align-items-center">
                        <span class="fa fa-lock"></span>
                        <input type="text" name="txtOTP" id="txtOTP" placeholder="Enter OTP" autocomplete="off" />
                    </div>
                    <br>
                    <div class="form-field align-items-center">
                        <span class="fa fa-key"></span>
                        <input type="password" name="txtPassword" id="txtPassword" placeholder="Enter New Password" autocomplete="off" />
                    </div>
                    <br>
                    <div class="form-field align-items-center">
                        <span class="fa fa-key"></span>
                        <input type="password" name="txtConfirmPassword" id="txtConfirmPassword" placeholder="Confirm Password" autocomplete="off" />
                    </div>
                    <br>
                    <button style="width:100%; margin-top:10px" id="btnSubmit" class="btn btn-dark">Submit <i class="fa fa-paper-plane fa-lg"></i></button>
                </div>
            </div>
		</div>
        <br>
	</div>
	<?php jsLink(); ?>
    <script src="user_js/signup.js"></script>
</body>
</html>