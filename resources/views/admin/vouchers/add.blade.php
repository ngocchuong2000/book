@extends('admin.layouts.index')


@section('content')
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
<h1 class="h3 mb-2 text-gray-800">Thêm mã khuyến mãi</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('voucher.add') }}" method="POST" enctype="multipart/form-data">

            @csrf
            
            <div class="form-group">
                <label for="code">Mã khuyến mãi: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập mã khuyến mãi" id="code" name="code" required>
            </div>
            <div class="form-group">
                <label for="price">Mệnh giá: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Nhập mệnh giá" id="price" name="price" min=1 required>
            </div>
            <div class="form-group">
                <label for="qty">Số lượng: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Nhập số lượng" id="qty" name="qty" min=1 required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
          </form>
    </div>
</div>
@endsection