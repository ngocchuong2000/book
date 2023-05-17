@extends('client.layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/product-item.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/comment.css') }}">
    <style>
        .list-inline-rating {
            display: flex;
            list-style-type: none;
        }

        .fa-heart {
            font-size: 25px;
            cursor: pointer;
        }

        .like {
            color: black;
        }

        .like:hover {
            color: red;
        }

        .dislike {
            color: red;
        }

        .dislike:hover {
            color: black;
        }
    </style>
@endsection

@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumbbar">
        <div class="container">
            <div class="container">
                <ol class="breadcrumb mb-0 p-0 bg-transparent">
                    <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('product.category', ['id' => $product->category_id]) }}">{{ \App\Models\Category::find($product->category_id)->name }}</a>
                    </li>
                    <li class="breadcrumb-item active"><a
                            href="{{ route('product.detail', ['id' => $product->id]) }}">{{ $product->name }}</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- nội dung của trang  -->
    <section class="product-page mb-4">
        <div class="container">
            <!-- chi tiết 1 sản phẩm -->
            <div class="product-detail bg-white p-4">
                <div class="row">
                    <!-- ảnh  -->
                    <div class="col-md-5 khoianh">
                        <div class="anhto mb-4">
                            <a class="active" href="{{ asset($product->image->first()->url) }}"
                                data-fancybox="thumb-img">
                                <img class="product-image" src="{{ asset($product->image->first()->url) }}"
                                    alt="{{ $product->name }}" style="width: 100%;">
                            </a>
                            <a href="{{ asset($product->image->first()->url) }}" data-fancybox="thumb-img"></a>
                        </div>
                        <div class="list-anhchitiet d-flex mb-4" style="margin-left: 2rem;">
                            @foreach ($product->image as $item)
                                <img class="thumb-img thumb1 mr-3" src="{{ asset($item->url) }}" class="img-fluid">
                            @endforeach
                        </div>
                    </div>
                    <!-- thông tin sản phẩm: tên, giá bìa giá bán tiết kiệm, các khuyến mãi, nút chọn mua.... -->
                    <div class="col-md-7 khoithongtin">
                        <div class="row">
                            <div class="col-md-12 header">
                                @if (Auth::check())
                                    @if (!\App\Models\Wishlist::where([['user_id', Auth::user()->id], ['product_id', $product->id]])->exists())
                                        <i class="fa-solid fa-heart float-right like" id="wishlist-{{ $product->id }}" onclick="addWishlist({{ $product->id }})"></i>
                                    @else
                                        <i class="fa-solid fa-heart float-right dislike" id="wishlist-{{ $product->id }}" onclick="addWishlist({{ $product->id }})"></i>
                                    @endif
                                @endif
                                <h4 class="ten">{{ $product->name }}</h4>
                                <ul class="list-inline-rating" style="margin-bottom: 0 !important;">
                                    @for ($count = 1; $count <= 5; $count++)
                                        @php
                                            if ($count <= $rating) {
                                                $color = 'color:#ffcc00;';
                                            } else {
                                                $color = 'color:#ccc;';
                                            }
                                        @endphp
                                        <li id="{{ $product->id }}-{{ $count }}"
                                            data-index="{{ $count }}" data-product_id="{{ $product->id }}"
                                            data-rating="{{ $rating }}" class="rating"
                                            style="cursor:pointer;{{ $color }}font-size:30px">&#9733;</li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-md-7">
                                <div class="gia">
                                    @if (strtotime(date('Y-m-d')) < strtotime($product->start_date) || strtotime(date('Y-m-d')) > strtotime($product->end_date))
                                        <div class="giaban text-danger" style="font-size: 20px;">Giá bán:
                                            {{ number_format($product->price, -3, ',', ',') }} VND</div>
                                    @else 
                                        <div class="giaban text-danger" style="font-size: 20px;">Giá bán:
                                            {{ number_format($product->sale_price, -3, ',', ',') }} VND</div>
                                        <small class="text-secondary"><del>{{ number_format($product->price,-3,',',',') }} VND</del></small>
                                    @endif
                                </div>
                                <div class="ton">
                                    <div  >Hàng hiện có:
                                        {{ $product->qty }} </div>
                                </div>
                                <div class="soluong d-flex">
                                    <label class="font-weight-bold">Số lượng: </label>
                                    <div class="input-number input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text btn-spin btn-dec">-</span>
                                        </div>
                                        <input type="text" value="1" class="soluongsp  text-center" id="qty">
                                        <div class="input-group-append">
                                            <span class="input-group-text btn-spin btn-inc">+</span>
                                        </div>
                                    </div>
                                </div>
                                @if (!Auth::guard('admin')->check())
                                    <div class="nutmua btn w-100 text-uppercase" onclick="addToCart({{ $product->id }})">Thêm
                                        giỏ hàng</div>
                                @endif
                            </div>
                            <!-- thông tin khác của sản phẩm:  tác giả, ngày xuất bản, kích thước ....  -->
                            <div class="col-md-5">x
                                <div class="thongtinsach">
                                    <ul>
                                        <li>Tác giả: <a href="javascript:void(0)"
                                                class="tacgia">{{ \App\Models\Author::find($product->author_id)->name }}</a>
                                        </li>
                                        @if ($product->public_date)
                                            <li>Ngày xuất bản:
                                                <b>{{ date('d/m/Y', strtotime($product->public_date)) }}</b></li>
                                        @endif
                                        <li>Hãng sách: {{ \App\Models\Brand::find($product->brand_id)->name }}</li>
                                        @if ($product->size)
                                            <li>Kích thước: <b>{{ $product->size }}</b></li>
                                        @endif
                                        <li>Nhà xuất bản: {{ \App\Models\Supplier::find($product->supplier_id)->name }}
                                        </li>
                                        @if ($product->cover)
                                            <li>Hình thức bìa: <b>{{ $product->cover }}</b></li>
                                        @endif
                                        @if ($product->page)
                                            <li>Số trang: <b>{{ $product->page }}</b></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- decripstion của 1 sản phẩm: giới thiệu , đánh giá độc giả  -->
                    <div class="product-description col-md-9">
                        <!-- 2 tab ở trên  -->
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active text-uppercase" id="nav-gioithieu-tab" data-toggle="tab"
                                    href="#nav-gioithieu" role="tab" aria-controls="nav-gioithieu" aria-selected="true">Giới
                                    thiệu</a>
                            </div>
                        </nav>
                        <!-- nội dung của từng tab  -->
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active ml-3" id="nav-gioithieu" role="tabpanel"
                                aria-labelledby="nav-gioithieu-tab">
                                <h6 class="tieude font-weight-bold">{{ $product->name }}</h6>
                                {!! $product->description !!}
                            </div>
                            <!-- het tab nav-danhgia  -->
                        </div>
                        <!-- het tab-content  -->
                    </div>
                    <!-- het product-description -->
                    <!-- Start comment-sec Area -->
                    <div class="col-md-12">
                        <section class="comment-sec-area pt-80 pb-80">
                            <div class="container">
                                <div class="row flex-column">
                                    <h5 class="text-uppercase pb-80">{{ $comments->count() }} bình luận</h5>
                                    <br />
                                    <div class="comment">
                                        @foreach ($comments as $comment)
                                            <div class="comment-list comment-container">
                                                <div class="single-comment justify-content-between d-flex">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb">
                                                            <img src="{{ asset('client/images/people.png') }}" alt="Avatar"
                                                                width="50px">
                                                        </div>
                                                        <div class="desc mb-4">
                                                            <h5><a href="javascript:void(0)">{{ $comment->name }}</a></h5>
                                                            <p class="date">
                                                                {{ date('d/m/Y H:i:s', strtotime($comment->created_at)) }}
                                                            </p>
                                                            <p class="comment">
                                                                {{ $comment->content }}
                                                            </p>
                                                            @if (Auth::check() || Auth::guard('admin')->check())
                                                                <a class="text-primary reply" cid="{{ $comment->id }}"
                                                                    name_a="{{ Auth::check() ? Auth::user()->name : Auth::guard('admin')->user()->name }}"
                                                                    token="{{ csrf_token() }}">Phản hồi</a>
                                                                <div class="row flex-row d-flex reply-form"></div>
                                                            @endif
                                                            <!-- show reply -->
                                                            @foreach ($replies as $reply)
                                                                @if ($reply->comment_id === $comment->id)
                                                                    <div class="comment-list left-padding">
                                                                        <div
                                                                            class="single-comment justify-content-between d-flex mt-4 mb-4">
                                                                            <div class="user justify-content-between d-flex">
                                                                                <div class="thumb">
                                                                                    <img src="{{ asset('client/images/people.png') }}"
                                                                                        alt="Avatar" width="50px" />
                                                                                </div>
                                                                                <div class="desc">
                                                                                    <h5><a
                                                                                            href="javascript:void(0)">{{ $reply->name }}</a>
                                                                                    </h5>
                                                                                    <p class="date">
                                                                                        {{ date('d/m/Y H:i:s', strtotime($reply->created_at)) }}
                                                                                    </p>
                                                                                    <p class="comment">
                                                                                        {{ $reply->content }}
                                                                                    </p>
                                                                                    @if (Auth::check() || Auth::guard('admin')->check())
                                                                                        <a class="text-primary reply-to-reply"
                                                                                            rid="{{ $reply->comment_id }}"
                                                                                            rname="{{ Auth::check() ? Auth::user()->name : Auth::guard('admin')->user()->name }}"
                                                                                            token="{{ csrf_token() }}">Phản
                                                                                            hồi</a>
                                                                                        <div
                                                                                            class="row flex-row d-flex reply-to-reply-form">
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            <!-- end reply -->
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- End comment-sec Area -->

                        <!-- Start commentform Area -->
                        @if (Auth::check())
                            <section class="commentform-area pb-120 pt-80 mb-100">
                                <div class="container">
                                    <h5 class="text-uppercas pb-50">Bình luận</h5>
                                    <div class="row flex-row d-flex">
                                        <div class="col-lg-12">
                                            <form action="{{ route('add.comment') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                <textarea class="form-control mb-10" name="message" cols="5" rows="4" placeholder="Nhập bình luận" required></textarea>
                                                <button type="submit" class="button-capnhat text-uppercase btn btn-warning mb-4 text-white" href="#">Bình luận</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                        <!-- End commentform Area -->
                    </div>
                </div>
                <!-- het row  -->
            </div>
            <!-- het product-detail -->
        </div>
        <!-- het container  -->
    </section>
    <!-- het product-page -->

    <!-- khối sản phẩm tương tự -->
    <section class="_1khoi sachmoi">
        <div class="container">
            <div class="noidung bg-white" style=" width: 100%;">
                <div class="row">
                    <!--header-->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-light pt-4">
                        <h5 class="header text-uppercase" style="font-weight: 400;">Sản phẩm liên quan</h5>
                        <a href="{{ route('product.category', ['id' => $product->category_id]) }}"
                            class="btn btn-warning btn-sm text-white">Xem tất cả</a>
                    </div>
                </div>
                <div class="khoisanpham" style="padding-bottom: 2rem;">
                    @foreach (\App\Models\Product::where('category_id', $product->category_id)->where('id', '<>', $product->id)->orderBy('id', 'DESC')->get()
        as $product)
                        <!-- 1 sản phẩm -->
                        <div class="card">
                            <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="motsanpham"
                                style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                                title="{{ $product->name }}">
                                <img class="card-img-top anh" src="{{ asset($product->image->first()->url) }}"
                                    alt="{{ $product->name }}">
                                <div class="card-body noidungsp mt-3 text-center">
                                    <h6 class="card-title ten">{{ $product->name }}</h6>
                                    <small
                                        class="tacgia text-muted">{{ \App\Models\Author::find($product->author_id)->name }}</small>
                                    <div class="gia">
                                        @if (strtotime(date('Y-m-d')) < strtotime($product->start_date) || strtotime(date('Y-m-d')) > strtotime($product->end_date))
                                            <div class="giamoi text-center">{{ number_format($product->price, -3, ',', ',') }}
                                                VND</div>
                                        @else 
                                            <div class="giamoi">{{ number_format($product->sale_price,-3,',',',') }} VND</div>
                                            <small class="text-secondary"><del>{{ number_format($product->price,-3,',',',') }} VND</del></small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js_footer')
    <script type="text/javascript" src="{{ asset('client/js/rating.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/js/comment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/js/wishlist.js') }}"></script>
@endsection
