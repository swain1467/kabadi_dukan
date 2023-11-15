<?php
require_once("../config.php");
require_once(ASSET . "cdn_links.php");
require_once(ASSET."check_login.php");
session_start();
checkLogIn();
if($_SESSION['user_type'] != "ADMIN" && $_SESSION['user_type'] != "EMPLOYEE"){
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
        <br>
        <div class="row">
            <div class="form-group">
                <label class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right" for="txtTakeOffDate">Take Off Date:</label>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <input type="text" class="form-control" name="`txtTakeOffDate`" id="txtTakeOffDate" placeholder="Pick Date" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <select class="form-control" id="selBookingId" name="selBookingId" placeholder="Select Booking Id"></select>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped table-bordered" id="dtbleUserItems">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">Item</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total: </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- User Item Modal -->
        <div id="modalUserItem" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                            <h5 class="modal-title" id="modalUserItemHeader"></h5>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="frmUserItem">
                            <input type="hidden" class="form-control" name="txtUserItemId" id="txtUserItemId" autocomplete="off"/>
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selItem">Item :&nbsp;<span class="required">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select class="form-control" id="selItem" name="selItem" placeholder="Select Item"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtQuantity">Quantity :&nbsp;<span class="required">*</span></label>
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                    <input type="text" class="form-control" name="txtQuantity" id="txtQuantity" placeholder="Enter Quantity" autocomplete="off"/>
                                </div>
                                <span class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Kg/Piece</span>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtPrice">Price :&nbsp;<span class="required">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" class="form-control" name="txtPrice" id="txtPrice" placeholder="Enter Price" autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info btn-sm" id="btnSaveUI"><i class="fa fa-save"></i>&nbsp;Save</button>
                        <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<?php jsLink(); ?>
    <script src="emp_js/update_booking.js"></script>
</body>
</html>