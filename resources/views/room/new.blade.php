@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-7 mt-3">
            <h2>Tạo phòng họp mới</h2>
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    {{-- <h3 class="card-title">Quick Example</h3> --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{ URL::to('/room/save') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tên phòng họp</label>
                            <input type="text" class="form-control" name="title"
                                placeholder="V.B204..">
                        </div>
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="0">Public</option>
                                <option value="1">Private</option>   
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="attendance">Khách mời</label>
                            <input type="text" data-role="tagsinput" name="attendance">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection