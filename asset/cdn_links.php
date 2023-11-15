<?php
require_once("../config.php");
//All css cdn links
function cssLink()
{
?>
    <!-- Bootstrap -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/bootstrap.min.css" ?>>
    <!-- Toastr -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/toastr.min.css" ?>>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/font_awesome/css/font-awesome.min.css" ?>>
    <!-- Data table -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/jquery.dataTables.min.css" ?>>
    <!-- Date Picker -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/datepicker.min.css" ?>>
    <!-- Boostrap Modal -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/modal.bootstrap.min.css" ?>>
    <!-- Swal2 -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/sweetalert2.min.css" ?>>
    <!-- Selectize -->
    <link rel="stylesheet" href=<?php echo URL_ASSET."css/selectize.bootstrap5.min.css" ?>>

<?php
}

//All css cdn links
function jsLink()
{
?>
    <!-- Jquery -->
    <script src=<?php echo URL_ASSET."js/jquery.min.js" ?>></script>
    <!-- Bootstrap -->
    <script src=<?php echo URL_ASSET."js/bootstrap.min.js" ?>></script>
    <!-- Toastr -->
    <script src=<?php echo URL_ASSET."js/toastr.min.js" ?>></script>
    <!-- Form Validator -->
    <script src=<?php echo URL_ASSET."js/bootstrapValidator.min.js" ?>> </script>
    <!-- Date Picker-->
    <script src=<?php echo URL_ASSET."js/datepicker.min.js" ?>> </script>
    <!-- Data table -->
    <script src=<?php echo URL_ASSET."js/jquery.dataTables.min.js" ?>></script>
    <!-- Encryption -->
    <script src=<?php echo URL_ASSET."js/crypto.min.js" ?>></script>
    <script src=<?php echo URL_ASSET."js/NormalEncrptionDecryption.js" ?>></script>
    <!-- Data table buttons -->
    <script src=<?php echo URL_ASSET."js/dataTables.buttons.min.js" ?>></script>
    <script src=<?php echo URL_ASSET."js/buttons.flash.min.js" ?>></script>
    <script src= <?php echo URL_ASSET."js/pdfmake.min.js" ?>></script>
    <script src= <?php echo URL_ASSET."js/vfs_fonts.js" ?>></script>
    <script src=<?php echo URL_ASSET."js/buttons.html5.min.js" ?>></script>
    <script src=<?php echo URL_ASSET."js/buttons.print.min.js" ?>></script>
    <!-- Swal2 -->
    <script src=<?php echo URL_ASSET."js/sweetalert2.min.js" ?>></script>
    <!-- Selectize -->
    <script src=<?php echo URL_ASSET."js/selectize.min.js" ?>></script>
<?php
}
?>