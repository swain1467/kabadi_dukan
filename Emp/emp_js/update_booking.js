$(document).ready(function () {
    $('#txtTakeOffDate').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    });
    $('#txtTakeOffDate').keydown(function (e) {
        e.preventDefault();
        return false;
    });
    LoadCitySelectize();
    $("#selCity").change(function () {
        LoadBookingIdSelectize();
        LoadItemSelectize();
    });
    $("#selBookingId").change(function () {
        LoadItemsList();
    });

    let dtbleUserItems = $('#dtbleUserItems').DataTable({
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
        bStateSave: false,
        bPaginate: false,
        bLengthChange: true,
        bFilter: true,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'B><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'item_detail', "name": "item_detail", "sWidth": "50%", "className": "text-center" },
            { "data": 'quantity', "name": "quantity", "sWidth": "10%" },
            { "data": 'price_given', "name": "price_given", "sWidth": "10%" },
            {
                "data": null, "name": "action", "sWidth": "30%", "className": "text-center",
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
            total_quantity = api.column(1).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_price = api.column(2).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(1).footer()).html(
                total_quantity
            );
            $(api.column(2).footer()).html(
                total_price
            );
        },
        buttons: [{
                text: '<button id="addUserItem" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
            },{
                extend: 'pdfHtml5',
                pageSize: 'A4',
                text: '<button class="btn btn-danger btn-sm "><i class="fa fa-file-pdf-o" > </i> Pdf</button>',
                filename: 'UserReceipt',
                header: true,
                footer: true,
                title: 'item Receipt',
                exportOptions: {
                    columns: [0, 1, 2]
                },
                customize: function(doc){
                    doc.content[1].table.widths = [300,90,90];
                    //Remove the title created by datatTables
                    doc.content.splice(0,1);
                    var now = new Date();
                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                    doc.pageMargins = [20,60,20,30];
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 10;

                    doc['header']=(function() {
                        return {
                            columns: [
                                {
                                    alignment: 'left',
                                    italics: true,
                                    text: 'item Receipt',
                                    fontSize: 18
                                },
                                {
                                    alignment: 'right',
                                    fontSize: 14,
                                    text: 'Kabadi Dukan'
                                }
                            ],
                            margin: 20
                        }
                    });
                    doc.styles.tableHeader = {
                        color: 'black',
                        alignment: 'center',
                        bold: true
                    }
                    doc.styles.tableBodyEven = {
                
                    }
                    doc.styles.tableBodyOdd = {
                    // background: 'blue',
                    // alignment: 'right'
                    }
                    doc.styles.tableFooter = {
                        color: 'black',
                        alignment: 'right',
                        bold: true
                    }


                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                {
                                    alignment: 'left',
                                    text: ['Created on: ', { text: jsDate.toString() }]
                                },
                                {
                                    alignment: 'right',
                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                }
                            ],
                            margin: 5
                        }
                    });

                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return .5; };
                    objLayout['vLineWidth'] = function(i) { return .5; };
                    objLayout['hLineColor'] = function(i) { return '#000'; };
                    objLayout['vLineColor'] = function(i) { return '#000'; };
                    objLayout['paddingLeft'] = function(i) { return 4; };
                    objLayout['paddingRight'] = function(i) { return 4; };
                    doc.content[0].layout = objLayout;
                }
            }
        ]
    });
    $("#addUserItem").click(function () {
        $("#modalUserItemHeader").html('Add Item');
        $('#selItem').selectize()[0].selectize.clear();
        $("#txtUserItemId").val('');
        $("#txtQuantity").val('');txtPrice
        $("#txtPrice").val('');
        $("#btnSaveUI").html('<i class="fa fa-save"></i>&nbsp;Save');
        $("#btnSaveUI").removeAttr('disabled');
        $('#modalUserItem').modal('show');
    });
    
    $("#btnSaveUI").click(function () {
        $("#btnSaveUI").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveUI").attr('disabled', true);

        let id = $("#txtUserItemId").val();
        let item = $("#selItem").val();
        let booking_id = $("#selBookingId").val();
        let quantity = $("#txtQuantity").val();
        let price_given = $("#txtPrice").val();
        $.ajax({
            url: "../api/EmpUpdateBooking?action=SaveUserItems",
            type: "POST",
            data: {
                id: id, item: item, booking_id: booking_id, quantity: quantity, price_given: price_given
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    $("#btnSaveUI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveUI").removeAttr('disabled');
                    $('#modalUserItem').modal('hide');
                    LoadItemsList();
                    toastr.success(res.message);
                } else if (res.status == 'Error') {
                    $("#btnSaveUI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveUI").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveUI").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveUI").removeAttr('disabled');
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
function LoadBookingIdSelectize() {
    let take_off_date = $("#txtTakeOffDate").val();
    let city = $("#selCity").val();
    $.ajax({
        url: "../api/EmpUpdateBooking?action=GetBookingId",
        type: "POST",
        data: {take_off_date: take_off_date, city: city},
        success: function (response) {
            var $select = $('#selBookingId').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                selectize.addOption({ value: data.booking_id, text: data.booking });
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadItemSelectize() {
    let city = $("#selCity").val();
    $.ajax({
        url: "../api/EmpUpdateBooking?action=GetItem",
        type: "POST",
        data: {city: city},
        success: function (response) {
            var $select = $('#selItem').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                selectize.addOption({ value: data.item_id, text: data.item_detail });
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadItemsList() {
    let booking_id = $("#selBookingId").val();
    $.ajax({
        "url": "../api/EmpUpdateBooking?action=GetItemsList",
        type: "POST",
        data: {booking_id: booking_id},
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtbleUserItems').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}

function UpdateItem(event) {
    var dtbleUserItems = $('#dtbleUserItems').dataTable();
    $(dtbleUserItems.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalUserItemHeader").html('Update Item');
    $("#btnSaveUI").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveUI").removeAttr('disabled');

    $("#txtUserItemId").val(dtbleUserItems.fnGetData(row)['id']);
    $('#selItem').selectize()[0].selectize.setValue(dtbleUserItems.fnGetData(row)['item']);
    $("#txtQuantity").val(dtbleUserItems.fnGetData(row)['quantity']);
    $("#txtPrice").val(dtbleUserItems.fnGetData(row)['price_given']);
    $('#modalUserItem').modal('show');
}
function DeleteItem(event) {
    var dtbleUserItems = $('#dtbleUserItems').dataTable();
    $(dtbleUserItems.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtbleUserItems.fnGetData(row)['id'];
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
            url: "../api/EmpUpdateBooking?action=DeleteItems",
            type: "POST",
            data: { id: id },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    LoadItemsList();
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
    var dtbleUserItems = $('#dtbleUserItems').dataTable();
    $(dtbleUserItems.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalUserItemHeader").html('View Item');
    $("#btnSaveUI").html('<i class="fa fa-edit"></i>&nbsp;View');
    $("#btnSaveUI").attr('disabled', true);

    $("#txtUserItemId").val(dtbleUserItems.fnGetData(row)['id']);
    $('#selItem').selectize()[0].selectize.setValue(dtbleUserItems.fnGetData(row)['item']);
    $("#txtQuantity").val(dtbleUserItems.fnGetData(row)['quantity']);
    $("#txtPrice").val(dtbleUserItems.fnGetData(row)['price_given']);
    $('#modalUserItem').modal('show');
}