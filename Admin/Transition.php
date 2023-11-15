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
					<li class="active"><a href="#tabBookingDetails" data-toggle="tab">Booking Details</a></li>
					<!-- <li><a href="#tabArchive" data-toggle="tab">Archive</a></li> -->
				</ul>
            </div>
			<div class="tab-content">
                <!--Booking Details Tab-1 Start-->
				<div class="tab-pane active" id="tabBookingDetails"><br>
                    <div class="row">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="selBDCity">City/Town :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <select class="form-control" id="selBDCity" name="selBDCity" placeholder="Select City/Town"></select>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="selBDArea">Area :&nbsp;</label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <select class="form-control" id="selBDArea" name="selBDArea" placeholder="Select Area"></select>
                        </div>
                    </div>
					<br>
                    <div class="row">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtBDBD">Booking Date :&nbsp;</label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtBDBD" id="txtBDBD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="txtBDTOD">Take Off Date :&nbsp;</label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<input type="text" class="form-control" name="txtBDTOD" id="txtBDTOD" placeholder="Pick Date" autocomplete="off"/>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right" for="selBDStatus">Status :&nbsp;</label>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
							<select class="form-control" id="selBDStatus" name="selBDStatus" placeholder="Select Status">
								<option value="">Select Status</option>
								<option value="1">Active</option>
								<option value="0">Archive</option>
							</select>
                        </div>
                    </div>
					<br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblBD">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Booking Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Contact No.</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Booking On</th>
                                        <th class="text-center">Take Off On</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Signature</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalActive" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalActiveHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmActive">
											<input type="hidden" class="form-control" name="txtActiveId" id="txtActiveId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveCode">Booking Id :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" name="txtActiveCode" id="txtActiveCode" autocomplete="off"/>
												</div>
											</div><div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveBD">Booking On :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" name="txtActiveBD" id="txtActiveBD" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveTOD">Take Off On :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" name="txtActiveTOD" id="txtActiveTOD" placeholder="Pick Date" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveScrapPrice">Price :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" name="txtActiveScrapPrice" id="txtActiveScrapPrice" placeholder="Enter Price" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selActiveArea">Area :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<select class="form-control" id="selActiveArea" name="selActiveArea" placeholder="Select Area"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveContactNo">Contact No. :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<input type="text" class="form-control" name="txtActiveContactNo" id="txtActiveContactNo" placeholder="Enter Contact No." autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtActiveAddress">Address :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<textarea type="text" class="form-control" name="txtActiveAddress" id="txtActiveAddress" placeholder="Enter Detailed Address" autocomplete="off" rows="3"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtActiveStatus">Status :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtActiveActive" name="txtActiveStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtActiveInactive" name="txtActiveStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveActive"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--Booking Details Tab-1 End-->
            </div>
        </div>
	</div>
	<?php jsLink(); ?>
    <script src="admin_js/transition.js"></script>
</body>
</html>