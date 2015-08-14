$(function () {

    var walletFrom = $('#wallet_from').val();
    $('#wallet_to option[value="' + walletFrom + '"]').remove();
    $('#wallet_from').change(function () {
        var walletFromChange = $(this).val();
        var child =$(this).html();
        $('#wallet_to').empty();
        $('#wallet_to').append(child);        
        $('#wallet_to option[value="' + walletFromChange + '"]').remove();
    });


});
