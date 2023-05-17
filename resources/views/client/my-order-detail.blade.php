@extends('client.layout.master')
@section('content')
    <!-- nội dung của trang  -->
    <section class="account-page my-3">
        <div class="container">
            <div class="page-content bg-white">
                <div class="account-page-tab-content m-4">
                    <nav>
                        <div class="nav nav-tabs">
                            <a class="nav-item nav-link active">Chi tiết đơn hàng</a>
                        </div>
                    </nav>
                    <div class="donhang-table">
                        <table class="table m-auto">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                            @foreach ($orders_detail as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ number_format((strtotime(date('Y-m-d')) < strtotime($row->start_date) || strtotime(date('Y-m-d')) > strtotime($row->end_date)) ? $row->price : $row->sale_price,-3,',',',') }} VND</td>
                                    <td>{{ number_format((strtotime(date('Y-m-d')) < strtotime($row->start_date) || strtotime(date('Y-m-d')) > strtotime($row->end_date)) ? $row->price * $row->qty : $row->sale_price * $row->qty,-3,',',',') }} VND</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
