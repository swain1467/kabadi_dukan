<?php
require_once("../config.php");
require_once(ASSET . "cdn_links.php");
require_once(ASSET . "db_core.php");

$data = ['status' => 1];
$selectQuery = "SELECT A.id, A.city_name, B.contact_no  
                FROM admin_city_master A
                LEFT JOIN user_master B ON A.contact_person = B.id AND A.status = B.status 
                WHERE A.status =:status
                ORDER BY city_name";
$result = DBCore::executeQuery($selectQuery,$data);
$all_city = DBCore::getAllRows($result);
$city_count = COUNT($all_city);
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
    <script src="user_js/home.js"></script>
</head>
<body>
	<div class="container"> 
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="../Video.mp4">
                    <img src="../asset/img/Banner1.png" alt="Banner1" width="100%">
                </a>
            </div>
		</div> 
        <br>
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button style="width:100%;" id="btnBTO" class="btn btn-dark">Book One Take Off <i class="fa fa-shopping-cart fa-lg"></i></button>
                <button style="width:100%; margin-top:10px" id="btnBH" class="btn btn-default">Booking History <i class="fa fa-search fa-lg"></i></button>
            </div>
		</div>
        <br>
        <div class="bg-white col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4 style="color:dark; font-weight:bold; margin-left:1%;">Please click on your city/town to see scrap value in your city:</h4>
                </div>
                <?php for($i=0; $i < $city_count; $i++){?>
                <div style="margin-top: 5px; color:white; font-weight:bold;" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div onclick = "showItemPrice(<?php echo $all_city[$i]['id']; ?>)" class="card bg-dark">
                        <div class="text-lef">
                            <span style="color: #fff;"><i class="fa fa-whatsapp fa-lg"></i></span>
                            <span class = "nav-item"><?php echo $all_city[$i]["contact_no"]; ?></span>
                                &ensp;&ensp;&ensp;
                            <span><i class="fa fa-map-marker fa-lg bg-dark"></i></span>
                            <span class = "nav-item"><?php echo $all_city[$i]["city_name"]; ?></span>
                            <span><img src="../asset/img/ClickHere.gif" alt="ClickHere" width="25" height="25"></span>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <br>
            <div id="divItemPrice" class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table table-striped table-bordered" id="dtblItemPrice">
                        <thead class="bg-white">
                            <tr>
                                <th class="text-center">Sl.No</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Price</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button onclick="hideItemPrice()" style="width:100%; margin-top:10px" class="btn btn-danger">Hide <i class="fa fa-eye-slash fa-lg"></i></button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="logo">
                        <a href="SignIn">
                            <img src="../asset/img/Logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <span><i class="fa fa-whatsapp fa-sm"></i></span>
                            <span><i class="fa fa-phone fa-sm"></i></span>
                            <span>8917490734</span>
                            <span>/</span>
                            <span>8280885099</span>
                            <br>
                            <span><i class="fa fa-envelope fa-sm"></i></span>
                            <span>kabadidukanofficial@gmail.com</span>
                            <br>
                            <span><img src="../asset/img/InstagramLogo.png" alt="InstagramLogo" width="15" height="15"></span>
                            <span>kabadi_dukan</span>
                            <span><img src="../asset/img/FacebookLogo.png" alt="FacebookLogo" width="15" height="15"></span>
                            <span>Kabadi Dukan</span>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</body>
</html>