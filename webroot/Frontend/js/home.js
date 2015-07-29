$(function () {
    
    function show() {
        var val = $('#modal-message').attr('check');
        if (val == 1) {
            $('#modal_notice').modal('show');
        }
    }
    show();
});
