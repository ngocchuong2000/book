@extends('client.layout.master')

@section('css')
<style>
    .checkout__order .checkout__order__products {
        font-size: 18px;
        color: #1c1c1c;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .checkout__order .checkout__order__products span {
        float: right;
    }
    .checkout__order .checkout__order__total {
        font-size: 18px;
        color: #1c1c1c;
        font-weight: 700;
        border-top: 1px solid #e1e1e1;
        padding-top:10px;
    }

    .checkout__order .checkout__order__total span {
        float: right;
    }

    .checkout__order__products-item {
        font-size: 15px;
        color: #1c1c1c;
        margin-bottom: 10px;
    }

    .checkout__order__products-item span {
        float: right;
    }
</style>
@endsection

@section('content')
    <!-- nội dung của trang  -->
    <section class="account-page my-3">
        <div class="container">
            <div class="page-content bg-white">
                <div class="account-page-tab-content m-4">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-thanhtoan-tab" data-toggle="tab" href="#nav-thanhtoan"
                                role="tab" aria-controls="nav-home" aria-selected="true">Thanh toán</a>
                        </div>
                    </nav>

                    <div class="tab-content">
                        <div class="tab-pane fade show active pl-4 " id="nav-thanhtoan" role="tabpanel"
                            aria-labelledby="nav-thanhtoan-tab">
                            <div class="row">
                                <div class="col-lg-9 col-md-6">
                                    <div class="offset-md-4 mt-3">
                                        <h3 class="account-header text-center">Thanh toán</h3>
                                    </div>
                                    <form action="{{ route('pay') }}" method="POST" id="checkout-form">

                                        @csrf
        
                                        <div class="hoten my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="name">Họ tên</label>
                                                <input class="col-md-6" type="text" name="name" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="email my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="email">Địa chỉ email</label>
                                                <input class="col-md-6" type="email" name="email" value="{{ Auth::user()->email }}" readonly>
                                            </div>
                                        </div>
                                        <div class="hoten my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="phone">Số điện thoại</label>
                                                <input class="col-md-6" type="tel" name="phone" value="{{ Auth::user()->phone }}" pattern="[0-9]{10}" readonly>
                                            </div>
                                        </div>
                                        <div class="hoten my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="address">Địa chỉ nhận hàng</label>
                                                <input class="col-md-6" type="text" name="address" required>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="capnhat my-3">
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <button type="submit"
                                                        class="button-capnhat text-uppercase offset-md-4 btn btn-warning mb-4 text-white" name="btnSubmit">Thanh toán</button>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="checkout__order">
                                        <div class="mt-3">
                                            <h3 class="account-header">Chi tiết đơn hàng</h3>
                                        </div>
                                        <div class="checkout__order__products">Sản phẩm <span>Tổng tiền</span></div>
                                        @php
                                            use App\Models\Cart;
                                            $oldCart = Session::get('cart');
                                            $cart = new Cart($oldCart);
                                            $total = 0;
                                        @endphp
                                        @foreach ($cart->items as $row)
                                        @php
                                            $total += $row['price'];
                                        @endphp
                                            <div class="checkout__order__products-item">{{ strlen($row['item']['name']) > 25 ? substr($row['item']['name'], 0, 25) . '...' : $row['item']['name'] }}<span>{{ number_format($row['price'],-3,',',',') }} VND</span></div>
                                        @endforeach
                                        <div class="checkout__order__total text-danger">Thành tiền <span class="total-cart">{{ number_format($total,-3,',',',') }} VND</span></div>
                                        <input type="hidden" id="total" name="total" value="{{ $total }}" />
                                        <input type="text" class="form-control mt-2" placeholder="Nhập voucher của bạn" id="voucher" />
                                        <button type="button" id="voucher-add" class="btn btn-primary btn-sm mt-3">KIỂM TRA MÃ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js_footer')
    <script type="text/javascript" src="{{ asset('client/js/voucher.js') }}"></script>
@endsection
