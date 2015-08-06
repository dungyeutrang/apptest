$(function () {

    $('.dataTables-content').dataTable({
        responsive: true,
        bPaginate: false,
        bInfo: false,
        aoColumnDefs: [
            {bSortable: false, aTargets: [6]},
            {bSortable: false, aTargets: [7]}
        ],
        LengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        iDisplayLength: 10,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/Manage/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });
    
    var opts = {
        lines: 13 // The number of lines to draw
        , length: 28 // The length of each line
        , width: 14 // The line thickness
        , radius: 42 // The radius of the inner circle
        , scale: 1 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#37a33b' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , rotate: 0 // The rotation offset
        , direction: 1 // 1: clockwise, -1: counterclockwise
        , speed: 1 // Rounds per second
        , trail: 60 // Afterglow percentage
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 2e9 // The z-index (defaults to 2000000000)
        , className: 'spinner' // The CSS class to assign to the spinner
        , top: '50%' // Top position relative to parent
        , left: '50%' // Left position relative to parent
        , shadow: false // Whether to render a shadow
        , hwaccel: false // Whether to use hardware acceleration
        , position: 'absolute' // Element positioning
    };
    var target = document.getElementById('loading');
    var spinner;
    var token = $('input[name="_csrfToken"]').val();
    $('#change-date').change(function () {
        value = $(this).val();
        $.ajax({
            url: value,
            type: "POST",
            data: {_csrfToken: token},
            beforeSend: function (xhr) {
                spinner = new Spinner(opts).spin(target);
                $('body').css('opacity', 0.8);
            },
            success: function (data) {
                $('#ibox-content').empty();
                $('#ibox-content').html(data);
                spinner.stop();
                $('body').css('opacity', 1);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Server not response !");
                spinner.stop();
                $('body').css('opacity', 1);
            },
            dataType: 'html'

        });
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