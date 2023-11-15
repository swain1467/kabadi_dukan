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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped table-bordered" id="dtblPEC">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">Sl. No</th>
                            <th class="text-center">Emp & Partner</th>
                            <th class="text-center">Contact No</th>
                            <th class="text-center">Mail Address</th>
                            <th class="text-center">City</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
			</div>
            <!-- Modal -->
            <div id="modalPEC" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                <h5 class="modal-title" id="modalPECHeader"></h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" id="frmPEC">
                                <input type="hidden" class="form-control" name="txtPECId" id="txtPECId" autocomplete="off"/>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selPECPerson">Emp Or Partner :&nbsp;<span class="required">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select class="form-control" id="selPECPerson" name="selPECPerson" placeholder="Select Person"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selPECCity">City :&nbsp;<span class="required">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select class="form-control" id="selPECCity" name="selPECCity" placeholder="Select City"></select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info btn-sm" id="btnSavePEC"><i class="fa fa-save"></i>&nbsp;Save</button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
		</div>
	</div>
	<?php jsLink(); ?>
    <script src="admin_js/pec_mapping.js"></script>
</body>
</html>