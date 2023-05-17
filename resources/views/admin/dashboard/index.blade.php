@extends('admin.layouts.index')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê doanh thu</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Doanh thu tháng {{ date('n') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($revenueMonth, -3, ',', ',') }} VND</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Doanh thu năm {{ date('Y') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($revenueYear, -3, ',', ',') }} VND</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Số lượng người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userTotal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Số lượng sách</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productTotal }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div id="columnchart"></div>
                    <div id="piechart2"></div>
                    <div id="piechart3"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('filter.order') }}" method="GET" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="start_date_revenue">Ngày bắt đầu: <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="start_date_revenue" name="start_date_revenue"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_date_revenue">Ngày kết thúc: <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="end_date_revenue" name="end_date_revenue" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" onclick="return validateReportDate()">Lọc</button>
                        </div>
                    </form>
                    @if (isset($orders))
                        <div class="col-lg-12" style="margin-top:1rem;">
                            @include('admin.dashboard.includes.order', compact('orders', 'orderTotal'))
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Thống kê số lượng tồn</h1>
            </div>
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable-2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục sản phẩm</th>
                                    <th>Số lượng tồn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><img src="{{ asset($product->image->first()->url) }}" width=60px></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->cate_title }}</td>
                                        <td>{{ $product->qty }}</td>
                                    </tr>
                                    @php $count++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function validateReportDate()
        {
            var start_date_revenue = $('#start_date_revenue').val();
            var end_date_revenue = $('#end_date_revenue').val();
            var date = new Date();
            var month = '' + (date.getMonth() + 1);
            var day = '' + date.getDate();
            var year = date.getFullYear();
            if (month.length < 2) {
                month = '0' + month;
            }
            if (day.length < 2) {
                day = '0' + day;
            }
            var today_date = [year, month, day].join('-');
            if (end_date_revenue < today_date) {
                alert('Ngày kết thúc không được nhỏ hơn ngày hôm nay');
                return false;
            } else {
                if (start_date_revenue > end_date_revenue) {
                    alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
                    return false;
                }
            }
        }
    </script>
@endsection
