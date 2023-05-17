@extends('client.layout.master')
@section('content')
    <!-- nội dung của trang  -->
    <section class="account-page my-3">
        <div class="container">
            <div class="page-content bg-white">
                <div class="account-page-tab-content m-4">
                    <!-- 2 tab: thông tin tài khoản, danh sách đơn hàng  -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-taikhoan-tab" data-toggle="tab" href="#nav-taikhoan"
                                role="tab" aria-controls="nav-home" aria-selected="true">Thông tin tài khoản</a>
                            <a class="nav-item nav-link" id="nav-donhang-tab" data-toggle="tab" href="#nav-donhang"
                                role="tab" aria-controls="nav-profile" aria-selected="false">Danh sách đơn hàng</a>
                            <a class="nav-item nav-link" id="nav-wishlist-tab" data-toggle="tab" href="#nav-wishlist"
                                role="tab" aria-controls="nav-wishlist" aria-selected="false">Sản phẩm yêu thích</a>
                        </div>
                    </nav>

                    <!-- nội dung 3 tab -->
                    <div class="tab-content">

                        <!-- nội dung tab 1: thông tin tài khoản  -->
                        <div class="tab-pane fade show active pl-4 " id="nav-taikhoan" role="tabpanel"
                            aria-labelledby="nav-taikhoan-tab">
                            <div class="offset-md-4 mt-3">
                                <h3 class="account-header">Thông tin tài khoản</h3>
                            </div>
                            <form action="" method="POST">

                                @csrf

                                <div class="hoten my-3">
                                    <div class="row">
                                        <label class="col-md-2 offset-md-2" for="name">Họ tên</label>
                                        <input class="col-md-4" type="text" name="name" value="{{ $user->name }}" required>
                                    </div>
                                </div>
                                <div class="email my-3">
                                    <div class="row">
                                        <label class="col-md-2 offset-md-2" for="email">Địa chỉ email</label>
                                        <input class="col-md-4" type="email" name="email" value="{{ $user->email }}" required>
                                    </div>
                                </div>
                                <div class="hoten my-3">
                                    <div class="row">
                                        <label class="col-md-2 offset-md-2" for="phone">Số điện thoại</label>
                                        <input class="col-md-4" type="tel" name="phone" value="{{ $user->phone }}" pattern="[0-9]{10}" required>
                                    </div>
                                </div>
                                <div class="checkbox-change-pass my-3">
                                    <div class="row">
                                        <input type="checkbox" name="changepass" id="changepass" class="offset-md-4"
                                            style="margin-top: 6px;margin-right: 5px; ">
                                        <label for="changepass">Thay đổi mật khẩu</label>
                                    </div>
                                </div>
                                <div class="thay-doi-mk">
                                    <div class="mkcu my-3">
                                        <div class="row">
                                            <label class="col-md-2 offset-md-2" for="oldpass">Mật khẩu cũ</label>
                                            <input class="col-md-4" type="password" name="oldpass" id="oldpass">
                                        </div>
                                    </div>
                                    <div class="mkmoi my-3">
                                        <div class="row">
                                            <label class="col-md-2 offset-md-2" for="newpass">Mật khẩu mới</label>
                                            <input class="col-md-4" type="password" name="newpass" id="newpass">
                                        </div>
                                    </div>
                                    <div class="xacnhan-mkmoi my-3">
                                        <div class="row">
                                            <label class="col-md-2 offset-md-2" for="confirmpass">Xác nhận mật
                                                khẩu</label>
                                            <input class="col-md-4" type="password" name="confirmpass" id="confirmpass">
                                        </div>
                                    </div>
                                    <div class="capnhat my-3">
                                        <div class="row">
                                            <button type="submit"
                                                class="button-capnhat text-uppercase offset-md-4 btn btn-warning mb-4">Cập
                                                nhật</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- nội dung tab 2: danh sách đơn hàng -->
                        <div class="tab-pane fade" id="nav-donhang" role="tabpanel" aria-labelledby="nav-donhang-tab">
                            <div class="donhang-table">
                                <table class="table m-auto">
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Mã khuyến mãi</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Địa chỉ nhận hàng</th>
                                        <th>Trạng thái</th>
                                        <th>Chức năng</th>
                                    </tr>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ number_format($order->total,-3,',',',') }} VND</td>
                                            <td>{{ !is_null($order->voucher_code) ? $order->voucher_code : 'Không có' }}</td>
                                            <td>{{ date('d/m/Y H:i:s',strtotime($order->created_at)) }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>
                                                @if ($order->status === 0)
                                                    {{ 'Chờ xác nhận' }}
                                                @elseif ($order->status === 1)
                                                    {{ 'Xác nhận' }}
                                                @elseif ($order->status === 2)
                                                    {{ 'Hoàn thành' }}
                                                @elseif ($order->status === 3)
                                                    {{ 'Hủy' }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('my.order.show',['id' => $order->id]) }}" class="btn btn-primary btn-circle btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <!-- nội dung tab 3: danh sách sản phẩm yêu thích -->
                        <div class="tab-pane fade" id="nav-wishlist" role="tabpanel" aria-labelledby="nav-wishlist-tab">
                            <div class="offset-md-4 mt-3">
                                <h3 class="account-header">Sản phẩm yêu thích</h3>
                            </div>
                            <div class="row">
                                @if ($wishlists->count() > 0)
                                    @foreach ($wishlists as $wishlist)
                                        @php
                                            $product = \App\Models\Product::find($wishlist->product_id);
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="card">
                                                <a href="{{ route('delete.wishlist', ['id' => $wishlist->id]) }}" onclick="return confirm('Bạn có muốn xóa sản phẩm yêu thích này ra khỏi danh sách ?')">
                                                    <i class="fa-solid fa-trash text-danger float-right mt-2 mr-2"></i>
                                                </a>
                                                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="motsanpham"
                                                    style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                                                    title="{{ $product->name }}">
                                                    <img class="card-img-top anh"
                                                        src="{{ asset($product->image->first()->url) }}"
                                                        alt="{{ $product->name }}">
                                                    <div class="card-body noidungsp mt-3">
                                                        <h3 class="card-title ten">{{ $product->name }}</h3>
                                                        <small class="tacgia text-muted">{{ \App\Models\Author::find($product->author_id)->name }}</small>
                                                        <div class="gia d-flex align-items-baseline">
                                                            @if (strtotime(date('Y-m-d')) < strtotime($product->start_date) || strtotime(date('Y-m-d')) > strtotime($product->end_date))
                                                                <div class="giamoi">{{ number_format($product->price,-3,',',',') }} VND</div>
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
                                @else
                                    <div class="col-md-12">Hiện chưa có sản phẩm nào</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('#oldpass').prop('disabled',true);
        $('#newpass').prop('disabled',true);
        $('#confirmpass').prop('disabled',true);
        $('#oldpass').prop('required',false);
        $('#newpass').prop('required',false);
        $('#confirmpass').prop('required',false);
        $('#changepass').change(function () {
            if (this.checked) {
                $('#oldpass').prop('disabled',false);
                $('#newpass').prop('disabled',false);
                $('#confirmpass').prop('disabled',false);
                $('#oldpass').prop('required',true);
                $('#newpass').prop('required',true);
                $('#confirmpass').prop('required',true);
            } else {
                $('#oldpass').prop('disabled',true);
                $('#newpass').prop('disabled',true);
                $('#confirmpass').prop('disabled',true);
                $('#oldpass').prop('required',false);
                $('#newpass').prop('required',false);
                $('#confirmpass').prop('required',false);
            }
        });
    </script>
@endsection
