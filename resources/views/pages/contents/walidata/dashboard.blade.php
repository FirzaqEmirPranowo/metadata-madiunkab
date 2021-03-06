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
                    <div class="col">
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
                    </div>

                    <div class="col">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Proses Pengumpulan</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-folder2-open"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataPengumpulan}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Siap Verifikasi</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataVerifikasi}}</h6>
                                        <span class="text-danger small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col">
                        <div class="card info-card revenue-card">


                            <div class="card-body">
                                <h5 class="card-title">Data Siap Publikasi</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataSiapPublish}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Data Terpublikasi</h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$dataTerpublikasi}}</h6>
                                        <span class="text-success small pt-1 fw-bold">Data</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->

        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
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
            <div class="col-lg-4">
                <div class="card dashboard">
                    <div class="card-body"><h5 class="card-title">Aktivitas Terbaru</h5>
                        <div class="activity">
                            @foreach($lastActivities as $a)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{optional($a->created_at)->diffForHumans()}}</div>
                                    <i class="bi bi-circle-fill activity-badge text-muted align-self-start"></i>
                                    <div class="activity-content"><small>{{$a->causer->name }} - {{$a->description}}</small></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
