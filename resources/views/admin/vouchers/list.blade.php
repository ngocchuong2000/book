@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Mã khuyến mãi</h1>

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
                        <th>#</th>
                        <th>Mã khuyến mãi</th>
                        <th>Mệnh giá</th>
                        <th>Số lượng</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $voucher->code }}</td>
                            <td>{{ number_format($voucher->price,-3,',',',') }} VND</td>
                            <td>{{ $voucher->qty }}</td>
                            <td>
                                <a href="{{ route('voucher.delete',['id' => $voucher->code]) }}" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Bạn muốn xóa item này ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="{{ route('voucher.edit.form',['id' => $voucher->code]) }}" class="btn btn-primary btn-circle btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @php $count++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
