 
        <br>
        <input type="hidden" id="logOut" value=<?php echo URL_USER."SignOut" ?>>
        <div class="row">
			<div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="action-btn btn btn-warning btn-md pull-left" id="navBar" onclick="openNav()"><i class="fa fa-bars"></i></button>
                <span class="btn-xs btn btn-warning" style="font-size: 16px; border-radius: 15%;">
                    <b>Hi <?php echo $_SESSION['user_name']?> <i class="fa fa-user fa-lg"></i></b>
                </span>
                <button class="action-btn btn btn-warning btn-md pull-right" onclick="logOut()"><i  class="fa fa-power-off"></i></button>
            </div>
		</div>
        <br>
        <div id="mySidepanel" class="sidepanel">
            <a href=<?php echo URL_USER."Dashboard" ?>><i class="fa fa-caret-right"></i> User's Dashboard</a>
        <?php
            if($_SESSION['user_type'] == "ADMIN"){
        ?>
            <a href=<?php echo URL_ADMIN."Dashboard" ?>><i class="fa fa-caret-right"></i> Admin's Dashboard</a>
        <?php
            }
            if($_SESSION['user_type'] == "EMPLOYEE" || $_SESSION['user_type'] == "ADMIN"){
        ?>
            <a href=<?php echo URL_EMPLOYEE."Dashboard" ?>><i class="fa fa-caret-right"></i> Employee's Dashboard</a>
        <?php
            }
            if($_SESSION['user_type'] == "MANAGER" || $_SESSION['user_type'] == "ADMIN"){
        ?>
            <a href=<?php echo URL_MANAER."Dashboard" ?>><i class="fa fa-caret-right"></i> Manager's Dashboard</a>
        <?php
            }
        ?>
        </div>

        <script>
            function openNav() {
                let x = document.getElementById("mySidepanel");
                if (x.style.width === "100%") {
                    $('#navBar').html('<i class="fa fa-bars"></i>');
                    x.style.width = "0";
                } else {
                    $('#navBar').html('<i class="fa fa-times"></i>');
                    x.style.width = "100%";
                }
            }
            function logOut() {
                let text = 'Are you sure? want to logout.'
                if (confirm(text) == true) {
                    window.open($('#logOut').val(), "_self");
                }
            }
        </script>