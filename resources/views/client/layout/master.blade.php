<!DOCTYPE html>
<html lang="vi">

<head>
    <title>{{ $setting->title }} - Mua sách trực tuyến giá rẻ nhất</title>
    <meta name="description"
        content="Mua sách online hay, giá tốt nhất, combo sách hot bán chạy, giảm giá cực khủng cùng với những ưu đãi như miễn phí giao hàng, quà tặng miễn phí, đổi trả nhanh chóng. Đa dạng sản phẩm, đáp ứng mọi nhu cầu.">
    <meta name="keywords" content="nhà sách online, mua sách hay, sách hot, sách bán chạy, sách giảm giá nhiều">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('client/css/home.css') }}">
    <script type="text/javascript" src="{{ asset('client/js/mains.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('client/fontawesome_free_5.13.0/css/all.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('client/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client/slick/slick-theme.css') }}" />
    <script type="text/javascript" src="{{ asset('client/slick/slick.min.js') }}"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js">
    </script>
    <meta name="google-site-verification" content="urDZLDaX8wQZ_-x8ztGIyHqwUQh2KRHvH9FhfoGtiEw" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('client/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('client/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('client/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('client/favicon_io/site.webmanifest') }}">
    <script type="text/javascript" src="{{ asset("vendor/sweetalert/sweetalert.all.js") }}"></script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('css')
    @yield('js')
</head>

<body>
    @include('sweetalert::alert')
    <!-- code cho nut like share facebook  -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0">
    </script>

    <!-- header -->
    <nav class="navbar navbar-expand-md bg-white navbar-light">
        <div class="container">
            <!-- logo  -->
            <a class="navbar-brand" href="{{ route('client.home') }}" style="color: #CF111A;"><b>{{ $setting->title }}</b></a>

            <!-- navbar-toggler  -->
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <!-- form tìm kiếm  -->
                <form class="form-inline ml-auto my-2 my-lg-0 mr-3" method="GET" action="{{ route('product.search') }}">
                    <div class="input-group" style="width: 520px;">
                        <input type="text" class="form-control" aria-label="Small"
                            placeholder="Nhập tên sách" name="q">
                        <select class="form-control" aria-label="Small" style="border: 2px solid #CF111A!important;" name="author">
                            <option value="">Tất cả tác giả</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" aria-label="Small" style="border: 2px solid #CF111A!important;" name="price">
                            <option value="">Tất cả mức giá</option>
                            <option value="1">0 - 50,000đ</option>
                            <option value="2">50,000đ - 100,000đ</option>
                            <option value="3">100,000đ - 150,000đ</option>
                            <option value="4">trên 150,000đ</option>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn"
                                style="background-color: #CF111A; color: white;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- ô đăng nhập đăng ký giỏ hàng trên header  -->
                <ul class="navbar-nav mb-1 ml-auto">
                    @if (!Auth::check())
                        @if (Auth::guard('admin')->check())
                            <li class="nav-item account" type="button">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary rounded-circle">
                                    <i class="fa fa-user"></i>
                                </a>
                                <a class="nav-link text-dark text-uppercase" href="{{ route('dashboard') }}" style="display:inline-block">{{ Auth::guard('admin')->user()->name }}</a>
                            </li>
                        @else
                            <div class="dropdown">
                                <li class="nav-item account" type="button" class="btn dropdown" data-toggle="dropdown">
                                    <a href="#" class="btn btn-secondary rounded-circle">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <a class="nav-link text-dark text-uppercase" href="#" style="display:inline-block">Tài
                                        khoản</a>
                                </li>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item nutdangky text-center mb-2" href="#" data-toggle="modal"
                                        data-target="#formdangky">Đăng ký</a>
                                    <a class="dropdown-item nutdangnhap text-center" href="#" data-toggle="modal"
                                        data-target="#formdangnhap">Đăng nhập</a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="dropdown">
                            <li class="nav-item account" type="button" class="btn dropdown" data-toggle="dropdown">
                                <a href="#" class="btn btn-secondary rounded-circle">
                                    <i class="fa fa-user"></i>
                                </a>
                                <a class="nav-link text-dark text-uppercase" href="#" style="display:inline-block">Xin chào, {{ Auth::user()->name }}</a>
                            </li>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item nutdangky text-center mb-2" href="{{ route('auth.change.account') }}">Thông tin cá nhân</a>
                                <a class="dropdown-item nutdangnhap text-center" href="{{ route('auth.logout') }}">Đăng xuất</a>
                            </div>
                        </div>
                    @endif
                    @if (!Auth::guard('admin')->check())
                        <li class="nav-item giohang">
                            <a href="{{ route('client.cart') }}" class="btn btn-secondary rounded-circle">
                                <i class="fa fa-shopping-cart"></i>
                                <div class="cart-amount">{{ Session::has('cart') ? Session::get('cart')->totalQty : 0 }}</div>
                            </a>
                            <a class="nav-link text-dark giohang text-uppercase" href="{{ route('client.cart') }}"
                                style="display:inline-block">Giỏ
                                Hàng</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <!-- form dang ky khi click vao button tren header-->
    <div class="modal fade mt-5" id="formdangky" data-backdrop="static" tabindex="-1" aria-labelledby="dangky_tieude"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="tabs d-flex justify-content-around list-unstyled mb-0">
                        <li class="tab tab-dangnhap text-center">
                            <a class=" text-decoration-none">Đăng nhập</a>
                            <hr>
                        </li>
                        <li class="tab tab-dangky text-center">
                            <a class="text-decoration-none">Đăng ký</a>
                            <hr>
                        </li>
                    </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-signup" class="form-signin mt-2" method="POST" action="{{ route('auth.post.register') }}">

                        @csrf

                        <div class="form-label-group">
                            <input type="text" class="form-control" placeholder="Nhập họ và tên" name="name" required
                                autofocus>
                        </div>
                        <div class="form-label-group">
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại" name="phone"
                                required>
                        </div>
                        <div class="form-label-group">
                            <input type="email" class="form-control" placeholder="Nhập địa chỉ email" name="email"
                                required>
                        </div>
                        <div class="form-label-group">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password"
                                required>
                        </div>
                        <div class="form-label-group mb-4">
                            <input type="password" class="form-control" name="repassword"
                                placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <button class="btn btn-lg btn-block btn-signin text-uppercase text-white mt-3" type="submit"
                            style="background: #F5A623">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- form dang nhap khi click vao button tren header-->
    <div class="modal fade mt-5" id="formdangnhap" data-backdrop="static" tabindex="-1"
        aria-labelledby="dangnhap_tieude" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="tabs d-flex justify-content-around list-unstyled mb-0">
                        <li class="tab tab-dangnhap text-center">
                            <a class=" text-decoration-none">Đăng nhập</a>
                            <hr>
                        </li>
                        <li class="tab tab-dangky text-center">
                            <a class="text-decoration-none">Đăng ký</a>
                            <hr>
                        </li>
                    </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-signin" class="form-signin mt-2" action="{{ route('auth.post.login') }}" method="POST">

                        @csrf
                        
                        <div class="form-label-group">
                            <input type="email" class="form-control" placeholder="Nhập địa chỉ email" name="email"
                                required autofocus>
                        </div>

                        <div class="form-label-group">
                            <input type="password" class="form-control" placeholder="Mật khẩu" name="password"
                                required>
                        </div>

                        <div class="form-label-group">
                            <a href="{{ route('auth.resetpass') }}">Quên mật khẩu</a>
                        </div>

                        <button class="btn btn-lg btn-block btn-signin text-uppercase text-white" type="submit"
                            style="background: #F5A623">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- thanh tieu de "danh muc sach" + hotline + ho tro truc tuyen -->
    <section class="duoinavbar">
        <div class="container text-white">
            <div class="row justify">
                <div class="col-md-3">
                    <div class="categoryheader">
                        <div class="noidungheader text-white">
                            <i class="fa fa-bars"></i>
                            <span class="text-uppercase font-weight-bold ml-1">Danh mục sách</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="benphai float-right">
                        <div class="hotline">
                            <i class="fa fa-phone"></i>
                            <span>Hotline:<b>{{ $setting->tel }}</b> </span>
                        </div>
                        <div class="hotline">
                            <i class="fa fa-envelope" aria-hidden="true"></i> Email:
                            <a href="#">{{ $setting->email }} </a>
                        </div>
                        <i class="fa fa-map-marker" aria-hidden="true"></i> Địa chỉ:
                        <a href="#">{{ $setting->address }} </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- noi dung danh muc sach(categories) + banner slider -->
    <section class="header bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3" style="margin-right: -15px;">
                    <!-- CATEGORIES -->
                    <div class="categorycontent">
                        <ul>
                            @foreach ($parentCategories as $parentCategory)
                                <li><a href="{{ route('products', ['id' => $parentCategory->id]) }}">{{ $parentCategory->name }}</a><i
                                    class="fa fa-chevron-right float-right"></i>
                                    <ul>
                                        <li class="liheader"><a href="#" class="header text-uppercase">{{ $parentCategory->name }}</a></li>
                                        <div class="content trai">
                                            @foreach (\App\Models\Category::where('parent_category_id', $parentCategory->id)->limit(9)->get() as $category)
                                                <li><a href="{{ route('product.category', ['id' => $category->id]) }}">{{ $category->name }}</a></li>
                                            @endforeach
                                        </div>
                                        <div class="content phai">
                                            @foreach (\App\Models\Category::where('parent_category_id', $parentCategory->id)->skip(9)->limit(9)->get() as $category)
                                                <li><a href="{{ route('product.category', ['id' => $category->id]) }}">{{ $category->name }}</a></li>
                                            @endforeach
                                        </div>
                                    </ul>
                                </li> 
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- banner slider  -->
                <div class="col-md-9 px-0">
                    <div id="carouselId" class="carousel slide" data-ride="carousel">
                        <ol class="nutcarousel carousel-indicators rounded-circle">
                            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselId" data-slide-to="1"></li>
                            <li data-target="#carouselId" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="#"><img src="{{ asset('client/images/banner-sach-moi.jpg') }}"
                                        class="img-fluid" style="height: 386px;" width="900px"
                                        alt="First slide"></a>
                            </div>
                            <div class="carousel-item">
                                <a href="#"><img src="{{ asset('client/images/banner-beethoven.jpg') }}"
                                        class="img-fluid" style="height: 386px;" width="900px"
                                        alt="Second slide"></a>
                            </div>
                            <div class="carousel-item">
                                <a href="#"><img src="{{ asset('client/images/neu-toi-biet-duoc-khi-20-full-banner.jpg') }}"
                                        class="img-fluid" style="height: 386px;" alt="Third slide"></a>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselId" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselId" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @yield('content')
    
    <!-- thanh cac dich vu :mien phi giao hang, qua tang mien phi ........ -->
    <section class="abovefooter text-white" style="background-color: #CF111A;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{ asset('client/images/icon-books.png') }}" alt="icon-books">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">HƠN 14.000 TỰA SÁCH HAY</h3>
                            <p class="detail">Tuyển chọn bởi DealBooks</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{ asset('client/images/icon-ship.png') }}" alt="icon-ship">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">MIỄN PHÍ GIAO HÀNG</h3>
                            <p class="detail">Từ 150.000đ ở TP.HCM</p>
                            <p class="detail">Từ 300.000đ ở tỉnh thành khác</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{ asset('client/images/icon-gift.png') }}" alt="icon-gift">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">QUÀ TẶNG MIỄN PHÍ</h3>
                            <p class="detail">Tặng Bookmark</p>
                            <p class="detail">Bao sách miễn phí</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{ asset('client/images/icon-return.png') }}" alt="icon-return">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">ĐỔI TRẢ NHANH CHÓNG</h3>
                            <p class="detail">Hàng bị lỗi được đổi trả nhanh chóng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="gioithieu">
                        <h3 class="header text-uppercase font-weight-bold">Về DealBook</h3>
                        <a href="#">Giới thiệu về DealBook</a>
                        <a href="#">Tuyển dụng</a>
                        <div class="fb-like" data-href="https://www.facebook.com/DealBook-110745443947730/"
                            data-width="300px" data-layout="button" data-action="like" data-size="small"
                            data-share="true"></div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="hotrokh">
                        <h3 class="header text-uppercase font-weight-bold">HỖ TRỢ KHÁCH HÀNG</h3>
                        <a href="#">Hướng dẫn đặt hàng</a>
                        <a href="#">Phương thức thanh toán</a>
                        <a href="#">Phương thức vận chuyển</a>
                        <a href="#">Chính sách đổi trả</a>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="lienket">
                        <h3 class="header text-uppercase font-weight-bold">HỢP TÁC VÀ LIÊN KẾT</h3>
                        <img src="{{ asset('client/images/dang-ky-bo-cong-thuong.png') }}"
                            alt="dang-ky-bo-cong-thuong">
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="ptthanhtoan">
                        <h3 class="header text-uppercase font-weight-bold">Phương thức thanh toán</h3>
                        <img src="{{ asset('client/images/visa-payment.jpg') }}" alt="visa-payment">
                        <img src="{{ asset('client/images/master-card-payment.jpg') }}" alt="master-card-payment">
                        <img src="{{ asset('client/images/jcb-payment.jpg') }}" alt="jcb-payment">
                        <img src="{{ asset('client/images/atm-payment.jpg') }}" alt="atm-payment">
                        <img src="{{ asset('client/images/cod-payment.jpg') }}" alt="cod-payment">
                        <img src="{{ asset('client/images/payoo-payment.jpg') }}" alt="payoo-payment">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- nut cuon len dau trang -->
    <div class="fixed-bottom">
        <div class="btn btn-warning float-right rounded-circle nutcuonlen" id="backtotop" href="#"
            style="background:#CF111A;"><i class="fa fa-chevron-up text-white"></i></div>
    </div>

    <script type="text/javascript" src="{{ asset('client/js/add-to-cart.js') }}"></script>
    @yield('js_footer')
</body>

</html>
