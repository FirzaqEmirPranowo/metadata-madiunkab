<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="copyright" content="MACode ID, https://macodeid.com/">

    <title>Satu Data Kabupaten Madiun</title>

    <link rel="stylesheet" href="../landing-assets/css/maicons.css">

    <link rel="stylesheet" href="../landing-assets/css/bootstrap.css">

    <link rel="stylesheet" href="../landing-assets/vendor/animate/animate.css">

    <link rel="stylesheet" href="../landing-assets/css/theme.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,600;1,700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Nunito" />
 -->


</head>

<body>

    <!-- Back to top button -->
    <div class="back-to-top"></div>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky" data-offset="500">
            <div class="container">
                <!-- <div class="header mb-3">
                    <img src="../assets/img/services/service-4.png" alt="">
                </div> -->
                <div class="header">
                    <img style="width:200px; height:60px" src="../landing-assets/img/services/logo2.png" alt="">

                </div>
                <!-- <a href="#" class="navbar-brand">Satu<span class="text-primary">Data</span></a> -->

                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::segment(1) === '/' ? 'active' : null }}">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item {{ Request::segment(1) === 'datas' ? 'active' : null }}">
                            <a class="nav-link" href="/datas">Dataset</a>
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