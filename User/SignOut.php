<?php 
require_once("../config.php");
require_once(ASSET . "check_login.php");
session_start();
session_destroy();
header('location:'.URL_USER.'Home');
?>