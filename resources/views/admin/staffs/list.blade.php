@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Nhân viên</h1>

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
                        <th>Tên nhân viên</th>
                        <th>Email</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <!-- <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tên nhân viên</th>
                        <th>Email</th>
                        <th>Chức năng</th>
                    </tr>
                </tfoot> -->
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($staffs as $staff)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>
                                <a href="{{ route('staff.delete',['id' => $staff->id]) }}" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Bạn muốn xóa item này ?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <a href="{{ route('staff.edit.form',['id' => $staff->id]) }}" class="btn btn-primary btn-circle btn-sm">
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
