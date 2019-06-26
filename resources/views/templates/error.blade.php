@if (count($errors) > 0)
    <div class="alert alert-danger">
        <b>Perhatian</b>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success">
                <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {!! session('success') !!}
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {!! session('error') !!}
            </div>
        </div>
    </div>
@endif