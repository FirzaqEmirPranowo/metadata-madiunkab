@extends('pages.main.layout')
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Tambah Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Data</li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data</h5>

                        <!-- General Form Elements -->
                        <form @if(Auth::user()->role_id == '1')
                                  action="/data_administrator/store"
                              @elseif(Auth::user()->role_id == '2')
                                  action="/data_walidata/store"
                              @elseif(Auth::user()->role_id == '3')
                                  action="/data_produsen/store"
                              @endif
                              method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                                <div class="col-sm-10">
                                    <input id="nama_data" name="nama_data" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis Data</label>
                                <div class="col-sm-10">
                                    <select id="jenis_data" name="jenis_data" class="form-select"
                                            aria-label="Default select example">
                                        <option selected>Pilih</option>
                                        <option value="Indikator">Indikator</option>
                                        <option value="Variabel">Variabel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Produsen Data (PIC)</label>
                                <div class="col-sm-10">
                                    <select id="opd_id" name="opd_id" class="form-select select2"
                                            aria-label="Default select example">
                                        <option value="" disabled selected hidden>Pilih</option>
                                        @foreach($opd as $dt)
                                            <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sumber Data</label>
                                <div class="col-sm-10">

                                    <select id="sumber_data" name="sumber_data" class="form-select"
                                            aria-label="Default select example">
                                        <option selected>Pilih</option>
                                        <option value="RPJMD">RPJMD</option>
                                        <option value="SPM">SPM</option>
                                        <option value="SDGs">SDGs</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> SIMPAN</button>
                                    <a href="/data_walidata/draft" class="btn btn-outline-danger"><i class="bi bi-arrow-left"></i> Batal</a>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection

@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('#opd_id').select2()
        });
    </script>
@endpush
