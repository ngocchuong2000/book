$(document).ready(function(){
        

    $(".comment-container").delegate(".reply","click",function(){
        var well = $(this).parent().parent();
        var cid = $(this).attr("cid");
        var name = $(this).attr('name_a');
        var token = $(this).attr('token');
        var form = '<form method="POST" action="/replies"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="name" value="'+name+'"><div class="col-lg-12"><textarea cols="60" rows="2" class="form-control mb-10" name="message" placeholder="Nhập phản hồi" required></textarea></div><button type="submit" class="btn btn-warning text-uppercase text-white ml-3">Phản hồi</button></form>';
        well.find(".reply-form").html(form);
    });

    $(".comment-container").delegate(".reply-to-reply","click",function(){
        var well = $(this).parent().parent();
        var cid = $(this).attr("rid");
        var rname = $(this).attr("rname");
        var token = $(this).attr("token")
        var form = '<form method="POST" action="/replies"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="name" value="'+rname+'"><div class="col-lg-12"><textarea cols="60" rows="2" class="form-control mb-10" name="message" placeholder="Nhập phản hồi" required></textarea></div><button type="submit" class="btn btn-warning text-uppercase text-white ml-3">Phản hồi</button></form>';
        well.find(".reply-to-reply-form").html(form);
    });

}); 