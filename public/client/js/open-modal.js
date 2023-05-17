$(document).ready(function() {
    $('.btn-open-modal').click(function() {
        var productId = $(this).data('product-id');
        $.ajax({
            url: `/get-product/${productId}`,
            type: 'GET',
            success: function(response) {
                if(response.status == 200) {
                    var html = `
                        <div class="row">
                            <div class="col-md-6">
                                <img src="${response.image}" width="100%" />
                            </div>
                            <div class="col-md-6">
                                <h5><a href="/product-detail/${response.product.id}" class="product-name">${response.product.name}</a></h5>
                                <h4 class="text-danger">${response.product.price.toLocaleString('it-IT', {style : 'currency', currency : 'VND'})}</h3>
                                ${response.product.description ?? ''}
                                <input type="hidden" id="qty" value="1" />
                                <a class="nutmua btn w-100 text-uppercase" href="javascript:void(0)" onclick="addToCart(${response.product.id})">Thêm giỏ hàng</a>
                            </div>
                        </div>
                    `;
                    $('#product-content').html(html);
                    $('#productModal').modal('show');
                }
            }
        });
    });
});