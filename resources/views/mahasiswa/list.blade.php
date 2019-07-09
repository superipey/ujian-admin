@extends('templates.header')

@section('content')
    @include('templates.error')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Mahasiswa
                    <a href="{{ route('mahasiswa.create') }}" class="btn btn-outline-primary"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                    <a href="#" class="btn btn-outline-warning btnImport"><i class="fa fa-upload"></i> Import Data</a>
                </h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (@$result ? $result : [] as $row)
                        <tr>
                            <td>{{ isset($i) ? ++$i : $i = 1  }}</td>
                            <td>{{ $row->nim }}</td>
                            <td>{{ $row->nama_lengkap }}</td>
                            <td>{{ $row->kelas->nama_kelas }}</td>
                            <td class="no-wrap">
                                <a href="{{ route('mahasiswa.reset', $row->id) }}" class="btn btn-info btn-sm"><i class="fa fa-key"></i></a>
                                <a href="{{ route('mahasiswa.edit', $row->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                <form action="{{ route('mahasiswa.destroy', @$row->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="hidden" style="display: none">
        <form id="form-import" action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="file" class="col-sm-2 col-form-label">File</label>
                <div class="col-sm-10">
                    <input type="file" name="file" class="form-control" />
                </div>
                <input type="submit" id="btnSubmit" style="display: none;">
            </div>

            <button type="submit" class="btn btn-success mr-2">Import</button>
        </form>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
@endpush

@push('script')
    <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>

      var template = $('.hidden').clone()

      $(function () {
        $('.table').DataTable();

        $(".btnImport").click(function () {
          swal({
            'title': 'Import Mahasiswa',
            content: 'input'
          })

          $(".swal-content").html(template.html())
          $(".swal-footer *").hide()
        })
      })
    </script>
@endpush