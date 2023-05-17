$(document).ready(function() {
    $("#sort_price").change(function () {
        var sort = $(this).val();
        var category_id = $('#category_id').val();
        $.ajax({
            url: '/sort',
            type: 'GET',
            data: {
                'sort': sort,
                'category_id': category_id
            },
            success: function(response) {
                if(response.status == 200) {
                    $("#product_category").html(response.data);
                }
            }
        });
    });
});