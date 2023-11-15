<?php
require_once("../config.php");
require_once(ASSET . "cdn_links.php");
require_once(ASSET."check_login.php");
require_once(ASSET . "db_core.php");

session_start();
checkLogIn();

$data = ['status' => 1];
$selectQuery = "SELECT name, contact_no, user_type 
                FROM user_master
                WHERE status =:status AND user_type NOT IN ('EMPLOYEE', 'USER')
                ORDER BY user_type DESC";
$result = DBCore::executeQuery($selectQuery,$data);
$all_staff = DBCore::getAllRows($result);
$staff_count = COUNT($all_staff);
// echo'<pre>';
// print_r($all_staff);
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
    <link href=<?php echo URL_ASSET."css/custom/admin_dashboard_style.css"; ?> rel="stylesheet">
</head>
<body>
	<div class="container">
		<?php include_once("UserHeader.php")?>
        <br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <td class="text-center">Name</td>
                            <td class="text-center">Contact No</td>
                            <td class="text-center">User Type</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        for($i = 0; $i<$staff_count; $i++){?>
                        <tr class = "">
                            <td class="text-left"><?php echo $all_staff[$i]['name'] ?></td>
                            <td class="text-center"><?php echo $all_staff[$i]['contact_no'] ?></td>
                            <td class="text-left"><?php echo ucfirst(strtolower($all_staff[$i]['user_type'])) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
		</div>
        <br>
	</div>
	<?php jsLink(); ?>
    <script src="user_js/dashboard.js"></script>
</body>
</html>