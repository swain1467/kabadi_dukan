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
					<li class="active"><a href="#tabItem" data-toggle="tab">Item</a></li>
					<li><a href="#tabCity" data-toggle="tab">City/Town</a></li>
					<li><a href="#tabCTIM" data-toggle="tab">City To Item Map</a></li>
					<li><a href="#tabArea" data-toggle="tab">Area</a></li>
				</ul>
            </div>
			<div class="tab-content">
                <!--Item Tab-1 Start-->
				<div class="tab-pane active" id="tabItem"><br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblItem">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">Item Name</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalItem" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalItemHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmItem">
											<input type="hidden" class="form-control" name="txtItemId" id="txtItemId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtItemName">Item Name :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtItemName" id="txtItemName" placeholder="Enter Item Name" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtItemStatus">Status :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtItemActive" name="txtItemStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtItemInactive" name="txtItemStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveItem"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--Item Tab-1 End-->
                <!--City Tab-2 Start-->
				<div class="tab-pane" id="tabCity"><br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblCity">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Commission (%)</th>
                                        <th class="text-center">Contact Person</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalCity" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalCityHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmCity">
											<input type="hidden" class="form-control" name="txtCityId" id="txtCityId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCityName">City/Town :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtCityName" id="txtCityName" placeholder="Enter City/Town" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCityCommission">Commission :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtCityCommission" id="txtCityCommission" placeholder="Ex:- 10" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selCityCP">Contact Person :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<select class="form-control" id="selCityCP" name="selCityCP" placeholder="Select Contact Person"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCityStatus">Status :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtCityActive" name="txtCityStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtCityInactive" name="txtCityStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveCity"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--City Tab-2 End-->
                <!--CTIM Tab-3 Start-->
				<div class="tab-pane" id="tabCTIM"><br>
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right" for="selCTIMCity">City/Town :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <select class="form-control" id="selCTIMCity" name="selCTIMCity" placeholder="Select City/Town"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblCTIM">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Item</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalCTIM" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalCTIMHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmCTIM">
											<input type="hidden" class="form-control" name="txtCTIMId" id="txtCTIMId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selCTIMItem">Item :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<select class="form-control" id="selCTIMItem" name="selCTIMItem" placeholder="Select Item"></select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCTIMUnit">Unit :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtCTIMUnit" id="txtCTIMUnit" placeholder="Enter Unit" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCTIMPricing">Pricing :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtCTIMPricing" id="txtCTIMPricing" placeholder="Enter Pricing" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCTIMStatus">Status :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtCTIMActive" name="txtCTIMStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtCTIMInactive" name="txtCTIMStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveCTIM"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--CTIM Tab-3 End-->
                <!--Area Tab-4 Start-->
				<div class="tab-pane" id="tabArea"><br>
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right" for="selAreaCity">City/Town :&nbsp;<span class="required">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <select class="form-control" id="selAreaCity" name="selAreaCity" placeholder="Select City/Town"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblArea">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalArea" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalAreaHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmArea">
											<input type="hidden" class="form-control" name="txtAreaId" id="txtAreaId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtAreaName">Area :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtAreaName" id="txtAreaName" placeholder="Enter Area Name" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtAreaStatus">Status :&nbsp;<span class="required">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtAreaActive" name="txtAreaStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtAreaInactive" name="txtAreaStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveArea"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--Area Tab-4 End-->
            </div>
        </div>
	</div>
	<?php jsLink(); ?>
    <script src="admin_js/setup.js"></script>
</body>
</html>