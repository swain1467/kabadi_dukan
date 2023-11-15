$(document).ready(function () {
    // Item Tab-1 Start
    LoadItemDataTable();
    let dtblItem = $('#dtblItem').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
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
            { "data": 'item_name', "name": "item_name", "sWidth": "70%" },
            {
                "data": 'status', "name": "status", "sWidth": "10%", "className": "text-center",
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
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateItem(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addItem" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addItem").click(function () {
        $("#modalItemHeader").html('Add Item');
        $("#txtItemId").val('');
        $("#txtItemName").val('');
        $("#txtItemActive").prop("checked", true);
        $("#btnSaveItem").html('<i class="fa fa-save"></i>&nbsp;Save');
        $("#btnSaveItem").removeAttr('disabled');
        $('#modalItem').modal('show');
    });
    $("#btnSaveItem").click(function () {
        $("#btnSaveItem").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveItem").attr('disabled', true);

        let id = $("#txtItemId").val();
        let item_name = $("#txtItemName").val();
        let item_status = 0
        if ($("#txtItemActive").prop("checked")) {
            item_status = 1
        }
        $.ajax({
            url: "../api/AdminSetup?action=SaveItem",
            type: "POST",
            data: {
                id: id, item_name: item_name, item_status: item_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveItem").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveItem").removeAttr('disabled');
                    $('#modalItem').modal('hide');
                    LoadItemDataTable();
                    LoadItemSelectize();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveItem").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveItem").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveItem").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveItem").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });

    // City Tab-2 Start
    LoadContactPersonSelectize();
    let dtblCity = $('#dtblCity').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "../api/AdminSetup?action=GetCityList",
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
            { "data": 'city_name', "name": "city_name", "sWidth": "25%" },
            { "data": 'commission', "name": "commission", "sWidth": "15%", "className": "text-center" },
            { "data": 'contact_person_name', "name": "contact_person_name", "sWidth": "30%" },
            {
                "data": 'status', "name": "status", "sWidth": "10%", "className": "text-center",
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
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateCity(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addCity" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addCity").click(function () {
        $("#modalCityHeader").html('Add City/Town');
        $("#txtCityId").val('');
        $("#txtCityName").val('');
        $("#txtCityCommission").val('');
        $('#selCityCP').selectize()[0].selectize.clear();
        $("#txtCityActive").prop("checked", true);
        $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
        $("#btnSaveCity").removeAttr('disabled');
        $('#modalCity').modal('show');
    });
    $("#btnSaveCity").click(function () {
        $("#btnSaveCity").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveCity").attr('disabled', true);

        let city_id = $("#txtCityId").val();
        let city_name = $("#txtCityName").val();
        let commission = $("#txtCityCommission").val();
        let contact_person = $("#selCityCP").val();
        let city_status = 0
        if ($("#txtCityActive").prop("checked")) {
            city_status = 1
        }
        $.ajax({
            url: "../api/AdminSetup?action=SaveCity",
            type: "POST",
            data: {
                city_id: city_id, city_name: city_name, commission: commission,
                contact_person: contact_person, city_status: city_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    $('#modalCity').modal('hide');
                    LoadCitySelectize('#selCTIMCity');
                    LoadCitySelectize('#selAreaCity');
                    dtblCity.ajax.reload();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
    //CTIM Tab-3 Start
    LoadCitySelectize('#selCTIMCity');
    LoadItemSelectize();
    $("#selCTIMCity").change(function () {
        LoadCTIMDataTable();
    });
    let dtblCTIM = $('#dtblCTIM').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
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
            { "data": 'city_name', "name": "city_name", "sWidth": "20%" },
            { "data": 'item_name', "name": "item_name", "sWidth": "20%" },
            { "data": 'unit', "name": "unit", "sWidth": "20%", "className": "text-center" },
            { "data": 'pricing', "name": "pricing", "sWidth": "12%", "className": "text-right" },
            {
                "data": 'status', "name": "status", "sWidth": "8%", "className": "text-center",
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
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateCTIM(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addCTIM" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addCTIM").click(function () {
        if ($('#selCTIMCity').val() == '') {
            toastr.error('Please Select a City/Town');
        } else {
            $("#modalCTIMHeader").html('Add City To Item Map For ' + $('#selCTIMCity').text());
            $("#txtCTIMId").val('');
            $("#txtCTIMPricing").val('');
            $("#txtCTIMUnit").val('');
            $("#txtCTIMActive").prop("checked", true);
            $('#selCTIMItem').selectize()[0].selectize.clear();
            $("#btnSaveCTIM").html('<i class="fa fa-save"></i>&nbsp;Save');
            $("#btnSaveCTIM").removeAttr('disabled');
            $('#modalCTIM').modal('show');
        }
    });
    $("#btnSaveCTIM").click(function () {
        $("#btnSaveCTIM").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveCTIM").attr('disabled', true);

        let ctim_id = $("#txtCTIMId").val();
        let pricing = $("#txtCTIMPricing").val();
        let unit = $("#txtCTIMUnit").val();
        let city = $("#selCTIMCity").val();
        let item = $("#selCTIMItem").val();
        let ctim_status = 0
        if ($("#txtCTIMActive").prop("checked")) {
            ctim_status = 1
        }
        $.ajax({
            url: "../api/AdminSetup?action=SaveCTIM",
            type: "POST",
            data: {
                ctim_id: ctim_id, pricing: pricing, unit: unit, city: city, item: item, ctim_status: ctim_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveCTIM").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCTIM").removeAttr('disabled');
                    $('#modalCTIM').modal('hide');
                    LoadCTIMDataTable();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveCTIM").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCTIM").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveCTIM").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCTIM").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
    //Area Tab-4 Start
    LoadCitySelectize('#selAreaCity');
    $("#selAreaCity").change(function () {
        LoadAreaDataTable();
    });
    let dtblArea = $('#dtblArea').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
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
            { "data": 'city_name', "name": "city_name", "sWidth": "30%" },
            { "data": 'area_name', "name": "area_name", "sWidth": "40%" },
            {
                "data": 'status', "name": "status", "sWidth": "10%", "className": "text-center",
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
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateArea(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addArea" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addArea").click(function () {
        if ($('#selAreaCity').val() == '') {
            toastr.error('Please Select a City/Town');
        } else {
            $("#modalAreaHeader").html('Add Area For ' + $('#selAreaCity').text());
            $("#txtAreaId").val('');
            $("#txtAreaName").val('');
            $("#txtAreaActive").prop("checked", true);
            $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
            $("#btnSaveArea").removeAttr('disabled');
            $('#modalArea').modal('show');
        }
    });
    $("#btnSaveArea").click(function () {
        $("#btnSaveArea").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveArea").attr('disabled', true);

        let area_id = $("#txtAreaId").val();
        let area_name = $("#txtAreaName").val();
        let city_id = $("#selAreaCity").val();
        let area_status = 0
        if ($("#txtAreaActive").prop("checked")) {
            area_status = 1
        }
        $.ajax({
            url: "../api/AdminSetup?action=SaveArea",
            type: "POST",
            data: {
                area_id: area_id, area_name: area_name, city_id: city_id, area_status: area_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    $('#modalArea').modal('hide');
                    LoadAreaDataTable()
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});

// Item Tab-1 Start
function LoadItemDataTable() {
    $.ajax({
        "url": "../api/AdminSetup?action=GetItemList",
        type: "get",
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblItem').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}

function UpdateItem(event) {
    var dtblItem = $('#dtblItem').dataTable();
    $(dtblItem.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalItemHeader").html('Update Item');
    $("#btnSaveItem").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveItem").removeAttr('disabled');

    $("#txtItemId").val(dtblItem.fnGetData(row)['id']);
    $("#txtItemName").val(dtblItem.fnGetData(row)['item_name']);
    if (dtblItem.fnGetData(row)['status'] == 1) {
        $("#txtItemActive").prop("checked", true);
    } else {
        $("#txtItemInactive").prop("checked", true);
    }
    $('#modalItem').modal('show');
}
// City Tab-2 Start
function LoadContactPersonSelectize() {
    $.ajax({
        url: "../api/AdminSetup?action=GetCPS",
        type: "GET",
        success: function (response) {
            var $select = $('#selCityCP').selectize();
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
function UpdateCity(event) {
    var dtblCity = $('#dtblCity').dataTable();
    $(dtblCity.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalCityHeader").html('Update City/Town');
    $("#btnSaveCity").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveCity").removeAttr('disabled');

    $("#txtCityId").val(dtblCity.fnGetData(row)['id']);
    $("#txtCityName").val(dtblCity.fnGetData(row)['city_name']);
    $("#txtCityCommission").val(dtblCity.fnGetData(row)['commission']);
    $('#selCityCP').selectize()[0].selectize.setValue(dtblCity.fnGetData(row)['contact_person_id']);
    if (dtblCity.fnGetData(row)['status'] == 1) {
        $("#txtCityActive").prop("checked", true);
    } else {
        $("#txtCityInactive").prop("checked", true);
    }
    $('#modalCity').modal('show');
}
// CTIM Tab-3 Start
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
function LoadItemSelectize() {
    $.ajax({
        url: "../api/AdminSetup?action=GetItemList",
        type: "GET",
        success: function (response) {
            var $select = $('#selCTIMItem').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                if (data.status == 1) {
                    selectize.addOption({ value: data.id, text: data.item_name });
                }
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadCTIMDataTable() {
    let city_id = $("#selCTIMCity").val();
    $.ajax({
        "url": "../api/AdminSetup?action=GetCTIMList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblCTIM').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
function UpdateCTIM(event) {
    var dtblCTIM = $('#dtblCTIM').dataTable();
    $(dtblCTIM.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalCTIMHeader").html('Add City To Item Map For ' + $('#selCTIMCity').text());
    $("#btnSaveCTIM").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveCTIM").removeAttr('disabled');

    $("#txtCTIMId").val(dtblCTIM.fnGetData(row)['id']);
    $("#txtCTIMUnit").val(dtblCTIM.fnGetData(row)['unit']);
    $("#txtCTIMPricing").val(dtblCTIM.fnGetData(row)['pricing']);
    $('#selCTIMItem').selectize()[0].selectize.setValue(dtblCTIM.fnGetData(row)['item_id']);
    if (dtblCTIM.fnGetData(row)['status'] == 1) {
        $("#txtCTIMActive").prop("checked", true);
    } else {
        $("#txtCTIMInactive").prop("checked", true);
    }
    $('#modalCTIM').modal('show');
}

// Area Tab-4 Start
function LoadAreaDataTable() {
    let city_id = $("#selAreaCity").val();
    $.ajax({
        "url": "../api/AdminSetup?action=GetAreaList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblArea').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
function UpdateArea(event) {
    var dtblArea = $('#dtblArea').dataTable();
    $(dtblArea.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalAreaHeader").html('Add Area For ' + $('#selAreaCity').text());
    $("#btnSaveArea").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveArea").removeAttr('disabled');

    $("#txtAreaId").val(dtblArea.fnGetData(row)['id']);
    $("#txtAreaName").val(dtblArea.fnGetData(row)['area_name']);
    if (dtblArea.fnGetData(row)['status'] == 1) {
        $("#txtAreaActive").prop("checked", true);
    } else {
        $("#txtAreaInactive").prop("checked", true);
    }
    $('#modalArea').modal('show');
}
