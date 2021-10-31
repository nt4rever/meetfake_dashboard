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
                    <h3 class="card-title">Danh sách phòng họp của bạn</h3>
                    <script>
                        document.title = "Danh sách phòng họp của bạn";
                    </script>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room Code</th>
                                <th>Tên phòng họp</th>
                                <th>Trạng thái</th>
                                <th>Chủ phòng</th>
                                <th>Lịch</th>
                                <th>*</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_host as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->roomId }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->status == 0 ? 'Public' : 'Private' }}</td>
                                    <td>{{ $item->owner->fullname }}</td>
                                    <td>
                                        <div style="font-weight: 500;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            text-align: center;">
                                            {{ $item->start . ' - ' . $item->end }}
                                            <br>
                                            {{ $item->startTime . ' - ' . $item->endTime }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ URL::to('/room/show/' . $item->id) }}"
                                            class="btn btn-outline-secondary"><i class="fa fa-user-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($list_member as $item)
                                <tr>
                                    <td>{{ $item->room->id }}</td>
                                    <td>{{ $item->room->roomId }}</td>
                                    <td>{{ $item->room->title }}</td>
                                    <td>{{ $item->room->status == 0 ? 'Public' : 'Private' }}</td>
                                    <td>{{ $item->room->owner->fullname }}</td>
                                    <td>
                                        <div style="font-weight: 500;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            text-align: center;">
                                            {{ $item->start . ' - ' . $item->end }}
                                            <br>
                                            {{ $item->startTime . ' - ' . $item->endTime }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->auth }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Room Code</th>
                                <th>Tên phòng họp</th>
                                <th>Trạng thái</th>
                                <th>Chủ phòng</th>
                                <th>Lịch</th>
                                <th>*</th>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ URL::to('/room/new') }}" class="btn btn-outline-primary">Tạo phòng họp mới</a>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    @push('scripts')
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
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endpush
@endsection
