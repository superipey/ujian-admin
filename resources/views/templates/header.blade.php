<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ujian Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('') }}/vendors/iconfonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ asset('') }}/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}/css/custom.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('') }}/images/favicon.png" />
    @stack('style')
</head>

<body>
<div class="container-scroller">
<!-- partial:{{ asset('') }}/partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="{{ asset('') }}/index.html">
                <img src="{{ asset('') }}/images/LogoPPDB.svg" alt="logo"
                     style="height: 100% !important; width: 100% !important;" /> </a>
            <a class="navbar-brand brand-logo-mini" href="{{ asset('') }}/index.html">
                <img src="{{ asset('') }}/images/logo-mini.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown d-none d-xl-inline-block">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <span class="profile-text">Hello, {{ auth()->user()->username }}</span>
                        <img class="img-xs rounded-circle" src="{{ asset('') }}/images/faces-clipart/pic-1.png" alt="Profile image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <a style="margin-top: 20px;" href="{{ url('change-password') }}" class="dropdown-item"> Change Password </a>
                        <form action="{{ url('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"> Sign Out</button>
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <!-- partial:{{ asset('') }}/partials/_sidebar.html -->

        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <div class="nav-link">
                        <div class="user-wrapper">
                            <div class="profile-image">
                                <img src="{{ asset('') }}/images/faces/face1.jpg" alt="profile image">
                            </div>
                            <div class="text-wrapper">
                                <p class="profile-name">{{ auth()->user()->username }}</p>
                                <div>
                                    <small class="designation text-muted">Administrator</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item {{ Request::segment(1) == '' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}"> <i class="menu-icon fa fa-home"></i>
                        <span class="menu-title">Dashboard</span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/mahasiswa') }}"> <i class="menu-icon fa fa-users"></i>
                        <span class="menu-title">Mahasiswa</span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/atur_ujian') }}"> <i class="menu-icon fa fa-gamepad"></i>
                        <span class="menu-title">Ujian</span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/tahun_akademik') }}"> <i class="menu-icon fa fa-graduation-cap"></i>
                        <span class="menu-title">Tahun Akademik</span> </a>
                </li>
            </ul>
        </nav>

        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>

@include('templates.footer')
