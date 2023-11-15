$(document).ready(function () {
    LoadCitySelectize();
    $("#selCity").change(function () {
        LoadAreaSelectize();
    });

    $("#btnSTO").click(function () {
        $("#btnSTO").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Please wait...');
        $("#btnSTO").attr('disabled', true);

        let city = $("#selCity").val();
        let area = $("#selArea").val();
        let contact_no = $("#txtContactNo").val();
        let name = $("#txtName").val();
        let detailed_address = $("#txtDetailedAddress").val();
        let captcha = $("#txtCaptcha").val();
        $.ajax({
            url: "../api/UserHome?action=BookingTakeOff",
            type: "POST",
            data: {
                city: city, area: area, name: name, contact_no: contact_no,
                detailed_address: detailed_address, captcha: captcha
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    alert(res.message);
                    $("#btnSTO").html('Submit &nbsp;<i class="fa fa-arrow-circle-right"></i>');
                    $("#btnSTO").removeAttr('disabled');
                    setTimeout(window.open("BookingHistory", "_self"), 3000);
                } else if (res.status == 'Error') {
                    $("#btnSTO").html('Submit &nbsp;<i class="fa fa-arrow-circle-right"></i>');
                    $("#btnSTO").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSTO").html('Submit &nbsp;<i class="fa fa-arrow-circle-right"></i>');
                    $("#btnSTO").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});

function LoadCitySelectize() {
    $.ajax({
        url: "../api/UserHome?action=GetCity",
        type: "GET",
        success: function (response) {
            var $select = $('#selCity').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                selectize.addOption({ value: data.city_id, text: data.city_name });
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadAreaSelectize() {
    let city_id = $("#selCity").val();
    $.ajax({
        "url": "../api/UserHome?action=GetAreaList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var $select = $('#selArea').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                if (data.status != 0) {
                    selectize.addOption({ value: data.id, text: data.area_name });
                }
            });
        },
        error: function () {
            toastr.error('Unable to Area selectize');
        }
    });
}