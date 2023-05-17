<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trang quản trị</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('client/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('client/favicon_io/favicon-16x16.png') }}">
    <style>
        /* Image preview */
        .image-preview {
            width: 300px;
            min-height: 150px;
            border: 2px solid #dddddd;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #cccccc;
        }

        .image-preview__image {
            display: none;
            width: 100%;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">HỆ THỐNG</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            @include('admin.layouts.includes.menu')

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::guard('admin')->user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('admin/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('client.home') }}">
                                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Trang chủ
                                </a>
                                @if (Auth::guard('admin')->user()->role == 1)
                                    <a class="dropdown-item" href="{{ route('staff.change.info', ['id' => Auth::guard('admin')->user()->id]) }}">
                                        <i class="fas fa-pencil-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Cập nhật thông tin
                                    </a>
                                    <a class="dropdown-item" href="{{ route('staff.change.pass', ['id' => Auth::guard('admin')->user()->id]) }}">
                                        <i class="fas fa-pencil-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Đổi mật khẩu
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('admin.handle.logout') }}" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright {{ date('Y') }} - Hệ thống độc quyền của công ty</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có muốn đăng xuất khỏi hệ thống ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Hãy nhấn vào nút "Đăng xuất" bên dưới để thoát khỏi hệ thống</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="{{ route('admin.handle.logout') }}">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/datatables-demo.js') }}"></script>

    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script>CKEDITOR.replace('description')</script>

    <input type="hidden" id="data" value="{{ json_encode($data) }}" />
    <input type="hidden" id="data1" value="{{ json_encode($data1) }}" />
    <input type="hidden" id="data2" value="{{ json_encode($data2) }}" />

    {{-- Google Charts Library --}}
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    {{-- Revenue by day --}}
    <script type="text/javascript">
        var arr = [['Ngày', 'Doanh thu', { role: "style" }]];
        var orders = JSON.parse(document.getElementById("data").value);
        if (orders.length < 1) {
            arr.push(['', 0, '#3366CC']);
        }
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        for(x of orders){
            arr.push([x.order_day,parseInt(x.total_price),'#3366CC'])
        }  
        function drawChart() {
    
            var data = google.visualization.arrayToDataTable(
                arr
            );
    
            var options = {
            title: 'Thống kê doanh thu theo ngày',
            bar: {groupWidth: "5%"},
            };
    
            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
    
            chart.draw(data, options);
        }
    </script>
    {{-- Revenue by month --}}
    <script>
        var arr1 = [['Tháng', 'Doanh thu']];
        var orders = JSON.parse(document.getElementById("data1").value);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        for(x of orders){
          arr1.push(['Tháng '+x.order_month,parseInt(x.total_price)])
        }  
        function drawChart() {
  
          var data = google.visualization.arrayToDataTable(
              arr1
          );
  
          var options = {
            title: 'Thống kê doanh thu theo tháng'
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  
          chart.draw(data, options);
        }
    </script>
    {{-- Revenue by year --}}
    <script>
        var arr2 = [['Năm', 'Doanh thu']];
        var orders = JSON.parse(document.getElementById("data2").value);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        for(x of orders){
          arr2.push(['Năm '+x.order_year,parseInt(x.total_price)])
        }  
        function drawChart() {
  
          var data = google.visualization.arrayToDataTable(
              arr2
          );
  
          var options = {
            title: 'Thống kê doanh thu theo năm'
          };
  
          var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
  
          chart.draw(data, options);
        }
    </script>
    <script>
        $(document).ready(function() {
            if ($('#price_sale').val() <= 0) {
                $('#price_sale').prop('required',false);
                $('#start_date').prop('required',false);
                $('#end_date').prop('required',false);
                $('#price_sale_container').hide();
                $('#start_date_container').hide();
                $('#end_date_container').hide();
            }
            $('#type').change(function(){
                var type = $(this).val();
                if (type == 0) {
                    $('#price').prop('disabled',false);
                    $('#price_sale').prop('required',false);
                    $('#start_date').prop('required',false);
                    $('#end_date').prop('required',false);
                    $('#price_sale_container').hide();
                    $('#start_date_container').hide();
                    $('#end_date_container').hide();
                } else {
                    if (type == 1) {
                        var html = `
                            <div class="form-group" id="price_sale_container">
                                <label for="price_sale">Giá khuyến mãi: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" placeholder="Nhập giá tiền" id="price_sale" name="price_sale" min=1 required>
                            </div>
                            <div class="form-group" id="start_date_container">
                                <label for="start_date">Thời gian bắt đầu: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group" id="end_date_container">
                                <label for="end_date">Thời gian kết thúc: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        `;
                        if ($('#product_sale_container').children().length <= 0) {
                            $('#product_sale_container').html(html);
                        }
                        $('#price_sale').prop('required',true);
                        $('#start_date').prop('required',true);
                        $('#end_date').prop('required',true);
                        $('#price_sale_container').show();
                        $('#start_date_container').show();
                        $('#end_date_container').show();
                    }
                }
            });
        });

        function validate()
        {
            var type = $('#type').val();
            var price = Number($('#price').val());
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var sale_price = Number($('#price_sale').val());
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
            
            if (type == 1) {
                if (sale_price >= price) {
                    alert('Giá tiền phải lớn hơn giá khuyến mãi');
                    return false;
                }
            }

            if (type == 1) {
                if (end_date < today_date) {
                    alert('Ngày bắt đầu và ngày kết thúc không được nhỏ hơn ngày hôm nay');
                    return false;
                } else {
                    if (start_date > end_date) {
                        alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc');
                        return false;
                    }
                }
            }

            return true;
        }
    </script>
    @yield('js')
</body>

</html>