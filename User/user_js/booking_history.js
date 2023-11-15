$(document).ready(function () {
    $('#DivBookingDetails').hide();
});
function showBookingHistory() {
    $("#btnSearch").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Please Wait...');
    $("#btnSearch").attr('disabled', true);

    let booking_id = $("#txtBookingId").val();
    $("#hidBookingId").val(booking_id);

    $.ajax({
        url: "../api/UserHome?action=GetBookingHistory",
        type: "POST",
        data: { booking_id: booking_id },
        success: function (response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 'Success') {
                $.each(res.aaData, function (i, data) {
                    $("#txtCity").html(data.city_name);
                    $("#txtArea").html(data.area_name);
                    $("#txtAddress").html(data.detailed_address);
                    $("#txtName").html(data.name);
                    $("#txtBookingDate").html(data.booking_on);
                    $("#txtTakeOffDate").html(data.take_off_on);
                    $("#txtScarpValue").val(data.scrap_price);
                    $('#DivBookingDetails').show(1000);
                    $("#btnSearch").html('Submit &nbsp;<i class="fa fa-search"></i>');
                    $("#btnSearch").removeAttr('disabled');
                    if (data.take_off_on) {
                        $('#btnUpdate').show();
                        $('#btnDelete').hide();
                    } else {
                        $('#btnUpdate').hide();
                        $('#btnDelete').show();
                    }
                    if (data.scrap_price) {
                        $('#btnUpdate').hide();
                    }
                });
            } else if (res.status == 'Error') {
                $('#DivBookingDetails').hide();
                $("#btnSearch").html('Submit &nbsp;<i class="fa fa-search"></i>');
                $("#btnSearch").removeAttr('disabled');
                toastr.warning(res.message);
            } else {
                $('#DivBookingDetails').hide();
                $("#btnSearch").html('Submit &nbsp;<i class="fa fa-search"></i>');
                $("#btnSearch").removeAttr('disabled');
                toastr.error('Sorry Invalid Booking Id');
            }
        },
        error: function (response) {
            toastr.error('Sorry! Something Went Wrong!!!');
        }
    });
}
function DeleteBookingHistory() {
    let booking_id = $("#hidBookingId").val();
    swal({
        title: 'Are you sure to delete ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "../api/UserHome?action=DeleteBookingHistory",
            type: "POST",
            data: { booking_id: booking_id },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $('#DivBookingDetails').hide();
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function () {
                toastr.error('Unable to process please contact support');
            }
        });
    }, function (dismiss) { }).done();
}
function UpdateBookingHistory() {
    let booking_id = $("#hidBookingId").val();
    let scrap_price = $("#txtScarpValue").val();
    swal({
        title: 'Are you sure to update ?',
        text: "The Scrap Value Is " + scrap_price,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "../api/UserHome?action=UpdateBookingHistory",
            type: "POST",
            data: { booking_id: booking_id, scrap_price: scrap_price },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    showBookingHistory();
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function () {
                toastr.error('Unable to process please contact support');
            }
        });
    }, function (dismiss) { }).done();
}