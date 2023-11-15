$(document).ready(function () {
    $('#divItemPrice').hide();
    $("#btnBTO").click(function () {
        window.open('BookingTakeOff', '_self');
    });
    $("#btnBH").click(function () {
        window.open('BookingHistory', '_self');
    });
    let dtblItemPrice = $('#dtblItemPrice').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
        bStateSave: false,
        bPaginate: false,
        bLengthChange: true,
        bFilter: false,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'item_name', "name": "item_name", "sWidth": "40%" },
            { "data": 'unit', "name": "unit", "sWidth": "15%", "className": "text-center" },
            { "data": 'pricing', "name": "pricing", "sWidth": "35%", "className": "text-right" },
        ]
    });
});

function showItemPrice(city_id) {
    LoadItemPricingDataTable(city_id);
    $("#divItemPrice").show(3000);
}
function hideItemPrice() {
    $("#divItemPrice").hide(3000);
}
function LoadItemPricingDataTable(city_id) {
    $.ajax({
        "url": "../api/UserHome?action=GetItemPricingList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var res = JSON.parse(response);
            var table = $('#dtblItemPrice').DataTable();
            table.clear().draw();
            table.rows.add(res.aaData).draw();
        },
        error: function () {
            toastr.error('Sorry! Unable to load item pricing table');
        }
    });
}