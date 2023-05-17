@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Chi tiết sản phẩm</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <th>Ảnh sản phẩm</th>
                    <td>
                        <div class="row">
                            @foreach($product->image as $item)
                                <div class="col-md-4">
                                    <img src="{{ asset($item->url) }}" width="200" height="200">
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Loại sản phẩm</th>
                    <td>{{ $product->type == 0 ? 'Sản phẩm thường' : 'Sản phẩm khuyến mãi' }}</td>
                </tr>
                <tr>
                    <th>Tên sản phẩm</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Giá tiền</th>
                    <td>
                        @php
                            if ($product->price != 0) {
                                echo number_format($product->price,-3,',',',') . ' VND';
                            } else {
                                echo 'N/A';
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th>Giá khuyến mãi</th>
                    <td>
                        @php
                            if ($product->sale_price != 0 && $product->type == 1) {
                                echo number_format($product->sale_price,-3,',',',') . ' VND';
                            } else {
                                echo 'N/A';
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th>Thời gian bắt đầu</th>
                    <td>
                        @php
                            if (!is_null($product->start_date) && $product->type == 1) {
                                echo date('d/m/Y', strtotime($product->start_date));
                            } else {
                                echo 'N/A';
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th>Thời gian kết thúc</th>
                    <td>
                        @php
                            if (!is_null($product->end_date) && $product->type == 1) {
                                echo date('d/m/Y', strtotime($product->end_date));
                            } else {
                                echo 'N/A';
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <th>Mô tả sản phẩm</th>
                    <td>{!! $product->description ?? 'Không có' !!}</td>
                </tr>
                <tr>
                    <th>Danh mục sản phẩm</th>
                    <td>{{ \App\Models\Category::find($product->category_id)->name }} (thuộc {{ \App\Models\ParentCategory::find(\App\Models\Category::find($product->category_id)->parent_category_id)->name }})</td>
                </tr>
                <tr>
                    <th>Hãng sản phẩm</th>
                    <td>{{ \App\Models\Brand::find($product->brand_id)->name }}</td>
                </tr>
                <tr>
                    <th>Tác giả</th>
                    <td>{{ \App\Models\Author::find($product->author_id)->name }}</td>
                </tr>
                <tr>
                    <th>Nhà xuất bản</th>
                    <td>{{ \App\Models\Supplier::find($product->supplier_id)->name }}</td>
                </tr>
                <tr>
                    <th>Số lượng</th>
                    <td>{{ $product->qty }}</td>
                </tr>
                <tr>
                    <th>Ngày xuất bản</th>
                    <td>{{ date('d/m/Y', strtotime($product->public_date)) ?? 'Chưa xác định' }}</td>
                </tr>
                <tr>
                    <th>Kích thước</th>
                    <td>{{ $product->size ?? 'Chưa xác định' }}</td>
                </tr>
                <tr>
                    <th>Hình thức bìa</th>
                    <td>{{ $product->cover ?? 'Chưa xác định' }}</td>
                </tr>
                <tr>
                    <th>Số trang</th>
                    <td>{{ $product->page }}</td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>{{ $product->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection