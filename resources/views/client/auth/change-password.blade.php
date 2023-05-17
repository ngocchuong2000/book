@extends('client.layout.master')

@section('content')
    <!-- nội dung của trang  -->
    <section class="account-page my-3">
        <div class="container">
            <div class="page-content bg-white">
                <div class="account-page-tab-content m-4">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-thanhtoan-tab" data-toggle="tab" href="#nav-thanhtoan"
                                role="tab" aria-controls="nav-home" aria-selected="true">Đổi mật khẩu</a>
                        </div>
                    </nav>

                    <div class="tab-content">
                        <div class="tab-pane fade show active pl-4 " id="nav-thanhtoan" role="tabpanel"
                            aria-labelledby="nav-thanhtoan-tab">
                            <div class="row">
                                <div class="col-lg-9 col-md-6">
                                    <div class="offset-md-4 mt-3">
                                        <h3 class="account-header text-center">Đổi mật khẩu</h3>
                                    </div>
                                    <form action="{{ route('auth.updatepassword') }}" method="POST">

                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}" />
                                        <div class="email my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="password">Mật khẩu mới</label>
                                                <input class="col-md-6" type="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="email my-3">
                                            <div class="row">
                                                <label class="col-md-3 offset-md-2" for="repassword">Nhập lại mật khẩu</label>
                                                <input class="col-md-6" type="password" name="repassword" required>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="capnhat my-3">
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-3">
                                                        <button type="submit"
                                                        class="button-capnhat text-uppercase offset-md-4 btn btn-warning mb-4 text-white" name="btnSubmit" style="margin-left: 30%;">Cập nhật</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
