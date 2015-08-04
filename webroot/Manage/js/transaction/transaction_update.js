function changeData(url) {
    $('#catalog-id').change(function () {
        var token = $('input[name="_csrfToken"]').val();
        $.ajax({
            url: url,
            type: "post",
            data: {_csrfToken: token,catalogId: $(this).val()},
            success: function (data) {
                if(data.code===2){
                    $('#category-id').empty();
                    result=data.data;
                    for(i=0; i<result.length;i++){
                     $('#category-id').append('<option value="'+result[i].id+'">'+result[i].name+'</option>');  
                    }
                }else{
                    alert("Data invalid");
                }
            },
            error:function(data){
              alert("Connect to Server fail.Please try again !");  
            },
            dataType: 'json'
        });
    });
}
 var amount = $('#amount').val();
 // ser value for amount 
$('#amount').val(amount.replace(/\B(?=(\d{3})+(?!\d))/g, "."));
$('#created-at').datepicker({dateFormat:'yy-mm-dd'});
