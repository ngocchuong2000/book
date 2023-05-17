function addWishlist(id) {
    $.ajax({
        url: '/add-wishlist',
        type: 'GET',
        data: {
            'id': id
        },
        success: function(response) {
            if(response.status == 200) {
                if (response.exist) {
                    $(`#wishlist-${id}`).removeClass('dislike');
                    $(`#wishlist-${id}`).addClass('like');
                } else {
                    $(`#wishlist-${id}`).removeClass('like');
                    $(`#wishlist-${id}`).addClass('dislike');
                }
            } else {
                swal({ title: response.title, type: 'error' });
            }
        }
    });
}