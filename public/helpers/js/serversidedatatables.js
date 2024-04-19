var table = null;

var Datatable = function (arg) {
    var currentdate = new Date();
    var datetime =
        currentdate.getFullYear() +
        "/" +
        (currentdate.getMonth() + 1) +
        "/" +
        currentdate.getDate() +
        " " +
        currentdate.getHours() +
        ":" +
        currentdate.getMinutes() +
        ":" +
        currentdate.getSeconds();

    initDatatable();

    function initDatatable() {
        table = $("#datatable").DataTable({
            stateSave: true,
            processing: true,
            serverSide: true,
            paging: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Show All"],
            ],
            columns: arg.columns,
            columnDefs: arg.columnDefs ? arg.columnDefs : false,
            select: arg.select ? arg.select : false,
            responsive: true, // true untuk expanded column, false untuk scrollable column
            ajax: {
                url: arg.url,
                type: "POST",
                data: function (d) {
                    d._token = arg.csrf;
                },
                error: function (e) {
                    console.log(e);
                },
            },
            dom: arg.dom ? arg.dom : 
                "<'row mb-3'B>" +
                  "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons:
                [
                    {
                        extend: "excel",
                        text: '<i class="ri-file-excel-2-line align-middle"></i> Export to Excel',
                        titleAttr: "Export to Excel",
                        className: "btn btn-info my-1 mr-1",
                        exportOptions: {
                            columns: ":not(.column_action)",
                        },
                    },
                    {
                        extend: "copyHtml5",
                        text: '<i class="ri-file-copy-2-line align-middle me-1"></i> Copy to Clipboard',
                        titleAttr: "Copy to clipboard",
                        className: "btn btn-info my-1 mr-1",
                        exportOptions: {
                            columns: ":not(.column_action)",
                        },
                    }
                ],
            stateSaveParams: function (settings, data) {
                if (arg.filters) {
                    var filters = arg.filters;
                    filters.forEach((filter) => {
                        data[filter.column] = $("#" + filter.column).val();
                    });
                }
            },
            stateLoadParams: function (settings, data) {
                if (arg.filters) {
                    var filters = arg.filters;
                    filters.forEach((filter) => {
                        $("#" + filter.column).val(data[filter.column]);
                    });
                    $(".select2").select2("");
                }
            },
        });
    }

    function filter() {
        $("#modal-form-filter").modal("show");
    }
};

function submitFilter() {
    table.ajax.reload();
}

function resetFilter(filters) {
    filters.forEach((filter) => {
        $("#" + filter.column).val("");
    });
    $(".select2").select2("");
    table.ajax.reload();
}
