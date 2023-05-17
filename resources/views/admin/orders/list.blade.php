@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Đơn hàng</h1>

@if(Session::has('invalid'))
    <div class="alert alert-danger alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('invalid')}}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get('success')}}
    </div>
@endif
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Mã khuyến mãi</th>
                        <th>Ngày đặt hàng</th>
                        <th>Địa chỉ nhận hàng</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ number_format($row->total,-3,',',',') }} VND</td>
                            <td>{{ !is_null($row->voucher_code) ? $row->voucher_code : 'Không có' }}</td>
                            <td>{{ date('d/m/Y H:i:s',strtotime($row->created_at)) }}</td>
                            <td>{{ $row->address }}</td>
                            <td>
                                @if ($row->status === 0)
                                    {{ 'Chờ xác nhận' }}
                                @elseif ($row->status === 1)
                                    {{ 'Xác nhận' }}
                                @elseif ($row->status === 2)
                                    {{ 'Hoàn thành' }}
                                @elseif ($row->status === 3)
                                    {{ 'Hủy' }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('order.show',['id' => $row->id]) }}" class="btn btn-primary btn-circle btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('order.print',['id' => $row->id]) }}" class="btn btn-warning btn-circle btn-sm" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
