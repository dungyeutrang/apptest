$(function () {

    $('.dataTables-content').dataTable({
        responsive: true,
        bPaginate: false,
        bInfo: false,
        aoColumnDefs: [
            {bSortable: false, aTargets: [4]},
            {bSortable: false, aTargets: [5]}
        ],
        LengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        iDisplayLength: 10,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/Manage/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
        }
    });

    //config spinner 
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
    var url = $('#form-delete').attr('url');
    $('a.btn-delete').each(function (index, e) {
        $(e).click(function (event) {
            event.preventDefault();
            urlcheck = $(e).attr('urlcheck');
            urlDelete = $(e).attr('href');
            catalog = $(e).attr('catalog');
            $('#deleteModal').modal('show');
            $('#btn-delete').click(function () {
                $('#deleteModal').modal('hide');
                $.ajax({
                    url: urlcheck,
                    type: "GET",
                    success: function (data, textStatus, jqXHR) {
                        if (data.code === 2) {
                            if (data.check === 1) {
                                location.assign(urlDelete);
                            } else {
                                $('#deleteMergeModal').modal('show');
                                $('#btn-delete-all').click(function () {
                                    location.assign(urlDelete);
                                });
                                $('#btn-delete-merge').click(function () {
                                    changeData(url, catalog);
                                    $('#content-title').hide();
                                    $('#form-delete').show();
                                    $('#btn-delete-all').hide();
                                    $(this).click(function () {
                                        deleteData(token, urlDelete, $('#category-id').val());
                                    });
                                });
                            }
                        } else {
                            alert("Data invalid");
                        }
                    },
                    error: function (data) {
                        alert("Delete fail.Please try again !");
                    },
                    dataType: 'json'
                });
            });
        });
    });
    // event  when modal hide()
    $('#deleteMergeModal').on('hidden.bs.modal', function (e) {
        $('#content-title').show();
        $('#form-delete').hide();
        $('#btn-delete-all').show();
    });

    // change category by catalog 
    function changeData(url, catalogId) {
        var token = $('input[name="_csrfToken"]').val();
        $.ajax({
            url: url,
            type: "post",
            data: {_csrfToken: token, catalogId: catalogId},
            success: function (data) {
                if (data.code === 2) {
                    $('#category-id').empty();
                    result = data.data;
                    for (i = 0; i < result.length; i++) {
                        $('#category-id').append('<option value="' + result[i].id + '">' + result[i].name + '</option>');
                    }
                } else {
                    alert("Data invalid");
                }
            },
            error: function (data) {
                alert("Connect to Server fail.Please try again !");
            },
            dataType: 'json'
        });
    }

// delete data by merge 
    function deleteData(token, url, id) {
        $.ajax({
            url: url,
            type: "post",
            data: {_csrfToken: token, id: id},
            beforeSend: function (xhr) {
                //start spinner
                spinner = new Spinner(opts).spin(target);
                $('body').css('opacity', 0.8);
            },
            success: function (data) {
                // stop spinner
                spinner.stop();
                $('body').css('opacity', 1);

                $('#deleteMergeModal').modal('hide');
                if (data.code === 1) {
                    alert('Data invalid');
                } else if (data.code === 2) {
                    location.reload();
                } else if (data.code === 3) {
                    alert("Cannot delete category system default");
                }
                else {
                    alert("Delete fail.Please try again !");
                }
            },
            error: function (data) {
                //stop spinner
                spinner.stop();
                $('body').css('opacity', 1);
                alert("Connect to Server fail.Please try again !");
            },
            dataType: 'json'
        });
    }

});

