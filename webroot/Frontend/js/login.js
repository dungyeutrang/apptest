$(function () {
    $('#form-login').submit(function (e) {
        e.preventDefault();
        token = $('#form-login input[name="_csrfToken"]').val();
        email = $(this).find('#email').val();
        password = $(this).find('#password').val();
        $.ajax({
            url: 'loginHome',
            type: 'POST',
            data: {_csrfToken: token, email: email, password: password},
            success: function (data, textStatus, jqXHR) {
                if (data.code == 1) {
                    location.replace(data.url);
                }
                else {
                  $('#error_message_login').text(data.message).css('padding','10px');
                }
            },
            error:function(data,textStatus,jqXHR){
              alert("Login fail!.Please try again ")  ;
            },
            dataType: 'json'

        });
    });

});