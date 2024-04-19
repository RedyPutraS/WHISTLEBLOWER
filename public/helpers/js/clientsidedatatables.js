
var Datatable = function (arg) {
    initDatatable();
    
    function initDatatable() {
        var buttons = [
            {
                extend: "excel",
                text: '<i class="ri-file-excel-2-line align-middle me-1"></i> Export to Excel',
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
        ];

        var table = $("#datatable").DataTable({
            responsive: true,
            stateSave: true,
            paging: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Show All"],
            ],
            dom: "<'row mb-3'B>" +
                  "<'row mb-3'<'col-sm-6'l><'col-sm-6 text-right'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: buttons,
            stateSaveParams: function (settings, data) {
                if (arg.filters) {
                    var filters = arg.filters;
                    filters.forEach((filter) => {
                        data[filter.column] = $(filter.element_id).val();
                    });
                }
            },
            stateLoadParams: function (settings, data) {
                if (arg.filters) {
                    var filters = arg.filters;
                    filters.forEach((filter) => {
                        $(filter.element_id).val(data[filter.column]);
                    });
                    $(".select2").select2("");
                }
            },
        });

        return table;
    }
}