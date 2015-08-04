$(function () {
 var token = $('input[name="_csrfToken"]').val();
    $('#change-date').change(function () {
        value = $(this).val();
        $.ajax({
            url: value,
            type: "POST",
            data:{_csrfToken:token},
            success: function (data) {
                console.log(data);
             $('#ibox-content').empty();
             $('#ibox-content').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
               alert("Server not response !");
            },
            dataType: 'html'

        });
    });

});