$('.dataTables-content').dataTable({
    responsive: true,
    bPaginate: false,
    bInfo: false,
    LengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    iDisplayLength: 10,
    "dom": 'T<"clear">lfrtip',
    "tableTools": {
        "sSwfPath": "/Manage/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
    }
});

$('.message').fadeOut(3000);
