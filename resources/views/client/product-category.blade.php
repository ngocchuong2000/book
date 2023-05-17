@extends('client.layout.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('client/css/product-item.css') }}">
@endsection

@section('content')
    <input type="hidden" id="category_id" value="{{ $category->id }}" />
    <!-- breadcrumb  -->
    <section class="breadcrumbbar">
        <div class="container">
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products', ['id' => $category->parent_category_id]) }}">{{ \App\Models\ParentCategory::find($category->parent_category_id)->name }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('product.category', ['id' => $category->id]) }}">{{ $category->name }}</a></li>
            </ol>
        </div>
    </section>

    <!-- các sản phẩm  -->
    <section class="content my-4">
        <div class="container">
            <div class="noidung bg-white" style=" width: 100%;">
                <!-- header của khối sản phẩm : tag(tác giả), bộ lọc và sắp xếp  -->
                <div class="header-khoi-sp d-flex">
                    <div class="tag">
                        <label>Tác giả nổi bật:</label>
                        <a href="javascript:void(0)" onclick="filterProductByAuthor(0, event);">Tất cả</a>
                        @foreach ($authors as $author)
                            <a href="javascript:void(0)" onclick="filterProductByAuthor({{ $author->id }}, event);">{{ $author->name }}</a>
                        @endforeach
                    </div>
                    <div class="sort d-flex ml-auto">
                        <div class="sap-xep">
                            <label for="sapxep-select" class="label-select">Sắp xếp</label>
                            <select class="sapxep-select" id="sort_price">
                                <option value="0">Mặc định</option>
                                <option value="1">Giá: Thấp - Cao</option>
                                <option value="2">Giá: Cao - Thấp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="items">
                    <div class="row" id="product_category">
                        @include('client.includes.product-category')
                    </div>
                </div>

                <!-- pagination bar  -->
                <div class="pagination-bar my-3">
                    <div class="row">
                        <div class="col-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>

                <!--het khoi san pham-->
            </div>
            <!--het div noidung-->
        </div>
        <!--het container-->
    </section>
@endsection
@section('js_footer')
    <script type="text/javascript" src="{{ asset('client/js/filter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('client/js/sort.js') }}"></script>
@endsection
