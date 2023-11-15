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
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
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
            </div>
        </div>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-warning">
                <b>
                    <ul>
                        <li style="color: #4d3701;">Please enter correct data it will help both of us.</li>
                        <li style="color: #4d3701;">All star marked fields are required.</li>
                    </ul>
                </b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="selCity">City/Town :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="selArea">Area :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <select class="form-control" id="selArea" name="selArea" placeholder="Select Area"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtName">Name :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="txtName" id="txtName" placeholder="Enter Name" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtContactNo">Contact Number :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="txtContactNo" id="txtContactNo" placeholder="Enter Contact No." autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtDetailedAddress">Address :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea type="text" class="form-control" name="txtDetailedAddress" id="txtDetailedAddress" placeholder="Enter Detailed Address" autocomplete="off" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtCaptcha">Captcha :&nbsp;<span>*</span></label>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
					<input type="text" class="form-control" name="txtCaptcha" id="txtCaptcha" placeholder="Enter Captcha" autocomplete="off"/>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <img src="../asset/captcha" alt="Captcha">
                </div>
            </div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button style="width:100%; margin-top:10px" id="btnSTO" class="btn btn-dark">Submit <i class="fa fa-arrow-circle-right fa-lg"></i></button>
            </div>
		</div>
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <marquee direction="left">
                    <b>
                        <span class="text-white">
                        For any help! Please contact on our respective city help line number. 
                        </span>
                    </b>
                </marquee>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <div class="card bg-white">
                    <div class="card-body">
                        <b>
                        <span>Please support us on:</span>
                        <br>
                        <span><img src="../asset/img/InstagramLogo.png" alt="InstagramLogo" width="15" height="15"></span>
                        <span>kabadi_dukan</span>
                        <span><img src="../asset/img/FacebookLogo.png" alt="FacebookLogo" width="15" height="15"></span>
                        <span>Kabadi Dukan</span>
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
	<?php jsLink(); ?>
    <script src="user_js/booking_take_off.js"></script>
</body>
</html>