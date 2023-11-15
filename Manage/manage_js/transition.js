$(document).ready(function () {

    LoadCitySelectize('#selBDCity');
    $('#selBDStatus').selectize();
    $("#selBDCity").change(function () {
        LoadAreaSelectize('#selBDArea');
        LoadAreaSelectize('#selActiveArea');
        LoadBDDataTable();
    });

    $('#txtBDBD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    });

    $('#txtBDTOD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+30d'
    });

    $("#selBDArea").change(function () {
        LoadBDDataTable();
    });

    $("#txtBDBD").change(function () {
        LoadBDDataTable();
    });

    $("#txtBDTOD").change(function () {
        LoadBDDataTable();
    });

    $("#selBDStatus").change(function () {
        LoadBDDataTable();
    });

    $('#txtActiveTOD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        startDate: '+0d',
        endDate: '+30d'
    });
    $('#txtActiveTOD').keydown(function (e) {
        e.preventDefault();
        return false;
    });
    let dtblBD = $('#dtblBD').DataTable({
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5 col-xs-5'B><'col-lg-3 col-md-3 col-sm-3 col-xs-3' l><'col-lg-4 col-md-4 col-sm-4 col-xs-4' f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9 col-xs-9'i><'col-lg-3 col-md-3 col-sm-3 col-xs-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "5%", "className": "text-center" },
            { "data": 'area_name', "name": "area_name", "sWidth": "10%", "className": "text-center" },
            { "data": 'code', "name": "code", "sWidth": "10%", "className": "text-center" },
            { "data": 'name', "name": "name", "sWidth": "10%" },
            { "data": 'contact_no', "name": "contact_no", "sWidth": "8%", "className": "text-center" },
            { "data": 'detailed_address', "name": "detailed_address", "sWidth": "25%" },
            { "data": 'booking_on', "name": "booking_on", "sWidth": "7%", "className": "text-center" },
            { "data": 'take_off_on', "name": "take_off_on", "sWidth": "7%", "className": "text-center" },
            { "data": 'scrap_price', "name": "scrap_price", "sWidth": "6%", "className": "text-right" },
            { "data": 'signature', "name": "signature", "sWidth": "6%", "visible": false },
            {
                "data": 'status', "name": "status", "sWidth": "4%", "className": "text-center",
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
                "data": null, "name": "action", "sWidth": "8%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-xs action-btn' onclick='UpdateActive(event)'><i class='fa fa-edit'></i></button>
                &nbsp;<button class='btn btn-dark btn-xs action-btn' onclick='ViewItem(event)'><i class='fa fa-eye'></i></button>`
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
            total_price = api.column(8).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            // Update footer
            $(api.column(8).footer()).html(
                total_price
            );
        },
        buttons: [
            {
                text: '<button onclick="MassUpdate()" class="btn btn-success btn-sm"><i class="fa fa-tasks"></i>&nbsp;Mass Update</button>',
            },
            {
                extend: 'pdfHtml5',
                pageSize: 'A4',
                orientation: 'landscape',
                text: '<button class="btn btn-danger btn-sm "><i class="fa fa-file-pdf-o" > </i> Pdf</button>',
                filename: 'BookingList',
                header: true,
                title: 'Booking List',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
                customize: function(doc){
                    doc.content[1].table.widths = [30,90,75,75,60,130,60,60,60,80];
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
                                    text: 'Name (Contact Number) :-',
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
                    background: 'blue',
                    alignment: 'right'
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'item_detail', "name": "item_detail", "sWidth": "50%", "className": "text-left" },
            { "data": 'quantity', "name": "quantity", "sWidth": "25%", "className": "text-right" },
            { "data": 'price_given', "name": "price_given", "sWidth": "25%", "className": "text-right" }
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
        }
    });

    $("#btnSaveActive").click(function () {
        $("#btnSaveActive").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnSaveActive").attr('disabled', true);

        let id = $("#txtActiveId").val();
        let area = $("#selActiveArea").val();
        let code = $("#txtActiveCode").val();
        let scrap_price = $("#txtActiveScrapPrice").val();
        let take_off_date = $("#txtActiveTOD").val();
        let address = $("#txtActiveAddress").val();
        var contact_no = $("#txtActiveContactNo").val();
        let active_status = 0
        if ($("#txtActiveActive").prop("checked")) {
            active_status = 1
        }
        $.ajax({
            url: "../api/AdminTransition?action=UpdateBookingDetails",
            type: "POST",
            data: {
                id: id, code: code, area: area, scrap_price: scrap_price, address: address,
                take_off_date: take_off_date, contact_no: contact_no, active_status: active_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    LoadBDDataTable();
                    toastr.success(res.message);
                    $("#btnSaveActive").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveActive").removeAttr('disabled');
                    $('#modalActive').modal('hide');
                } else if (res.status == 'Error') {
                    $("#btnSaveActive").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveActive").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveActive").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveActive").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});
function LoadCitySelectize(id) {
    $.ajax({
        url: "../api/EmpUpdateBooking?action=GetCity",
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
function LoadAreaSelectize(id) {
    let city_id = $("#selBDCity").val();
    $.ajax({
        "url": "../api/AdminSetup?action=GetAreaList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var $select = $(id).selectize();
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
function LoadBDDataTable() {
    let city = $("#selBDCity").val();
    let area = $("#selBDArea").val();
    let booking_date = $("#txtBDBD").val();
    let take_off_date = $("#txtBDTOD").val();
    let status = $("#selBDStatus").val();
    $.ajax({
        "url": "../api/AdminTransition?action=GetBookingList",
        type: "post",
        data: {
            city: city, area: area, status: status,
            booking_date: booking_date, take_off_date: take_off_date
        },
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblBD').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
function UpdateActive(event) {
    var dtblBD = $('#dtblBD').dataTable();
    $(dtblBD.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalActiveHeader").html('Update Booking Details');
    $("#btnSaveActive").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveActive").removeAttr('disabled');

    $("#txtActiveId").val(dtblBD.fnGetData(row)['id']);
    $("#txtActiveCode").val(dtblBD.fnGetData(row)['code']);
    $("#txtActiveCode").attr('disabled', true);
    $("#txtActiveBD").val(dtblBD.fnGetData(row)['booking_on']);
    $("#txtActiveBD").attr('disabled', true);
    $('#selActiveArea').selectize()[0].selectize.setValue(dtblBD.fnGetData(row)['area']);
    $("#txtActiveTOD").val(dtblBD.fnGetData(row)['take_off_on']);
    $("#txtActiveContactNo").val(dtblBD.fnGetData(row)['contact_no']);
    $("#txtActiveAddress").val(dtblBD.fnGetData(row)['detailed_address']);
    $("#txtActiveScrapPrice").val(dtblBD.fnGetData(row)['scrap_price']);

    if (dtblBD.fnGetData(row)['status'] == 1) {
        $("#txtActiveActive").prop("checked", true);
    } else {
        $("#txtActiveInactive").prop("checked", true);
    }
    $('#modalActive').modal('show');
}

function MassUpdate() {
    let city = $('#selBDCity').val();
    let area = $('#selBDArea').val();
    let booking_date = $('#txtBDBD').val();
    let take_off_date = $('#txtBDTOD').val();
    let status = $('#selBDStatus').val();
    swal({
        title: 'Are you sure to do this ?',
        text: "In this process you are updateing the take off date at once.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "../api/AdminTransition?action=MassUpdate",
            type: "POST",
            data: {
                city: city, area: area, status: status,
                booking_date: booking_date, take_off_date: take_off_date
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    LoadBDDataTable();
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
    var dtblBD = $('#dtblBD').dataTable();
    $(dtblBD.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    LoadItemsList(dtblBD.fnGetData(row)['code']);
    $("#modalUserItemHeader").html(dtblBD.fnGetData(row)['name']+' ('+dtblBD.fnGetData(row)['code']+')');
    $('#modalUserItem').modal('show');
}

function LoadItemsList(booking_id) {
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
