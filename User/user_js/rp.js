$(document).ready(function () {
    $("#btnSignIp").click(function () {
        window.open('SignIn', '_self');
    });
    $("#MailDiv").show();
    $("#OTP").hide();
    // Send OTP button on click
    $("#btnSendOTP").click(function () {
        $("#btnSendOTP").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Please Wait...');
        $("#btnSendOTP").attr('disabled', true);
        let email = $("#txtEmail").val();
        let captcha = $("#txtCaptcha").val();
        $.ajax({
            url: "../api/UserRP?action=SendOTP",
            type: "POST",
            data: { email: email, captcha: captcha },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSendOTP").html('Send OTP&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
                    $("#btnSendOTP").removeAttr('disabled');
                    $("#MailDiv").hide();
                    $("#OTP").show(1000);
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSendOTP").html('Send OTP&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
                    $("#btnSendOTP").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSendOTP").html('Send OTP&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
                    $("#btnSendOTP").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });

    // Final Submit on click
    $("#btnSubmit").click(function () {
        $("#btnSubmit").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Please Wait...');
        $("#btnSubmit").attr('disabled', true);

        let otp = $("#txtOTP").val();
        let password = $("#txtPassword").val();
        let confirm_password = $("#txtConfirmPassword").val();
        let email = $("#txtEmail").val();

        $.ajax({
            url: "../api/UserRP?action=UpdatePassword",
            type: "POST",
            data: { otp: otp, password: password, confirm_password: confirm_password, email: email },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    alert(res.message);
                    $("#txtOTP").val('');
                    $("#txtPassword").val('');
                    $("#txtConfirmPassword").val('');
                    $("#txtEmail").val('');

                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
                    $("#btnSubmit").removeAttr('disabled');
                    setTimeout(window.open("SignIn", "_self"), 3000);
                } else if (res.status == 'Error') {
                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
                    $("#btnSubmit").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSubmit").html('Submit&nbsp;<i class="fa fa-paper-plane fa-lg"></i>');
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