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
	<?php jsLink(); ?>
    <script src="user_js/booking_history.js"></script>
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
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <b>
                    <ul>
                        <li style="color: #4d3701;">You had got a booking id during booking take off.</li>
                    </ul>
                </b>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtBookingId">Booking Id :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="txtBookingId" id="txtBookingId" placeholder="Please Enter Booking Id" autocomplete="off"/>
					<input type="hidden" class="form-control" name="hidBookingId" id="hidBookingId" placeholder="Please Enter Booking Id" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button id="btnSearch" class="btn btn-dark btn-sm" onclick="showBookingHistory()">Search <i class="fa fa-search fa-lg"></i></button>
                </div>
            </div>
		</div>
        <br>
        <div id="DivBookingDetails" class="row">
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">City/Town :&nbsp;<label id="txtCity"></label></span>
            </div>
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">Area :&nbsp;<label id="txtArea"></label></span>
            </div>
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">Address :&nbsp;<label id="txtAddress"></label></span>
            </div>
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">Name :&nbsp;<label id="txtName"></label></span>
            </div>
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">Booking Date :&nbsp;<label id="txtBookingDate"></label></span>
            </div>
            <div class="form-group">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required">Take Off Date :&nbsp;<label id="txtTakeOffDate"></label></span>
            </div>
            <div class="form-group">
                <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 required" for="txtScarpValue">Scrap Value :&nbsp;<span>*</span></label>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<input type="text" class="form-control" name="txtScarpValue" id="txtScarpValue" placeholder="Please enter the amount given to you" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <button id="btnUpdate" class="btn btn-warning btn-sm" onclick="UpdateBookingHistory()">Update <i class="fa fa-edit fa-lg"></i></button>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <button id="btnDelete" class="btn btn-danger btn-sm" onclick="DeleteBookingHistory()">Delete <i class="fa fa-trash fa-lg"></i></button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <marquee direction="left">
                    <b>
                        <span style="color: #4d3701;">
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
</body>
</html>