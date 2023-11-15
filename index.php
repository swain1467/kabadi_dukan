<?php
// phpinfo();
// echo'HI'; die;
require_once("config.php");
require_once(ASSET."check_login.php");
session_start();
checkLogIn();
checkSession();
?>
