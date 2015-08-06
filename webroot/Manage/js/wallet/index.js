$(function () {

    $('.dataTables-content').dataTable({
        responsive: true,
        bPaginate: false,
        bInfo: false,
        aoColumnDefs: [
            {bSortable: false, aTargets: [3]},
            {bSortable: false, aTargets: [4]},
            {bSortable: false, aTargets: [5]},
            {bSortable: false, aTargets: [6]}
        ],
        LengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        iDisplayLength: 10,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/Manage/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });

    $('a.btn-delete').each(function (index, e) {
        $(e).click(function (event) {
            event.preventDefault();
            urlDelete = $(e).attr('href');
            $('#deleteModal').modal('show');
            $('#btn-delete').click(function () {
                location.assign(urlDelete);
            });
        });

    });

});