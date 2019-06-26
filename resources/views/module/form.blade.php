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
                <h4 class="card-title">Tambah Data Berita <a href="{{ route('berita.index') }}"
                                                             class="btn btn-outline-info"><i
                                class="mdi mdi-arrow-left"></i> Kembali</a></h4>
                <form class="forms-sample" method="POST"
                      action="{{ !empty($result) ? route('berita.update', $result->_id) : route('berita.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Judul Berita</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="judul" placeholder="Input judul berita"
                                   value="{{ old('judul', @$result->judul) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Tanggal Berita</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control date" name="tanggal"
                                   placeholder="Input tanggal berita"
                                   value="{{ old('tanggal', empty($result->tanggal) ? '' : $result->tanggal->format('d M Y')) }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea rows="5" name="deskripsi"
                                      placeholder="Input deskripsi">{!! old('deskripsi', @$result->deskripsi) !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Featured Image
                            (Opsional)</label>
                        <div class="col-sm-10">
                            <img style="width: 400px; margin-bottom: 20px;" id="featured"
                                 src="{{ @$result->gambar_file }}" alt="Featured Image" class="d-none"/>
                            <input id="gambar" name="gambar" type="hidden" value="{{ @$result->gambar }}"/>
                            <button style="display: block;" id="pilihGambar" type="button" class="btn btn-info">
                                Pilih
                                Gambar
                            </button>
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
        $('.date').bootstrapMaterialDatePicker({time: false, format: 'DD MMM YYYY'});

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
