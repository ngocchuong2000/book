@extends('admin.layouts.index')


@section('content')
<h1 class="h3 mb-2 text-gray-800">Đánh giá</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Số sao trung bình</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($ratings as $rating)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ \App\Models\Product::find($rating->product_id)->name }}</td>
                            <td>{{ round($rating->avg_stars) }}</td>
                            <td>
                                <a href="{{ route('rating.show',['id' => $rating->product_id]) }}" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
