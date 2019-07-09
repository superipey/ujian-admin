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
                <h4 class="card-title">Tambah Soal <a href="{{ url('soal', @$ujian->id) }}"
                                                      class="btn btn-outline-info"><i
                                class="fa fa-arrow-circle-o-left"></i> Kembali</a></h4>
                <form class="forms-sample" method="POST"
                      action="{{ !empty($result) ? url('soal/' . @$ujian->id, $result->id) : url('soal/' . @$ujian->id) }}"
                      enctype="multipart/form-data">
                    @csrf

                    @if (!empty($result))
                        @method('PUT')
                    @endif

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Pertanyaan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="pertanyaan" placeholder="Input Pertanyaan">{{ old('pertanyaan', @$result->pertanyaan) }}</textarea>
                        </div>
                    </div>

                    @php
                        $jawaban = ['A', 'B', 'C', 'D'];
                    @endphp

                    @foreach ($jawaban as $j)
                        @php
                            $var = 'jawaban_' . strtolower($j);
                        @endphp
                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Jawaban {{ $j }}</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" name="{{ $var }}" placeholder="Input Jawaban {{ $j }}">{{ old($var, @$result->$var) }}</textarea>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Kunci Jawaban</label>
                        <div class="col-sm-3">
                            <select name="kunci_jawaban" class="form-control">
                                <option value="">- Pilih Kunci Jawaban -</option>
                                @foreach ($jawaban as $j)
                                    <option value="{{ $j }}" {{ old('kunci_jawaban', @$result->kunci_jawaban) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="{{ asset('vendors') }}/mdp/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />

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

        CKEDITOR.replace('pertanyaan', {
          // Define the toolbar: https://ckeditor.com/docs/ckeditor4/latest/features/toolbar
          // The full preset from CDN which we used as a base provides more features than we need.
          // Also by default it comes with a 3-line toolbar. Here we put all buttons in two rows.
          toolbar: [{
            name: 'clipboard',
            items: ['PasteFromWord', '-', 'Undo', 'Redo']
          },
            {
              name: 'basicstyles',
              items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'Subscript', 'Superscript']
            },
            {
              name: 'links',
              items: ['Link', 'Unlink']
            },
            {
              name: 'paragraph',
              items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
              name: 'insert',
              items: ['Image', 'Table']
            },
            {
              name: 'editing',
              items: ['Scayt']
            },
            '/',

            {
              name: 'styles',
              items: ['Format', 'Font', 'FontSize']
            },
            {
              name: 'colors',
              items: ['TextColor', 'BGColor', 'CopyFormatting']
            },
            {
              name: 'align',
              items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            },
            {
              name: 'document',
              items: ['Print', 'PageBreak', 'Source']
            }
          ],

          // Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
          // One HTTP request less will result in a faster startup time.
          // For more information check https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-customConfig
          customConfig: '',

          // Upload images to a CKFinder connector (note that the response type is set to JSON).
          uploadUrl: '{{ url('/ckfinder/connector') }}?command=QuickUpload&type=Images&responseType=json',

          // Configure your file manager integration. This example uses CKFinder 3 for PHP.
          filebrowserBrowseUrl: '{{ url('/elfinder/ckeditor') }}',
          filebrowserImageBrowseUrl: '{{ url('/elfinder/ckeditor') }}',
          filebrowserUploadUrl: '{{ url('/ckeditor_uploads') }}',
          filebrowserImageUploadUrl: '{{ url('/ckeditor_uploads') }}',

          // Sometimes applications that convert HTML to PDF prefer setting image width through attributes instead of CSS styles.
          // For more information check:
          //  - About Advanced Content Filter: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_advanced_content_filter
          //  - About Disallowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_disallowed_content
          //  - About Allowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_allowed_content_rules
          disallowedContent: 'img{width,height,float}',
          extraAllowedContent: 'img[width,height,align];span{background}',

          // Enabling extra plugins, available in the full-all preset: https://ckeditor.com/cke4/presets
          extraPlugins: 'colorbutton,font,justify,print,tableresize,uploadimage,uploadfile,pastefromword,liststyle,pagebreak',

          /*********************** File management support ***********************/
          // In order to turn on support for file uploads, CKEditor has to be configured to use some server side
          // solution with file upload/management capabilities, like for example CKFinder.
          // For more information see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_ckfinder_integration

          // Uncomment and correct these lines after you setup your local CKFinder instance.
          // filebrowserBrowseUrl: 'http://example.com/ckfinder/ckfinder.html',
          // filebrowserUploadUrl: 'http://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
          /*********************** File management support ***********************/

          // Make the editing area bigger than default.
          height: 500,
          width: 940,

          // An array of stylesheets to style the WYSIWYG area.
          // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
          contentsCss: [
            'http://cdn.ckeditor.com/4.12.1/full-all/contents.css',
            '{{ url('js') }}/ckeditor/pastefromword.css'
          ],

          // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
          bodyClass: 'document-editor',

          // Reduce the list of block elements listed in the Format dropdown to the most commonly used.
          format_tags: 'p;h1;h2;h3;pre',

          // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
          removeDialogTabs: 'image:advanced;link:advanced',

          // Define the list of styles which should be available in the Styles dropdown list.
          // If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
          // (and on your website so that it rendered in the same way).
          // Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
          // that file, which means one HTTP request less (and a faster startup).
          // For more information see https://ckeditor.com/docs/ckeditor4/latest/features/styles
          stylesSet: [
            /* Inline Styles */
            {
              name: 'Marker',
              element: 'span',
              attributes: {
                'class': 'marker'
              }
            },
            {
              name: 'Cited Work',
              element: 'cite'
            },
            {
              name: 'Inline Quotation',
              element: 'q'
            },

            /* Object Styles */
            {
              name: 'Special Container',
              element: 'div',
              styles: {
                padding: '5px 10px',
                background: '#eee',
                border: '1px solid #ccc'
              }
            },
            {
              name: 'Compact table',
              element: 'table',
              attributes: {
                cellpadding: '5',
                cellspacing: '0',
                border: '1',
                bordercolor: '#ccc'
              },
              styles: {
                'border-collapse': 'collapse'
              }
            },
            {
              name: 'Borderless Table',
              element: 'table',
              styles: {
                'border-style': 'hidden',
                'background-color': '#E6E6FA'
              }
            },
            {
              name: 'Square Bulleted List',
              element: 'ul',
              styles: {
                'list-style-type': 'square'
              }
            }
          ]
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
