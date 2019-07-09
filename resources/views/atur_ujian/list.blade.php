@extends('templates.header')

@section('content')
    @include('templates.error')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ujian
                    <a  href="{{ route('atur_ujian.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                </h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Tanggal</th>
                        <th>Token</th>
                        <th>Password</th>
                        <th>Jumlah Soal</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (@$result ? $result : [] as $row)
                        <tr>
                            <td>{{ isset($i) ? ++$i : $i = 1  }}</td>
                            <td>{{ $row->nama_ujian }}</td>
                            <td>{{ $row->tanggal_mulai->format('d F Y H:i:s') . " - " . $row->tanggal_selesai->format('d F Y H:i:s') }}</td>
                            <td>{{ $row->token }}</td>
                            <td>{{ $row->password }}</td>
                            <td>{{ $row->soal->count() }}</td>
                            <td>{{ $row->status }}</td>
                            <td class="no-wrap">
                                <a href="{{ url('soal', $row->id) }}" class="btn btn-info btn-sm"><i class="fa fa-th"></i></a>
                                <a href="{{ route('atur_ujian.edit', $row->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('atur_ujian.destroy', @$row->id) }}" method="POST" style="display: inline-block">
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