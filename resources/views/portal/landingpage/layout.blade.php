<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Satu Data Kabupaten Madiun</title>

    <link rel="stylesheet" href="/landing-assets/css/maicons.css">

    <link rel="stylesheet" href="/landing-assets/css/bootstrap.css">

    <link rel="stylesheet" href="/landing-assets/vendor/animate/animate.css">

    <link rel="stylesheet" href="/landing-assets/css/theme.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,600;1,700&display=swap" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

<!-- Back to top button -->
<div class="back-to-top"></div>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky" data-offset="500">
        <div class="container">
            <!-- <div class="header mb-3">
                <img src="/assets/img/services/service-4.png" alt="">
            </div> -->
            <div class="header">
                <img style="width:200px; height:60px" src="/landing-assets/img/services/logo2.png" alt="">

            </div>
            <!-- <a href="#" class="navbar-brand">Satu<span class="text-primary">Data</span></a> -->

            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ Request::segment(1) === '/' ? 'active' : null }}">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('dataset') ? 'active' : null }}">
                        <a class="nav-link" href="{{route('dataset')}}">Dataset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ckan">Open-Data</a>
                    </li>
                    <li class="nav-item {{ Request::segment(1) === 'tentang' ? 'active' : null }}">
                        <a class="nav-link" href="/tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a href="/masuk" class="btn btn-ungu">Login</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    @yield('header')
</header>

@yield('content')

<footer class="page-footer bg-image" style="background-image: url(../landing-assets/img/world_pattern.svg);">
    <div class="container" style="margin-top: -20px;">
        <div class="row mb-5">
            <!-- <div class="row mb-2">

            </div> -->
            <div class="col-lg-3 py-3">
                <div class="header">
                    <img style="width:100px; height:100px ; margin-left: 130px; margin-top:-40px"
                         src="../landing-assets/img/services/120x120.png" alt="">
                </div>
            </div>
            <div class="col-lg-3 py-3">
                <h3>KABUPATEN MADIUN</h3>

            </div>

            <div class="col-lg-3 py-3">
                <p>Portal Data Terpadu Pemkab Madiun</p>
            </div>

            <div class="col-lg-3 py-3">
                <div class="social-media-button">
                    <a href="#"><span class="mai-logo-facebook-f"></span></a>
                    <a href="#"><span class="mai-logo-twitter"></span></a>
                    <a href="#"><span class="mai-logo-google-plus-g"></span></a>
                    <a href="#"><span class="mai-logo-instagram"></span></a>
                    <a href="#"><span class="mai-logo-youtube"></span></a>
                </div>

            </div>
        </div>

        <p class="text-center" style="margin-top: -60px;" id="copyright">Copyright &copy; {{date('Y')}}. PEMERINTAH
            KABUPATEN MADIUN <a href="" target="_blank"></a></p>
    </div>
</footer>

<script src="../landing-assets/js/jquery-3.5.1.min.js"></script>
<script src="../landing-assets/js/bootstrap.bundle.min.js"></script>
<script src="../landing-assets/js/google-maps.js"></script>
<script src="../landing-assets/vendor/wow/wow.min.js"></script>
<script src="../landing-assets/js/theme.js"></script>
@stack('js')

</body>

</html>
