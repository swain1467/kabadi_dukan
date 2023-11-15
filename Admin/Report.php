<?php
require_once("../config.php");
require_once(ASSET . "cdn_links.php");
require_once(ASSET."check_login.php");
session_start();
checkLogIn();
if($_SESSION['user_type'] != "ADMIN"){
	header('location:'.URL_USER.'AccessDenied');
    exit();
}
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
    <link href=<?php echo URL_ASSET."css/custom/admin_nav_style.css"; ?> rel="stylesheet">
    <link href=<?php echo URL_ASSET."css/custom/admin_dashboard_style.css"; ?> rel="stylesheet">
</head>
<body>
	<div class="container">
        <br>
		<?php include_once("../User/UserHeader.php")?> 
		<?php include_once("AdminNav.php")?> 
        <br>
        <div class="row">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tabCity" data-toggle="tab">City</a></li>
					<li><a href="#tabArea" data-toggle="tab">Area</a></li>
				</ul>
            </div>
			<div class="tab-content">
                <!--City Tab-1 Start-->
				<div class="tab-pane active" id="tabCity">
                    <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<span class="btn-sm btn btn-primary">
								<b>City Wise Collection Report</b>
							</span>
						</div>
                    </div>
					<br>
                    <div class="row">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtCityFD">Take Off From Date :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtCityFD" id="txtCityFD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtCityTD">Take Off To Date :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtCityTD" id="txtCityTD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8">
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-4">
                            <button id="btnCityReportSearch" class='btn btn-success'><i class='fa fa-search'></i></button>
                        </div>
                    </div>
					<br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblCity">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Contact Person</th>
                                        <th class="text-center">Commission (%)</th>
                                        <th class="text-center">Total Orders</th>
                                        <th class="text-center">Total Collection</th>
                                        <th class="text-center">Commission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total: </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--City Tab-1 End-->
                <!--Area Tab-2 Start-->
				<div class="tab-pane" id="tabArea">
                    <div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<span class="btn-sm btn btn-primary">
								<b>Area Wise Collection Report</b>
							</span>
						</div>
                    </div>
					<br>
                    <div class="row">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtAreaFD">Take Off From Date :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtAreaFD" id="txtAreaFD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtAreaTD">Take Off To Date :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtAreaTD" id="txtAreaTD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <label class="col-lg-1 col-md-1 col-sm-1 col-xs-4 text-right" for="selACity">City :&nbsp;</label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <select class="form-control" id="selACity" name="selACity" placeholder="Select City/Town"></select>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                            <button id="btnAreaReportSearch" class='btn btn-success'><i class='fa fa-search'></i></button>
                        </div>
                    </div>
					<br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblArea">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Commission (%)</th>
                                        <th class="text-center">Total Orders</th>
                                        <th class="text-center">Total Collection</th>
                                        <th class="text-center">Commission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total: </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--Area Tab-2 End-->
            </div>
        </div>
	</div>
	<?php jsLink(); ?>
    <script src="admin_js/report.js"></script>
</body>
</html>