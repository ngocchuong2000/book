@extends('admin.layouts.index')


@section('content')
    <h1 class="h3 mb-2 text-gray-800">Bình luận</h1>

    @if (Session::has('invalid'))
        <div class="alert alert-danger alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('invalid') }}
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr align="center">
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Người bình luận</th>
                            <th>Nội dung</th>
                            <th>Ngày bình luận</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($comments as $row)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $row->product }}</td>
                                <td>{{ $row->user }}</td>
                                <td>{{ $row->content }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($row->created_at)) }}</td>
                                <td>
                                    <a class="btn btn-primary btn-circle btn-sm" href="{{ route('comment.show', ['id' => $row->id]) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-danger btn-circle btn-sm" href="{{ route('comment.delete', ['id' => $row->id]) }}"
                                        onclick="return confirm('Bạn muốn xóa bình luận này ?')"
                                        ><i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
