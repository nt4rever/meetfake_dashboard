@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 mt-3">
            <h2>Thông tin tài khoản của bạn</h2>
            <script>
                document.title = "Tài khoản của bạn";
            </script>
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    {{-- <h3 class="card-title">Quick Example</h3> --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{ URL::to('/user/save') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fullname">Họ và tên</label>
                            <input type="text" class="form-control" name="fullname" value="{{$user->fullname}}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" value="{{$user->email}}" disabled required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" value="{{$user->phone}}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" value="{{$user->address}}" required>
                        </div>
                        <div class="form-group">
                            <label for="oldpassword">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" name="oldpassword" required>
                        </div>
                        <div class="form-group">
                            <label for="newpassword">Mật khẩu mới (nếu có)</label>
                            <input type="password" class="form-control" name="newpassword">
                        </div>
                        <div class="form-group">
                            <label for="repeatpassword">Nhập lại mật khẩu mới (nếu có)</label>
                            <input type="password" class="form-control" name="repeatpassword">
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection