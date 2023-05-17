@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Sửa mật khẩu</h1>
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
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('staff.post.change.pass', ['id' => $staff->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label for="oldpassword">Mật khẩu hiện tại: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Nhập mật khẩu hiện tại" id="oldpassword" name="oldpassword" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Nhập mật khẩu mới" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="repassword">Xác nhận mật khẩu: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Xác nhận mật khẩu" id="repassword" name="repassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Sửa</button>
          </form>
    </div>
</div>
@endsection