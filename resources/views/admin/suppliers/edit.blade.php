@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Sửa nhà xuất bản</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('supplier.edit', ['id' => $supplier->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="form-group">
                <label for="name">Tên nhà xuất bản: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tên nhà xuất bản" id="name" name="name" value="{{ $supplier->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Sửa</button>
          </form>
    </div>
</div>
@endsection