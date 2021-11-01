@extends('layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Room</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Phòng họp: <b>{{ $room->title }}</b> (<a
                            href="{{ URL::to('/r/' . $room->roomId) }}" target="_blank"
                            rel="noopener noreferrer">{{ $room->roomId }}</a>)</h3>
                    <script>
                        document.title = "Phòng họp: {{ $room->title }} ({{ $room->roomId }})";
                    </script>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Auth</th>
                                <th>*</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->fullname }}</td>
                                    <td>{{ $item->user->email }}</td>
                                    <td>{{ $item->user->phone }}</td>
                                    <td>{{ $item->auth }}</td>
                                    <td>
                                        <a href="#" class="btn btn-outline-danger delete_attendance"
                                            onclick="return confirm('Xóa người này khỏi phòng họp!')"
                                            data-id="{{ $item->user_id }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Auth</th>
                                <th>*</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6 mt-3">
            <!-- general form elements -->
            <div class="card card-secondary">
                <div class="card-header">
                    {{-- <h3 class="card-title">Quick Example</h3> --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{ URL::to('/room/update/' . $room->id) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Tên phòng họp</label>
                            <input type="text" class="form-control" name="title" placeholder="V.B204.."
                                value="{{ $room->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control" name="status">
                                @if ($room->status == 0)
                                    <option value="0" selected>Public</option>
                                    <option value="1">Private</option>
                                @else
                                    <option value="0">Public</option>
                                    <option value="1" selected>Private</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thời gian họp:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                                @php
                                    if ($room->start) {
                                        $time = $room->start . ' | ' . $room->startTime . ' - ' . $room->end . ' | ' . $room->endTime;
                                    }
                                @endphp
                                <input type="text" class="form-control float-right" value="
                                                                <?php if (isset($time)) {
                                                                    echo $time;
                                                                } ?>" name="time" id="reservationtime">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Ngày lặp lại:</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- checkbox -->
                                    <div class="form-group clearfix">
                                        <?php $color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark']; ?>
                                        @for ($i = 0; $i < 7; $i++)
                                            <?php
                                            $checked = '';
                                            if ($room->daysOfWeek) {
                                                foreach (json_decode($room->daysOfWeek) as $item) {
                                                    if ((int) $item == $i) {
                                                        $checked = 'checked';
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="icheck-{{ $color[$i] }} d-inline">
                                                <input type="checkbox" name="daysOfWeek[]" value="{{ $i }}"
                                                    id="checkboxP{{ $i }}" {{ $checked }}>
                                                <label for="checkboxP{{ $i }}">
                                                    @if ($i == 0)
                                                        CN
                                                    @else
                                                        {{ $i + 1 }}
                                                    @endif
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Sửa đổi</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6 mt-3">
            <!-- general form elements -->
            <div class="card card-info">
                <div class="card-header">
                    {{-- <h3 class="card-title">Quick Example</h3> --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="attendance">Khách mời</label>
                        <input type="text" data-role="tagsinput" name="attendance" id="list_attendance">
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                    </div>
                    <button type="submit" class="btn btn-info" id="add_attendance">Thêm khách mời</button>
                </div>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    {{-- <h3 class="card-title">Quick Example</h3> --}}
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="attendance">Khác</label>
                    </div>
                    <a href="{{ URL::to('/room/destroy/' . $room->id) }}" class="btn btn-outline-danger"
                        onclick="return confirm('Bạn chắc chắn muốn xóa phòng họp này!')">Xóa phòng họp</a>
                    <a href="{{ URL::to('/room/log/' . $room->id) }}" class="btn btn-success">Log</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    @push('scripts')
        <!-- date-range-picker -->
        <script src="{{ URL::asset('/app/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('/app/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <script>
            $(function() {
                $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                        format: 'MM/DD/YYYY | HH:mm:ss'
                    }
                });

                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                var table = $('#example1').DataTable();
                $('#example1 tbody').on('click', '.delete_attendance', function() {
                    var _token = $('input[name=_token]').val();
                    var room_id = $('input[name=room_id]').val();
                    var this_row = $(this);
                    var user_id = $(this).data('id');
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: '/room/delete_attendance/' + room_id,
                        data: {
                            user_id: user_id,
                            _token: _token
                        },
                        dataType: "html",
                        success: function(data) {
                            if (data == true) {
                                table
                                    .row(this_row.parents('tr'))
                                    .remove()
                                    .draw();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                    return false;
                });
                $("#add_attendance").on('click', function() {
                    var _token = $('input[name=_token]').val();
                    var room_id = $('input[name=room_id]').val();
                    var list = $("#list_attendance").val();
                    if (list) {
                        $.ajax({
                            type: "POST",
                            cache: false,
                            url: '/room/add/' + room_id,
                            data: {
                                attendance: list,
                                _token: _token
                            },
                            dataType: "json",
                            success: function(data) {
                                var s = JSON.stringify(data);
                                s = JSON.parse(s);
                                s.forEach(element => {
                                    table.row.add(element).draw(false)
                                });
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
