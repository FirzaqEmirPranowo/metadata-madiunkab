@extends('pages.main.layout')

@section('content')
    @php
        $role = auth()->user()->hasAnyRole('produsen') ? 'produsen' : 'walidata';
    @endphp
    <div class="pagetitle">
        <h1>Daftar Data Proses Verifikasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Data</h5>
                        <p>Halaman ini berisi daftar data yang berstatus proses verifikasi dan revisi.</p>
                        <table class="table datatable" id="tableVerifikasiData">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Data</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Produsen Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Terakhir diubah</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dt->nama_data }}</td>
                                    <td>{{ $dt->jenis_data }}</td>
                                    <td>{{ $dt->opd->nama_opd }}</td>
                                    <td>{{ $dt->status->status }}</td>
                                    <td>{{ $dt->updated_at->format('d/m/Y H:i A') }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a class="btn btn-outline-primary btn-sm" href="/data_{{$role}}/pengumpulan/{{$dt->id}}/data"><i class="bi bi-cloud-upload"></i> {{$role == 'produsen' ? 'Unggah Berkas' : 'Detail Berkas'}}</a>
                                            <a class="btn btn-outline-primary btn-sm" href="/data_{{$role}}/pengumpulan/{{$dt->id}}/standar"><i class="bi bi-sim-fill"></i> Standar Data</a>
                                            <a class="btn btn-outline-success btn-sm" href="/data_{{$role}}/pengumpulan/{{$dt->id}}/{{strtolower($dt->jenis_data)}}"><i class="bi bi-bar-chart"></i> Meta Data {{$dt->jenis_data}}</a>
                                            <a class="btn btn-outline-success btn-sm" href="/data_{{$role}}/pengumpulan/{{$dt->id}}/kegiatan"><i class="bi bi-activity"></i> Meta Data Kegiatan</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
