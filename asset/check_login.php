<?php 
function checkLogIn(){
    if(!isset($_SESSION['id']))
    {
        header('location:'.URL_USER.'Home');
        exit();
    }
}

function checkSession(){
    if(isset($_SESSION['id']))
    {
        header('location:'.URL_USER.'Dashboard');
        exit();
    }
}
?>