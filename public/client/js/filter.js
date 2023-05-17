function filterProductByAuthor(id, e)
{
    var category_id = $('#category_id').val();
    $.ajax({
        url: '/filter',
        type: 'GET',
        data: {
            'id': id,
            'category_id': category_id
        },
        success: function(response) {
            if(response.status == 200) {
                $("#product_category").html(response.data);
            }
        }
    });
}