@extends('layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Log</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Log</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Log room: <b>{{ $room->title }}</b> ({{ $room->roomId }})</h3>
                    <script>
                        document.title = "Log " + '{{ $room->title }} ' + "({{ $room->roomId }})";
                    </script>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thời gian vào</th>
                                <th>Thời gian ra</th>
                                <th>IP</th>
                                <th>Thời gian tham gia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->fullname }}</td>
                                    <td>{{ $item->start }}</td>
                                    <td>{{ $item->end }}</td>
                                    <td>{{ $item->ip }}</td>
                                    <td>{{ (new \Carbon\Carbon($item->end))->diff(new \Carbon\Carbon($item->start))->format('%h:%I') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thời gian vào</th>
                                <th>Thời gian ra</th>
                                <th>IP</th>
                                <th>Thời gian tham gia</th>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ URL::to('/room/destroy-log/'.$room->id) }}" onclick="return confirm('Xóa log!')" class="btn btn-outline-dark">Xóa log</a>
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
