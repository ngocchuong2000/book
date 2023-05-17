@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Tài khoản</h1>

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
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <!-- <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot> -->
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->status == 1 ? 'Hoạt động' : 'Khóa' }}</td>
                            <td>
                                <a href="{{ route('customer.delete',['id' => $user->id]) }}" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Bạn muốn xóa item này ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                @if ($user->status == 1)
                                    <a href="{{ route('customer.disable',['id' => $user->id, 'status' => 0]) }}" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Bạn muốn khóa tài khoản này ?')">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                @else
                                    <a href="{{ route('customer.enable',['id' => $user->id, 'status' => 1]) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="fas fa-check"></i>
                                    </a>
                                @endif
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
