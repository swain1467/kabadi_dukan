$(document).ready(function () {
    //City Tab-1
    $('#txtCityFD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    });
    $('#txtCityFD').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $('#txtCityTD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+1d'
    });
    $('#txtCityTD').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $("#btnCityReportSearch").click(function () {
        LoadCityReportTable();
    });

    let dtblCity = $('#dtblCity').DataTable({
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
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'city_name', "name": "city_name", "sWidth": "20%", "className": "text-left" },
            { "data": 'contact_person_det', "name": "contact_person_det", "sWidth": "22%", "className": "text-left" },
            { "data": 'commission_percent', "name": "commission_percent", "sWidth": "12%", "className": "text-center" },
            { "data": 'total_orders', "name": "total_orders", "sWidth": "12%", "className": "text-center" },
            { "data": 'total_collection', "name": "total_collection", "sWidth": "12%", "className": "text-right" },
            { "data": 'commission', "name": "commission", "sWidth": "12%", "className": "text-right" }
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
            total_orders = api.column(4).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_collection = api.column(5).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_commission = api.column(6).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                total_orders
            );
            $(api.column(5).footer()).html(
                total_collection
            );
            $(api.column(6).footer()).html(
                total_commission
            );
        },
        buttons: [
            {
                extend: 'pdfHtml5',
                pageSize: 'A4',
                text: '<button class="btn btn-danger btn-sm "><i class="fa fa-file-pdf-o" > </i> Pdf</button>',
                filename: 'CityWiseCollectionReport',
                header: true,
                footer: true,
                title: 'City Wise Collection Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                customize: function(doc){
                    doc.content[1].table.widths = [30,60,120,80,60,70,60];
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
                                    text: 'City Wise Collection Report',
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
    //Area Tab-2
    $('#txtAreaFD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+0d'
    });
    $('#txtAreaFD').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $('#txtAreaTD').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        endDate: '+1d'
    });
    $('#txtAreaTD').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    $("#btnAreaReportSearch").click(function () {
        LoadAreaReportTable();
    });

    LoadCitySelectize('#selACity');
    $("#selACity").change(function () {
        LoadAreaReportTable();
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5 col-xs-5'B><'col-lg-3 col-md-3 col-sm-3 col-xs-3' l><'col-lg-4 col-md-4 col-sm-4 col-xs-4' f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9 col-xs-9'i><'col-lg-3 col-md-3 col-sm-3 col-xs-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'city_name', "name": "city_name", "sWidth": "20%", "className": "text-left" },
            { "data": 'area_name', "name": "area_name", "sWidth": "22%", "className": "text-left" },
            { "data": 'commission_percent', "name": "commission_percent", "sWidth": "12%", "className": "text-center" },
            { "data": 'total_orders', "name": "total_orders", "sWidth": "12%", "className": "text-center" },
            { "data": 'total_collection', "name": "total_collection", "sWidth": "12%", "className": "text-right" },
            { "data": 'commission', "name": "commission", "sWidth": "12%", "className": "text-right" }
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
            total_orders = api.column(4).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_collection = api.column(5).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            total_commission = api.column(6).data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                total_orders
            );
            $(api.column(5).footer()).html(
                total_collection
            );
            $(api.column(6).footer()).html(
                total_commission.toFixed(2)
            );
        },
        buttons: [
            {
                extend: 'pdfHtml5',
                pageSize: 'A4',
                text: '<button class="btn btn-danger btn-sm "><i class="fa fa-file-pdf-o" > </i> Pdf</button>',
                filename: 'AreaWiseCollectionReport',
                header: true,
                footer: true,
                title: 'Area Wise Collection Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                customize: function(doc){
                    doc.content[1].table.widths = [30,60,120,80,60,70,60];
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
                                    text: 'Area Wise Collection Report',
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
});
//City Tab-1
function LoadCityReportTable() {
    let from_date = $("#txtCityFD").val();
    let to_date = $("#txtCityTD").val();
    $.ajax({
        "url": "../api/AdminReport?action=GetCityWiseReport",
        type: "get",
        data: { from_date: from_date, to_date: to_date },
        success: function (response) {
            var res = JSON.parse(response);
            if (res.status == 'Error') {
                toastr.warning(res.message);
            } else {
                var table = $('#dtblCity').DataTable();
                table.clear().draw();
                table.rows.add(res.aaData).draw();
            }
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
//Area Tab-2
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
function LoadAreaReportTable() {
    let city = $("#selACity").val();
    let from_date = $("#txtAreaFD").val();
    let to_date = $("#txtAreaTD").val();
    $.ajax({
        "url": "../api/AdminReport?action=GetAreaWiseReport",
        type: "get",
        data: { city: city, from_date: from_date, to_date: to_date },
        success: function (response) {
            var res = JSON.parse(response);
            if (res.status == 'Error') {
                toastr.warning(res.message);
            } else {
                var table = $('#dtblArea').DataTable();
                table.clear().draw();
                table.rows.add(res.aaData).draw();
            }
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
