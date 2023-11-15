$(document).ready(function () {
    $("#btnSignUp").click(function () {
        window.open('SignUp', '_self');
    });
    $("#btnRP").click(function () {
        window.open('RP', '_self');
    });
    // Submit button on click
    $("#btnSubmit").click(function () {
        $("#btnSubmit").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Please Wait...');
        $("#btnSubmit").attr('disabled', true);

        let email = $("#txtEmail").val();
        let password = $("#txtPassword").val();
        let captcha = $("#txtCaptcha").val();

        $.ajax({
            url: "../api/UserSignIn?action=VerifyUser",
            type: "POST",
            data: { email: email, password: password, captcha: captcha },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    alert(res.message);
                    $("#txtEmail").val('');
                    $("#txtPassword").val('');
                    $("#txtCaptcha").val('');

                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-arrow-circle-right fa-lg"></i>');
                    $("#btnSubmit").removeAttr('disabled');
                    window.open("Dashboard", "_self");
                } else if (res.status == 'Error') {
                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-arrow-circle-right fa-lg"></i>');
                    $("#btnSubmit").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-arrow-circle-right fa-lg"></i>');
                    $("#btnSubmit").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});