@extends('admin.layouts.index')


@section('content')
    <h1 class="h3 mb-2 text-gray-800">Phản hồi</h1>

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
                            <th>Người phản hồi</th>
                            <th>Nội dung</th>
                            <th>Ngày phản hồi</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($replies as $row)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->content }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($row->created_at)) }}</td>
                                <td>
                                    <a class="btn btn-danger btn-circle btn-sm" href="{{ route('reply.delete',['id' => $row->id]) }}" onclick="return confirm('Bạn muốn xóa item này ?')" style="margin:0 1rem;"><i class="fas fa-trash"></i></a>
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
