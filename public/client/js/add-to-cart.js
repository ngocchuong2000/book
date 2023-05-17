function addToCart(id) {
    var qty = document.getElementById('qty').value;
    $.ajax({
        url: '/add-to-cart',
        type: 'GET',
        data: {
            'id': id,
            'qty': qty
        },
        success: function(response) {
            if(response.status == 200) {
                $(".cart-amount").html(response.qty);
                swal({ title: 'Thêm giỏ hàng thành công', type: 'success' });
            } else {
                swal({ title: response.title, type: 'error' });
            }
        }
    });
}