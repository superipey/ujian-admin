<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PPDB Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('') }}/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ asset('') }}/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="{{ asset('') }}/vendors/iconfonts/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('') }}/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('') }}/images/favicon.png"/>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    @include('templates.error')

                    <div class="auto-form-wrapper">
                        <form action="{{ url('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="label">Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Username" name="username">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="*********" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-key"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <div class="form-check form-check-flat mt-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="remember"> Ingat Saya
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary submit-btn btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                    <ul class="auth-footer">
                        <li>
                        </li>
                    </ul>
                    <p class="footer-text text-center">Udah login aja, gak usah banyak tanya</p>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ asset('') }}/vendors/js/vendor.bundle.base.js"></script>
<script src="{{ asset('') }}/vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{ asset('') }}/js/off-canvas.js"></script>
<script src="{{ asset('') }}/js/misc.js"></script>
<!-- endinject -->
</body>

</html>
