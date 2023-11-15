$(document).ready(function () {
    LoadPersonSelectize();
    LoadCitySelectize('#selPECCity');

    let dtblPEC = $('#dtblPEC').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "../api/AdminPECMapping?action=GetPECList",
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'B><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'person', "name": "person", "sWidth": "25%" },
            { "data": 'contact_no', "name": "contact_no", "sWidth": "15%", "className": "text-center" },
            { "data": 'mail_address', "name": "mail_address", "sWidth": "25%" },
            { "data": 'city_name', "name": "city_name", "sWidth": "10%", "className": "text-left" },
            {
                "data": null, "name": "action", "sWidth": "10%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdatePEC(event)'><i class='fa fa-edit'></i></button>
                        &nbsp;<button class='btn btn-danger btn-sm action-btn' onclick='DeletePEC(event)'><i class='fa fa-trash'></i></button>`
            }
        ],
        buttons: [{
            text: `<button id="addPEC" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>`,
        }
        ]
    });

    $("#addPEC").click(function () {
        if ($('#selCTIMCity').val() == '') {
            toastr.error('Please Select a City/Town');
        } else {
            $("#modalPECHeader").html('Add Data');
            $("#txtPECId").val('');
            $('#selPECPerson').selectize()[0].selectize.clear();
            $('#selPECCity').selectize()[0].selectize.clear();
            $("#btnSavePEC").html('<i class="fa fa-save"></i>&nbsp;Save');
            $("#btnSavePEC").removeAttr('disabled');
            $('#modalPEC').modal('show');
        }
    });

    $("#btnSavePEC").click(function () {
        $("#btnSavePEC").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSavePEC").attr('disabled', true);

        let id = $("#txtPECId").val();
        let user = $("#selPECPerson").val();
        let city = $("#selPECCity").val();
        $.ajax({
            url: "../api/AdminPECMapping?action=SavePEC",
            type: "POST",
            data: {
                id: id, user: user, city: city
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSavePEC").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSavePEC").removeAttr('disabled');
                    $('#modalPEC').modal('hide');
                    dtblPEC.ajax.reload();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSavePEC").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSavePEC").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSavePEC").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSavePEC").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});

function LoadPersonSelectize() {
    $.ajax({
        url: "../api/AdminPECMapping?action=GetPerson",
        type: "GET",
        success: function (response) {
            var $select = $('#selPECPerson').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                selectize.addOption({ value: data.contact_person_id, text: data.contact_person_name });
            });
        },
        error: function () {
            toastr.error('Unable to load contact person selectize');
        }
    });
}

function LoadCitySelectize(id) {
    $.ajax({
        url: "../api/AdminSetup?action=GetCity",
        type: "GET",
        success: function (response) {
            var $select = $(id).selectize();
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

function UpdatePEC(event) {
    var dtblPEC = $('#dtblPEC').dataTable();
    $(dtblPEC.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalPECHeader").html('Update Data');
    $("#btnSavePEC").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSavePEC").removeAttr('disabled');
    $("#txtPECId").val(dtblPEC.fnGetData(row)['id']);
    $('#selPECPerson').selectize()[0].selectize.setValue(dtblPEC.fnGetData(row)['user']);
    $('#selPECCity').selectize()[0].selectize.setValue(dtblPEC.fnGetData(row)['city']);
    $('#modalPEC').modal('show');
}


function DeletePEC(event) {
    var dtblPEC = $('#dtblPEC').dataTable();
    $(dtblPEC.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    swal({
        title: 'Are you sure to delete ?',
        text: "This Can't be revert",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "../api/AdminPECMapping?action=DeletePEC",
            type: "POST",
            data: { id: dtblPEC.fnGetData(row)['id'] },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $('#dtblPEC').DataTable().ajax.reload();
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