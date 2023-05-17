@extends('client.layout.master')

@section('css')
    <style>
        .shoping__checkout {
            background: #f5f5f5;
            padding: 30px;
            padding-top: 20px;
            margin-bottom: 10px;
            margin-right: 20px;
        }

        .shoping__checkout h5 {
            color: #1c1c1c;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 28px;
        }

        .shoping__checkout ul {
            margin-bottom: 28px;
        }

        .shoping__checkout ul li {
            font-size: 16px;
            color: #1c1c1c;
            font-weight: 700;
            list-style: none;
            overflow: hidden;
            border-bottom: 1px solid #ebebeb;
            padding-bottom: 13px;
            margin-bottom: 18px;
        }

        .shoping__checkout ul li:last-child {
            padding-bottom: 0;
            border-bottom: none;
            margin-bottom: 0;
        }

        .shoping__checkout ul li span {
            font-size: 18px;
            color: #dd2222;
            float: right;
        }

        .shoping__checkout .primary-btn {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    @php
    use App\Models\Cart;
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    @endphp
    <section class="content my-3">
        <div class="container">
            <div class="cart-page bg-white">
                <div class="row">
                    @if (!empty($cart->items))
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($cart->items as $row)
                                        <tr>
                                            @php
                                                $product = \App\Models\Product::find($row['item']['id']);
                                            @endphp
                                            <td>
                                                <img src="{{ asset($product->image->first()->url) }}"
                                                    alt="{{ $row['item']['name'] }}" width="100">
                                                <h5>{{ $row['item']['name'] }}</h5>
                                            </td>
                                            <td>
                                                @if (strtotime(date('Y-m-d')) < strtotime($row['item']['start_date']) || strtotime(date('Y-m-d')) > strtotime($row['item']['end_date']))
                                                    {{ number_format($row['item']['price'],-3,',',',') }} VND
                                                @else
                                                    {{ number_format($row['item']['sale_price'],-3,',',',') }} VND
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="text" value="{{ $row['qty'] }}"
                                                        style="width:50px;text-align:center;" onkeyup="changeQty(this.value, {{ $row['item']['id'] }})">
                                                </div>
                                            </td>
                                            <td id="cart-item-total-{{ $row['item']['id'] }}">
                                                @if (strtotime(date('Y-m-d')) < strtotime($row['item']['start_date']) || strtotime(date('Y-m-d')) > strtotime($row['item']['end_date']))
                                                    {{ number_format($row['item']['price'] * $row['qty'],-3,',',',') }} VND
                                                @else
                                                    {{ number_format($row['item']['sale_price'] * $row['qty'],-3,',',',') }} VND
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('delete.item', ['id' => $row['item']['id']]) }}">
                                                    Xóa
                                                </a>
                                            </td>
                                            @php
                                                $total += $row['price'];
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (!empty($cart->items))
                            <div class="col-2"></div>
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-4">
                                <div class="shoping__checkout">
                                    <ul>
                                        <li>Tổng tiền
                                            <span id="cart-total">{{ number_format($total, -3, ',', ',') }}
                                                VND</span></li>
                                    </ul>
                                    @if (Auth::check())
                                        <a href="{{ route('client.checkout') }}" class="primary-btn">THANH TOÁN</a>
                                    @else
                                        <a class="primary-btn text-center" href="#" data-toggle="modal"
                                            data-target="#formdangnhap">Đăng nhập</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- giao diện giỏ hàng khi không có item  -->
                        <div class="col-12 cart-empty">
                            <div class="py-3 pl-3">
                                <h6 class="header-gio-hang">GIỎ HÀNG CỦA BẠN <span>(0 sản phẩm)</span></h6>
                                <div class="cart-empty-content w-100 text-center justify-content-center">
                                    <img src="{{ asset('client/images/shopping-cart-not-product.png') }}"
                                        alt="shopping-cart-not-product">
                                    <p>Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                                    <a href="{{ route('client.home') }}" class="btn nutmuathem mb-3">Mua thêm</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- het row  -->
            </div>
            <!-- het cart-page  -->
        </div>
        <!-- het container  -->
    </section>
    <!-- het khoi content  -->
@endsection
@section('js_footer')
    <script type="text/javascript" src="{{ asset('client/js/cart.js') }}"></script>
@endsection
