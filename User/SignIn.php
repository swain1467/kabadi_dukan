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
                <div class="form-field align-items-center">
                    <span class="fa fa-envelope"></span>
                    <input type="text" name="txtEmail" id="txtEmail" placeholder="Enter Email Address" autocomplete="off" />
                </div>
                <br>
                <div class="form-field align-items-center">
                    <span class="fa fa-key"></span>
                    <input type="password" name="txtPassword" id="txtPassword" placeholder="Enter Password" autocomplete="off" />
                </div>
                <br>
                <div class="form-field align-items-center">
                    <span class="fa fa-refresh"></span>
                    <input type="text" name="txtCaptcha" id="txtCaptcha" placeholder="Enter Captcha" autocomplete="off" />
                    <img src="../asset/captcha" alt="Captcha">
                </div>
                <br>
                <button style="width:100%; margin-top:10px" id="btnSubmit" class="btn btn-dark">Submit <i class="fa fa-arrow-circle-right fa-lg"></i></button>
                <br>
                <button style="width:100%; margin-top:10px" id="btnSignUp" class="btn btn-warning">Sign Up <i class="fa fa-paper-plane fa-lg"></i></button>
                <br>
                <button style="width:100%; margin-top:10px" id="btnRP" class="btn btn-default">Recover Password <i class="fa fa-lock fa-lg"></i></button>
            </div>
		</div>
        <br>
	</div>
	<?php jsLink(); ?>
    <script src="user_js/signin.js"></script>
</body>
</html>