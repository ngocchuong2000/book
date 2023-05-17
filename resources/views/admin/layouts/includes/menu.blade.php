@if (Auth::guard('admin')->user()->role == 0)
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Thống kê</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Sản phẩm
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true"
            aria-controls="collapseZero">
            <i class="fas fa-fw fa-table"></i>
            <span>Danh mục cha</span>
        </a>
        <div id="collapseZero" class="collapse" aria-labelledby="headingZero" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('parent.category.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('parent.category.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fas fa-fw fa-table"></i>
            <span>Danh mục con</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('category.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('category.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true"
            aria-controls="collapseNine">
            <i class="fas fa-fw fa-table"></i>
            <span>Hãng sản phẩm</span>
        </a>
        <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('brand.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('brand.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTen" aria-expanded="true"
            aria-controls="collapseTen">
            <i class="fas fa-fw fa-table"></i>
            <span>Tác giả</span>
        </a>
        <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('author.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('author.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
            <span>Nhà xuất bản</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('supplier.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('supplier.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-fw fa-table"></i>
            <span>Sản phẩm</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('product.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('product.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Người dùng
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
            aria-controls="collapseFour">
            <i class="fas fa-fw fa-table"></i>
            <span>Nhân viên</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('staff.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('staff.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
            aria-controls="collapseFive">
            <i class="fas fa-fw fa-table"></i>
            <span>Khách hàng</span>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('customer.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Mua hàng
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true"
            aria-controls="collapseSix">
            <i class="fas fa-fw fa-table"></i>
            <span>Mã khuyến mãi</span>
        </a>
        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('voucher.list') }}">Danh sách</a>
                <a class="collapse-item" href="{{ route('voucher.add') }}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
            aria-controls="collapseSeven">
            <i class="fas fa-fw fa-table"></i>
            <span>Đơn hàng</span>
        </a>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('order.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Khác
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true"
            aria-controls="collapseEight">
            <i class="fas fa-fw fa-table"></i>
            <span>Bình luận</span>
        </a>
        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('comment.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true"
            aria-controls="collapseEleven">
            <i class="fas fa-fw fa-table"></i>
            <span>Đánh giá</span>
        </a>
        <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('rating.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Setting -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('setting') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Thiết lập trang web</span></a>
    </li>
@else
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Thống kê</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Mua hàng
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true"
            aria-controls="collapseSeven">
            <i class="fas fa-fw fa-table"></i>
            <span>Đơn hàng</span>
        </a>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('order.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Khác
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEight" aria-expanded="true"
            aria-controls="collapseEight">
            <i class="fas fa-fw fa-table"></i>
            <span>Bình luận</span>
        </a>
        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('comment.list') }}">Danh sách</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNine" aria-expanded="true"
            aria-controls="collapseNine">
            <i class="fas fa-fw fa-table"></i>
            <span>Đánh giá</span>
        </a>
        <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('rating.list') }}">Danh sách</a>
            </div>
        </div>
    </li>
@endif
