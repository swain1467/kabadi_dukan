<?php
session_start();
if(!isset($_SESSION['id']))
{
    $output['status'] = 'Access denied';
    $output['message'] = 'Unauthorized access, you have to log in';
    echo json_encode($output);
    exit();
}
?>