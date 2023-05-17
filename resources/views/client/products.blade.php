@extends('client.layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/product-item.css') }}">
@endsection

@section('content')
    <!-- breadcrumb  -->
    <section class="breadcrumbbar">
        <div class="container">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active"><a
                        href="{{ route('products', ['id' => $parentCategory->id]) }}">{{ $parentCategory->name }}</a>
                </li>
            </ol>
        </div>
    </section>

    <section class="page-content my-3">
        <div class="container">
            <div>
                <h1 class="header text-uppercase">{{ $parentCategory->name }}</h1>
            </div>
            <div class="the-loai-sach">
                <ul class="list-unstyled d-flex">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('product.category', ['id' => $category->id]) }}" class="danh-muc text-decoration-none">
                                <div class="img text-center">
                                    <img src="{{ asset($category->url) }}" alt="{{ $category->name }}">
                                </div>
                                <div class="ten">
                                    {{ $category->name }}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <!-- khối sản phẩm  -->
    <section class="content my-4">
        <div class="container">
            @foreach ($categories as $category)
                @php
                    $products = \App\Models\Product::where('category_id',$category->id)->orderBy('id', 'DESC')->paginate(12);
                @endphp
                @if ($products->count() > 0)
                    <div class="noidung bg-white" style=" width: 100%;">
                        <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-transparent pt-4">
                            <p class="header text-uppercase" style="font-size:20px">{{ $category->name }}</p>
                            <a href="{{ route('product.category', ['id' => $category->id]) }}" class="btn btn-warning btn-sm text-white">Xem tất cả</a>
                        </div>
                        <!-- các sản phẩm  -->
                        <div class="items">
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-lg-3 col-md-4 col-xs-6">
                                        <div class="card">
                                            <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="motsanpham"
                                                style="text-decoration: none; color: black;" data-toggle="tooltip"
                                                data-placement="bottom" title="{{ $product->name }}">
                                                <img class="card-img-top anh" src="{{ asset($product->image->first()->url) }}"
                                                    alt="{{ $product->name }}">
                                                <div class="card-body noidungsp mt-3 text-center">
                                                    <h6 class="card-title ten">{{ $product->name }}</h6>
                                                    <small class="tacgia text-muted">{{ \App\Models\Author::find($product->author_id)->name }}</small>
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- pagination bar -->
                        <div class="pagination-bar my-3">
                            <div class="row">
                                <div class="col-12">
                                </div>
                            </div>
                        </div>

                        <!--het khoi san pham-->
                    </div>
                @endif
            @endforeach
            <!--het div noidung-->
        </div>
        <!--het container-->
    </section>
    <!--het _1khoi-->
@endsection
