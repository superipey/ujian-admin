@extends('templates.header')

@section('content')
    <div class="modal modal-elfinder" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="elfinder"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                @include('templates.error')
                <h4 class="card-title">Tambah Data Ujian <a href="{{ route('atur_ujian.index') }}"
                                                             class="btn btn-outline-info"><i
                                class="fa fa-arrow-circle-o-left"></i> Kembali</a></h4>
                <form class="forms-sample" method="POST"
                      action="{{ !empty($result) ? route('atur_ujian.update', $result->id) : route('atur_ujian.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Nama Ujian</label>
                        <div class="col-sm-10">
                            <input type="hidden" value="{{ @$result->nama_ujian }}" />
                            <input type="text" class="form-control" name="nama_ujian" placeholder="Input Nama Ujian"
                                   value="{{ old('nama_ujian', @$result->nama_ujian) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Tanggal Awal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control date" name="tanggal_mulai"
                                   placeholder="Input tanggal mulai"
                                   value="{{ old('tanggal_mulai', empty($result->tanggal_mulai) ? '' : $result->tanggal_mulai->format('d M Y H:i:s')) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control date" name="tanggal_selesai"
                                   placeholder="Input tanggal selesai"
                                   value="{{ old('tanggal_selesai', empty($result->tanggal_selesai) ? '' : $result->tanggal_selesai->format('d M Y H:i:s')) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Token</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="token" placeholder="Input Token" maxlength="5"
                                   value="{{ old('token', @$result->token) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="password" placeholder="Input Password" maxlength="5"
                                   value="{{ old('token', @$result->password) }}"/>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="{{ asset('vendors') }}/mdp/bootstrap-material-datetimepicker.css" rel="stylesheet"/>

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('elfinder/windows-10/css/theme.css') }}">


    <style>
        .ck-editor__editable {
            min-height: 1000px;
        }
    </style>
@endpush

@push('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('vendors') }}/mdp/bootstrap-material-datetimepicker.js"></script>

    <script src="{{ asset('packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    <script>
      $(function () {
        $('.date').bootstrapMaterialDatePicker({time: true, format: 'DD MMM YYYY HH:mm:00'});

        CKEDITOR.replace('deskripsi', {
          filebrowserBrowseUrl: '{{ url('/elfinder/ckeditor') }}',
          height: 300
        });

          @if (!empty($result))
          $("#featured").removeClass('d-none');
          // $("#featured").attr('src', file.getUrl());
          $("#pilihGambar").html("Ganti Gambar");
          @endif

        $("#pilihGambar").on('click', function () {
          $('.modal-elfinder').modal('show');

          var elf = $('#elfinder').elfinder({
            customData: {
              '_token': '{{ csrf_token() }}'
            },
            url: '{{ url('elfinder/connector') }}',
            dialog: {width: 900, modal: true, title: 'Select a file'},
            resizable: false,
            commandsOptions: {
              getfile: {
                oncomplete: 'destroy',
                multiple: false,
              }
            },
            getFileCallback: function (file) {
              $("#featured").removeClass('d-none');

              featuredImage = file.url;

              $('#featured').attr('src', featuredImage);
              $('[name=gambar]').val(featuredImage)

              $('.modal-elfinder').modal('hide');

              urls = $.map(file, function (f) {
                return f;
              });
            }
          }).elfinder('instance');
        })

      })
    </script>
@endpush
