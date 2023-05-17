@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Chi tiết đơn hàng</h1>

<form method="POST" action="{{ route('order.edit', ['id' => $order->id]) }}" style="margin-bottom: 3rem;">
    @csrf
    <select name="status" class="status" style="padding:0.4rem 0;outline:none;">
        @if ($order->status === 0)
            <option value="0" selected>Chờ xác nhận</option>
            <option value="1">Xác nhận</option>
            <option value="3">Hủy đơn hàng</option>
        @elseif ($order->status === 1)
            <option value="1" selected>Xác nhận</option>
            <option value="2">Hoàn thành</option>
        @elseif ($order->status === 2)
            <option value="2" selected>Hoàn thành</option>
        @else
            <option value="3" selected>Hủy đơn hàng</option>
        @endif
    </select>
    @if (($order->status === 0) || ($order->status === 1))
    <button type="submit" class="btn btn-primary" name="submit">Cập nhật</button>
    @endif
</form>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders_detail as $row)
                        <tr class="even gradeC" align="center">
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->qty }}</td>
                            <td>{{ number_format((strtotime(date('Y-m-d')) < strtotime($row->start_date) || strtotime(date('Y-m-d')) > strtotime($row->end_date)) ? $row->price : $row->sale_price,-3,',',',') }} VND</td>
                            <td>{{ number_format((strtotime(date('Y-m-d')) < strtotime($row->start_date) || strtotime(date('Y-m-d')) > strtotime($row->end_date)) ? $row->price * $row->qty : $row->sale_price * $row->qty,-3,',',',') }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
