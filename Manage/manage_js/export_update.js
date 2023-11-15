$(document).ready(function () {
    $('#txtTakeOffDtFrom').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    }).on('changeDate', function (ev) {
	    $('#txtTakeOffDtTo').datepicker('setStartDate', $('#txtTakeOffDtFrom').val());
	});
    $('#txtTakeOffDtFrom').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $('#txtTakeOffDtTo').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    }).on('changeDate', function (ev) {
	    $('#txtTakeOffDtFrom').datepicker('setEndDate', $('#txtTakeOffDtTo').val());
        LoadItemSelectize();
	});
    $('#txtTakeOffDtTo').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $('#txtExportDt').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
    });
    $('#txtExportDt').keydown(function (e) {
        e.preventDefault();
        return false;
    });
    
    LoadCitySelectize(); 
    $("#selCity").change(function () {
        LoadEIList();
    });
    $("#selItem").change(function () {
        LoadItemUserQP()
    });

    let dtblExport = $('#dtblExport').DataTable({
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5 col-xs-5'B><'col-lg-3 col-md-3 col-sm-3 col-xs-3' l><'col-lg-4 col-md-4 col-sm-4 col-xs-4' f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9 col-xs-9'i><'col-lg-3 col-md-3 col-sm-3 col-xs-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "5%" , "className": "text-center" },
            { "data": 'item_name', "name": "item_name", "sWidth": "15%", "className": "text-left" },
            { "data": 'quantity_collect', "name": "quantity_collect", "sWidth": "8%" , "className": "text-right" },
            { "data": 'quantity_export', "name": "quantity_export", "sWidth": "8%", "className": "text-right" },
            { "data": 'price_given', "name": "price_given", "sWidth": "7%", "className": "text-right" },
            { "data": 'price_sold', "name": "price_sold", "sWidth": "7%", "className": "text-right" },
            { "data": 'export_date', "name": "export_date", "sWidth": "14%", "className": "text-center" },
            { "data": 'take_off_date_from', "name": "take_off_date_from", "sWidth": "14%", "className": "text-center" },
            { "data": 'take_off_date_to', "name": "take_off_date_to", "sWidth": "14%", "className": "text-center" },
            {
                "data": null, "name": "action", "sWidth": "8%", "className": "text-center",
                mRender: function (data, type, val) {
                    if (val.change_status == 1) {
                        return `<button class='btn btn-warning btn-xs action-btn' onclick='UpdateItem(event)'><i class='fa fa-edit'></i></button>
                        &nbsp;<button class='btn btn-danger btn-xs action-btn' onclick='DeleteItem(event)'><i class='fa fa-trash'></i></button>`;
                    }
                    else {
                        return `<button class='btn btn-success btn-xs action-btn' onclick='ViewItem(event)'><i class='fa fa-eye'></i></button>`;
                    }
                }
            }
        ],
        "footerCallback": function () {
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total_quantity_collected = api.column(2).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_quantity_export = api.column(3).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_price_given = api.column(4).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_price_sold = api.column(5).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(2).footer()).html(
                total_quantity_collected
            );
            $(api.column(3).footer()).html(
                total_quantity_export
            );
            $(api.column(4).footer()).html(
                total_price_given
            );
            $(api.column(5).footer()).html(
                total_price_sold
            );
        },
        buttons: [{
                text: '<button id="addExportItem" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
            }
        ]
    });
    $("#addExportItem").click(function () {
        $("#modalExportItemHeader").html('Add Item');
        $("#txtExportItemId").val('');
        if($("#txtTakeOffDtFrom").val() == '' || $("#txtTakeOffDtTo").val() == ''
        || $("#selCity").val() == '' || $("#selItem").val() == ''){
            toastr.warning('Select all start fields');
        }else{
            $("#txtQtySold").val('');
            $("#txtPriceSold").val('');
            $("#txtExportDt").val('');
            $("#btnSaveEI").html('<i class="fa fa-save"></i>&nbsp;Save');
            $("#btnSaveEI").removeAttr('disabled');
            $('#modalExportItem').modal('show');
        }
    });
    
    $("#btnSaveEI").click(function () {
        $("#btnSaveEI").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveEI").attr('disabled', true);

        let id = $("#txtExportItemId").val();
        let city = $("#selCity").val();
        let take_off_date_from = $("#txtTakeOffDtFrom").val();
        let take_off_date_to = $("#txtTakeOffDtTo").val();
        let item = $("#selItem").val();
        let price_given = $("#txtPriceGiven").val();
        let price_sold = $("#txtPriceSold").val();
        let quantity_collect = $("#txtQtyCollected").val();
        let quantity_export = $("#txtQtySold").val();
        let export_date = $("#txtExportDt").val();
        $.ajax({
            url: "../api/ManageExportUpdate?action=SaveExportItems",
            type: "POST",
            data: {
                id: id, city: city, item: item, take_off_date_from: take_off_date_from, 
                take_off_date_to: take_off_date_to, price_given: price_given, price_sold: price_sold, 
                quantity_collect: quantity_collect, quantity_export: quantity_export, export_date: export_date
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveEI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveEI").removeAttr('disabled');
                    $('#modalExportItem').modal('hide');
                    LoadEIList();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveEI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveEI").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveEI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveEI").removeAttr('disabled');
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
        url: "../api/EmpUpdateBooking?action=GetCity",
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

function LoadItemSelectize() {
    let take_date_start = $("#txtTakeOffDtFrom").val();
    let take_date_end = $("#txtTakeOffDtTo").val();
    let city = $("#selCity").val();
    $.ajax({
        url: "../api/ManageExportUpdate?action=GetItem",
        type: "POST",
        data: {take_date_start: take_date_start, take_date_end: take_date_end, city: city},
        success: function (response) {
            var res = JSON.parse(response);
            if(res.status == 'Error'){
                toastr.warning(res.message);
            }else{
                var $select = $('#selItem').selectize();
                var selectize = $select[0].selectize;
                selectize.clear();
                selectize.clearOptions();
                $.each(res.aaData, function (i, data) {
                    selectize.addOption({ value: data.item, text: data.item_detail });
                });
            }
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}

function LoadItemUserQP() {
    let take_date_start = $("#txtTakeOffDtFrom").val();
    let take_date_end = $("#txtTakeOffDtTo").val();
    let city = $("#selCity").val();
    let item = $("#selItem").val();
    $.ajax({
        url: "../api/ManageExportUpdate?action=GetItemUserQP",
        type: "POST",
        data: {take_date_start: take_date_start, take_date_end: take_date_end, city: city, item: item},
        success: function (response) {
            var res = JSON.parse(response);
            $.each(res.aaData, function (i, data) {
                $('#txtQtyCollected').val(data.quantity);
                $('#txtPriceGiven').val(data.price);
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadEIList() {
    let city = $("#selCity").val();
    $.ajax({
        "url": "../api/ManageExportUpdate?action=GetEIList",
        type: "POST",
        data: {city: city},
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblExport').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}

function UpdateItem(event) {
    var dtblExport = $('#dtblExport').dataTable();
    $(dtblExport.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalExportItemHeader").html('Update Item');
    $("#btnSaveEI").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveEI").removeAttr('disabled');

    $("#txtExportItemId").val(dtblExport.fnGetData(row)['id']);
    $('#txtQtyCollected').val(dtblExport.fnGetData(row)['quantity_collect']);
    $('#txtPriceGiven').val(dtblExport.fnGetData(row)['price_given']);
    $('#txtQtySold').val(dtblExport.fnGetData(row)['quantity_export']);
    $("#txtPriceSold").val(dtblExport.fnGetData(row)['price_sold']);
    $("#txtExportDt").val(dtblExport.fnGetData(row)['export_date']);
    $('#modalExportItem').modal('show');
}

function DeleteItem(event) {
    var dtblExport = $('#dtblExport').dataTable();
    $(dtblExport.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtblExport.fnGetData(row)['id'];
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
            url: "../api/ManageExportUpdate?action=DeleteExportItems",
            type: "POST",
            data: { id: id },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    LoadEIList();
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

function ViewItem(event) {
    var dtblExport = $('#dtblExport').dataTable();
    $(dtblExport.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalUserItemHeader").html('View Item');
    $("#btnSaveEI").html('<i class="fa fa-edit"></i>&nbsp;View');
    $("#btnSaveEI").attr('disabled', true);

    $("#txtUserItemId").val(dtblExport.fnGetData(row)['id']);
    $('#selItem').selectize()[0].selectize.setValue(dtblExport.fnGetData(row)['item']);
    $("#txtQuantity").val(dtblExport.fnGetData(row)['quantity']);
    $("#txtPrice").val(dtblExport.fnGetData(row)['price_given']);
    $('#modalUserItem').modal('show');
}