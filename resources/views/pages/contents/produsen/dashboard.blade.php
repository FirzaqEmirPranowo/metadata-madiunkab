@extends('pages.main.layout')

@section('content')

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Prioritas</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$data}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Lengkap</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-folder2-open"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataLengkap}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Tidak Lengkap</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataTidakLengkap}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card info-card revenue-card">


                            <div class="card-body">
                                <h5 class="card-title">Data Disetujui</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check2"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataSiapPublish}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->


                    <!-- Customers Card -->

                    <!-- Reports -->

                    <!-- Recent Sales -->
                    <!-- Top Selling -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->

        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar 10 Data Terbaru</h5>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Nama</td>
                                    <td>Produsen</td>
                                    <td>Tanggal</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dataTerbaru as $d)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$d->nama_data}}</td>
                                        <td>{{$d->opd->nama_opd}}</td>
                                        <td>{{optional($d->created_at)->format('d/m/Y H:i')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
