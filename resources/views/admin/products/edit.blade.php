@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Sửa sửa phẩm</h1>

<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('product.edit',['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="type">Loại sản phẩm: <span class="text-danger">*</span></label>
                <select class="form-control" name="type" id="type">
                    <option value="0" {{ $product->type == 0 ? 'selected' : '' }}>Sản phẩm thường</option>
                    <option value="1" {{ $product->type == 1 ? 'selected' : '' }}>Sản phẩm khuyến mãi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tên sản phẩm: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" id="name" name="name" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="price">Giá tiền: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Nhập giá tiền" id="price" name="price" value="{{ $product->price }}" min=1 required>
            </div>
            <div id="product_sale_container">
                @if ($product->type == 1)
                    <div class="form-group" id="price_sale_container">
                        <label for="price_sale">Giá khuyến mãi: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Nhập giá tiền" id="price_sale" name="price_sale" value="{{ $product->sale_price != 0 ? $product->sale_price : '' }}" min=1 required>
                    </div>
                    <div class="form-group" id="start_date_container">
                        <label for="start_date">Thời gian bắt đầu: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $product->start_date != null ? $product->start_date : '' }}" required>
                    </div>
                    <div class="form-group" id="end_date_container">
                        <label for="end_date">Thời gian kết thúc: <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $product->end_date != null ? $product->end_date : '' }}" required>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="qty">Số lượng: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Nhập số lượng" id="qty" name="qty" value="{{ $product->qty }}" min=1 required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả sản phẩm:</label>
                <textarea class="form-control" id="description" name="description">{!! $product->description !!}</textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Danh mục sản phẩm: <span class="text-danger">*</span></label>
                <select class="form-control" name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        @if ($category->id === $product->category_id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }} (thuộc {{ \App\Models\ParentCategory::find($category->parent_category_id)->name }})</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }} (thuộc {{ \App\Models\ParentCategory::find($category->parent_category_id)->name }})</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="brand_id">Hãng sản phẩm: <span class="text-danger">*</span></label>
                <select class="form-control" name="brand_id" id="brand_id">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="author_id">Tác giả: <span class="text-danger">*</span></label>
                <select class="form-control" name="author_id" id="author_id">
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ $author->id == $product->author_id ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="supplier_id">Nhà cung cấp: <span class="text-danger">*</span></label>
                <select class="form-control" name="supplier_id" id="supplier_id">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="public_date">Ngày xuất bản: </label>
                <input type="date" class="form-control" id="public_date" name="public_date" value="{{ $product->public_date }}">
            </div>
            <div class="form-group">
                <label for="size">Kích thước: </label>
                <input type="text" class="form-control" id="size" name="size" value="{{ $product->size }}">
            </div>
            <div class="form-group">
                <label for="cover">Hình thức bìa: </label>
                <input type="text" class="form-control" id="cover" name="cover" value="{{ $product->cover }}">
            </div>
            <div class="form-group">
                <label for="page">Số trang: </label>
                <input type="number" class="form-control" placeholder="Nhập số trang" id="page" name="page" min=1 value="{{ $product->page }}" required>
            </div>
            <div class="form-group">
                <label>Hình ảnh sản phẩm<span class="text-danger">*</span></label>
                <div id="multiple-images">
                    @foreach($product->image as $item)
                        <div style='background-image: url({{ asset($item->url) }})'>
                            <div class="overlay"></div>
                            <div class="remove" onclick="removeImage(this)">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <input type="hidden" name="thumbnail_src[]" 
                                    value="{{ $item->url }}" style="display: none" id="thumbnail">
                            </div>
                        </div>
                    @endforeach
                    <div id="add-image" class="add" onclick="addImage()">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                </div>
                <div id="error" class="text-danger"></div>
                <br>
                <script>
                    function addImage() {
                        let imagePreview = $(`<div class="image-preview" style="display: none">
                                <div class="overlay"></div>
                                <div class="remove" onclick="removeImage(this)">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                    <input type="file" name="thumbnail[]" accept="image/*"
                                        onchange="checkImage(this)" style="display: none" id="thumbnail">
                                </div>
                            </div>`);
                        imagePreview.find('input').last().click();
                    }
                    function checkImage(el) {
                        const file = el.files[0];
                        const reader = new FileReader();
                        reader.addEventListener("load", function() {
                            let imagePreview = $(el).parent().parent();
                            imagePreview.attr("style", "display: flex; background-image: url(\""+this.result+"\")");
                            $('#multiple-images #add-image').before(imagePreview);
                        });
                        reader.readAsDataURL(file);
                    }
                    function removeImage(el) {
                        if($(el).parent().css('display') != 'none') {
                            $(el).parent().remove();
                        }
                    }
                </script>
                <style>
                    #multiple-images {
                        display: grid;
                        grid-template-columns: repeat(5, 1fr);
                        grid-gap: .5rem;
                        width: 100%;
                        padding: 0;
                        margin: 0;
                        margin-bottom: 1rem;
                    }
                    #multiple-images > div {
                        display: flex;
                        align-items: start;
                        justify-content: flex-end;
                        padding: 0;
                        margin: 0;
                        background-color: black;
                        border-radius: .5rem;
                        overflow: hidden;
                        background-size: cover;
                        background-position: center center;
                        width: 100%;
                    }
                    #multiple-images .overlay {
                        width: 101%;
                        padding-top: 101%;
                        background-color: rgb(0, 0, 0, .2);
                    }
                    #multiple-images .remove {
                        font-size: 1.2rem;
                        padding: .5rem;
                        color: white;
                        cursor: pointer;
                        position: absolute;
                    }
                    #multiple-images .add {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        padding-top: calc(50% - 1.5rem);
                        padding-bottom: calc(50% - 1.5rem);
                        font-size: 3rem;
                        line-height: 3rem;
                        color: gray;
                        background: white;
                        border: thin solid gray;
                        cursor: pointer;
                    }
                </style>
            </div>
            <button type="submit" class="btn btn-primary" onclick="return validate()">Sửa</button>
          </form>
    </div>
</div>
@endsection