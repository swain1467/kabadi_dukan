$(document).ready(function () {
    let dtblUserList = $('#dtblUserList').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "../api/AdminUserList?action=GetUsersList",
            "type": "GET"
        },
        bStateSave: false,
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5 col-xs-5'><'col-lg-3 col-md-3 col-sm-3 col-xs-3' l><'col-lg-4 col-md-4 col-sm-4 col-xs-4' f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9 col-xs-9'i><'col-lg-3 col-md-3 col-sm-3 col-xs-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'name', "name": "name", "sWidth": "25%" },
            { "data": 'contact_no', "name": "contact_no", "sWidth": "15%", "className": "text-center" },
            { "data": 'mail_address', "name": "mail_address", "sWidth": "25%" },
            { "data": 'user_type', "name": "user_type", "sWidth": "10%", "className": "text-center" },
            {
                "data": 'status', "name": "status", "sWidth": "5%", "className": "text-center",
                mRender: function (data, type, val) {
                    if (val.status == 1) {
                        return `<i class='fa fa-check' style='color:green; font-weight:bolder'></i>`;
                    }
                    else {
                        return `<i class='fa fa-times' style='color:red; font-weight:bolder'></i>`;
                    }
                }
            },
            {
                "data": null, "name": "action", "sWidth": "10%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateUserDetails(event)'><i class='fa fa-edit'></i></button>`
            }
        ]
    });

    $("#btnUpdateUserDetails").click(function () {
        $("#btnUpdateUserDetails").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnUpdateUserDetails").attr('disabled', true);

        let id = $("#txtUserId").val();
        let name = $("#txtName").val();
        let contact_no = $("#txtContactNo").val();
        let email = $("#txtEmail").val();
        let user_type = $("#selUserType").val();
        let user_status = 0
        if ($("#txtActive").prop("checked")) {
            user_status = 1
        }
        $.ajax({
            url: "../api/AdminUserList?action=UpdateUserDetails",
            type: "POST",
            data: {
                id: id, name: name, contact_no: contact_no, email: email, user_type: user_type, user_status: user_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    dtblUserList.ajax.reload();
                    toastr.success(res.message);
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    $('#modaUserDetails').modal('hide');
                } else if (res.status == 'Error') {
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});
function UpdateUserDetails(event) {
    var dtblUserList = $('#dtblUserList').dataTable();
    $(dtblUserList.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modaUserDetailsHeader").html('Update User Details');
    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnUpdateUserDetails").removeAttr('disabled');

    $("#txtUserId").val(dtblUserList.fnGetData(row)['id']);
    $("#txtName").val(dtblUserList.fnGetData(row)['name']);
    $("#txtContactNo").val(dtblUserList.fnGetData(row)['contact_no']);
    $("#txtEmail").val(dtblUserList.fnGetData(row)['mail_address']);
    $("#selUserType").val(dtblUserList.fnGetData(row)['user_type']);
    if (dtblUserList.fnGetData(row)['status'] == 1) {
        $("#txtActive").prop("checked", true);
    } else {
        $("#txtInactive").prop("checked", true);
    }
    $('#modaUserDetails').modal('show');
}