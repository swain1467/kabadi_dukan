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
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-black">
					<a href="UserList" target="_self">
						<i class = "fa fa-users"></i><br>
						<span class = "nav-item">Users List</span>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-danger">
					<a href="PECMapping" target="_self">
						<i class = "fa fa-users"></i><br>
						<span class = "nav-item">Emp & Manager's List</span>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-warning">
					<a href="Setup" target="_self">
						<i class = "fa fa-cog"></i><br>
						<span class = "nav-item">Setup</span>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-success">
					<a href="Transition" target="_self">
						<i class = "fa fa-tasks"></i><br>
						<span class = "nav-item">Transition</span>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-primary">
					<a href="Report" target="_self">
						<i class = "fa fa-file"></i><br>
						<span class = "nav-item">Report</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php jsLink(); ?>
    <script src="admin_js/dashboard.js"></script>
</body>
</html>