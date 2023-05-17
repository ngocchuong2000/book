$(document).ready(function() {
    $("#voucher-add").click(function() {
        var code = $("#voucher").val();
        var total = $("#total").val();
        $.ajax({
            url: "/check-voucher",
            type: 'GET',
            data: {
                code:code,
                total:total
            },
            beforeSend: function(xhr) {
              xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            }
        }).done(function(res){
            var total = parseInt(res.total).toLocaleString('it-IT', {style : 'currency', currency : 'VND'});
            if(res.status == 200) {
                $('.total-cart').html(total);
                $('#checkout-form').prepend($('<input type="hidden" name="voucher" />').val(res.code));
            }else {
                $('.total-cart').html(total);
                swal({ title: res.msg, type: 'error' });
            }
            $('#voucher').val('');
        });
    });
});
