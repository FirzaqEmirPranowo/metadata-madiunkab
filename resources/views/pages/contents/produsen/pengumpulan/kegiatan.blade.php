@extends('pages.main.layout')

@section('title', 'Metadata Kegiatan')

@section('content')

    <div class="pagetitle">
        <h1>Metadata Kegiatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Daftar Data</li>
                <li class="breadcrumb-item">Data - X</li>
                <li class="breadcrumb-item">Metadata Kegiatan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Metadata Kegiatan</h5>
                        <form method="POST">
                            @csrf
                            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-kegiatan" type="button" role="tab"
                                            aria-controls="home" aria-selected="true">Informasi Kegiatan
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-penyelenggara" type="button" role="tab"
                                            aria-controls="profile" aria-selected="false">Penyelenggara
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-penanggungjawab" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Penanggung Jawab
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Perencanaan & Persiapan
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Desain Kegiatan
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Desian Sampel
                                    </button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Pengumpulan Data
                                    </button>
                                </li>

                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Pengolahan & Analisis
                                    </button>
                                </li>

                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-contact" type="button" role="tab"
                                            aria-controls="contact" aria-selected="false">Diseminasi Hasil
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content pt-4" id="borderedTabJustifiedContent">
                                <div class="tab-pane fade active show" id="tab-kegiatan" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="row mb-3">
                                        <label for="judul_kegiatan" class="col-sm-2 col-form-label">Judul Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input id="judul_kegiatan" name="judul_kegiatan" type="text" class="form-control" placeholder="Judul Kegiatan">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="tahun" class="col-sm-2 col-form-label">Tahun Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input id="tahun" name="tahun" type="number" min="1900" max="2999" class="form-control" placeholder="Tahun Kegiatan">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kode_kegiatan" class="col-sm-2 col-form-label">Kode Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input id="kode_kegiatan" name="kode_kegiatan" type="text" class="form-control" placeholder="Kode Kegiatan">
                                            <small class="help-block text-muted text-sm">Diisi oleh petugas BPS</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pengumpulan_data" class="col-sm-2 col-form-label">Cara Pengumpulan Data</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="pengumpulan_data" id="pengumpulan_data">
                                                <option value="1">Pencacahan Lengkap</option>
                                                <option value="2">Survei</option>
                                                <option value="3">Kompilasi Produk Administrasi</option>
                                                <option value="4">Cara lain sesuai dengan perkembangan IT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="sektor_kegiatan" class="col-sm-2 col-form-label">Sektor Kegiatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="sektor_kegiatan" id="sektor_kegiatan">
                                                <option value="1">Pertanian dan Perikanan</option>
                                                <option value="2">Demografi dan Kependudukan</option>
                                                <option value="3">Pembangunan</option>
                                                <option value="4">Proyeksi Ekonomi</option>
                                                <option value="5">Pendidikan dan Pelatihan</option>
                                                <option value="6">Lingkungan</option>
                                                <option value="7">Keuangan</option>
                                                <option value="8">Globalisasi</option>
                                                <option value="9">Kesehatan</option>
                                                <option value="10">Industri dan Jasa</option>
                                                <option value="11">Teknologi Informasi dan Komunikasi</option>
                                                <option value="12">Perdagangan Internasional dan Neraca Perdagangan</option>
                                                <option value="13">Ketenagakerjaan</option>
                                                <option value="14">Neraca Nasional</option>
                                                <option value="15">Indikator Ekonomi Bulanan</option>
                                                <option value="16">Produktivitas</option>
                                                <option value="17">Harga dan Paritas Daya Beli</option>
                                                <option value="18">Sektor Publik, Perpajakan, dan Regulasi Pasar</option>
                                                <option value="19">Perwilayahan dan Perkotaan</option>
                                                <option value="20">Ilmu Pengetahuan dan Hak Paten</option>
                                                <option value="21">Perlindungan Sosial dan Kesejahteraan</option>
                                                <option value="22">Transportasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pengumpulan_data" class="col-sm-2 col-form-label">Jenis Kegiatan Statistik</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="pengumpulan_data" id="pengumpulan_data">
                                                <option value="1">Statistik Dasar</option>
                                                <option value="2">Statistik Sektoral</option>
                                                <option value="3">Statistik Khusus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="level_estimasi" class="col-sm-2 col-form-label">Jika kegiatan statistik sektoral, apakah mendapatkan rekomendasi kegiatan statistik dari BPS?</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1"
                                                       value="1" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Ya
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="0">
                                                <label class="form-check-label" for="gridRadios1">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Penyelenggara -->
                                <div class="tab-pane fade" id="tab-penyelenggara" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <div class="row mb-3">
                                        <label for="instansi_penyelenggara" class="col-sm-2 col-form-label">Instansi Penyelenggara</label>
                                        <div class="col-sm-10">
                                            <input id="instansi_penyelenggara" name="instansi_penyelenggara" type="text" class="form-control" placeholder="Instansi Penyelenggara">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="alamant_penyelenggara" class="col-sm-2 col-form-label">Alamat Lengkap Instansi Penyelenggara</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="alamat_penyelenggara" id="alamat_penyelenggara" placeholder="Alamat Instansi Penyelenggara"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="telepon_penyelenggara" class="col-sm-2 col-form-label">Telepon Penyelenggara</label>
                                        <div class="col-sm-10">
                                            <input id="telepon_penyelenggara" name="telepon_penyelenggara" type="text" class="form-control" placeholder="Nomor Telepon Penyelenggara">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email_penyelenggara" class="col-sm-2 col-form-label">Email Penyelenggara</label>
                                        <div class="col-sm-10">
                                            <input id="email_penyelenggara" name="email_penyelenggara" type="email" class="form-control" placeholder="Email Penyelenggara">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="faksimile_penyelenggara" class="col-sm-2 col-form-label">Faksimile Penyelenggara</label>
                                        <div class="col-sm-10">
                                            <input id="faksimile_penyelenggara" name="faksimile_penyelenggara" type="text" class="form-control" placeholder="Faksimile Penyelenggara">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-penanggungjawab" role="tabpanel"
                                     aria-labelledby="contact-tab">
                                    <h5 class="card-title">Unit Eselon Penanggung Jawab</h5>
                                    <div class="row mb-3">
                                        <label for="eselon_1" class="col-sm-2 col-form-label">Eselon 1</label>
                                        <div class="col-sm-10">
                                            <input id="eselon_1" name="eselon_1" type="text" class="form-control" placeholder="Eselon 1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="eselon_2" class="col-sm-2 col-form-label">Eselon 2</label>
                                        <div class="col-sm-10">
                                            <input id="eselon_2" name="eselon_2" type="text" class="form-control" placeholder="Eselon 2">
                                        </div>
                                    </div>

                                    <h5 class="card-title mt-3">Penanggung Jawab Teknis (setingkat Eselon 3)</h5>
                                    <div class="row mb-3">
                                        <label for="alamat_penanggungjawab" class="col-sm-2 col-form-label">Alamat Instansi Penanggung Jawab</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="alamat_penanggungjawab" id="alamat_penanggungjawab" placeholder="Alamat Instansi Penanggung Jawab"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="telepon_penanggungjawab" class="col-sm-2 col-form-label">Telepon Penanggung Jawab</label>
                                        <div class="col-sm-10">
                                            <input id="telepon_penanggungjawab" name="telepon_penanggungjawab" type="text" class="form-control" placeholder="Nomor Telepon Penanggung Jawab">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email_penanggungjawab" class="col-sm-2 col-form-label">Email Penanggung Jawab</label>
                                        <div class="col-sm-10">
                                            <input id="email_penanggungjawab" name="email_penanggungjawab" type="email" class="form-control" placeholder="Email Penanggung Jawab">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="faksimile_penanggungjawab" class="col-sm-2 col-form-label">Faksimile Penanggung Jawab</label>
                                        <div class="col-sm-10">
                                            <input id="faksimile_penanggungjawab" name="faksimile_penanggungjawab" type="text" class="form-control" placeholder="Faksimile Penanggung Jawab">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
