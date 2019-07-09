@extends('templates.header')

@section('content')
    @include('templates.error')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tahun Akademik <a  href="{{ route('tahun_akademik.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus-circle"></i> Tambah Data</a></h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun Akademik</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (@$result ? $result : [] as $row)
                        <tr>
                            <td>{{ isset($i) ? ++$i : $i = 1  }}</td>
                            <td>{{ $row->tahun_akademik }}</td>
                            <td>{{ $row->status }}</td>
                            <td class="no-wrap">
                                <a href="{{ route('tahun_akademik.edit', $row->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('tahun_akademik.destroy', @$row->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endpush

@push('script')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
      $(function () {
        $('.table').DataTable();
      })
    </script>
@endpush