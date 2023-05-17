function remove_background(product_id) {
    for (let count = 1;count <= 5;count++) {
        $('#'+product_id+'-'+count).css('color','#ccc');
    }
}
// hover chuột đánh giá sao
$(document).on('mouseenter','.rating', function(){
    var index = $(this).data('index');
    var product_id = $(this).data('product_id');
    remove_background(product_id);
    for (let count = 1;count <= index;count++) {
        $('#'+product_id+'-'+count).css('color','#ffcc00');
    }
});
// nhả chuột không đánh giá
$(document).on('mouseleave','.rating', function(){
    var product_id = $(this).data('product_id');
    var rating = $(this).data('rating');
    remove_background(product_id);
    for (let count = 1;count <= rating;count++) {
        $('#'+product_id+'-'+count).css('color','#ffcc00');
    }
});
// click đánh giá sao
$(document).on('click','.rating', function(){
    var index = $(this).data('index');
    var product_id = $(this).data('product_id');
    $.ajax({
        type:'POST',
        url:'/rating',
        data: {
            index:index,
            product_id:product_id
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(res){
           if (res.status == 200) {
                swal({
                    title: "Success",
                    text: "Cảm ơn bạn đã đánh giá sản phẩm của chúng tôi",
                    type: "success"
                }).then(function() {
                    window.location = window.location.href;
                });
           } else {
                swal({ title: 'Vui lòng đăng nhập trước khi đánh giá', type: 'error' });
           }
        }
    });
});