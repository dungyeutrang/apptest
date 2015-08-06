$(function () {
    
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