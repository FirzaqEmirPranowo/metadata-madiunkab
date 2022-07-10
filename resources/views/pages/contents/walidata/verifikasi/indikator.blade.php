@extends('pages.main.layout')

@php
    $v = optional($data->verifikasi);
    $variables = ['nama', 'alias', 'definisi', 'interpretasi', 'konsep', 'metode', 'ukuran', 'satuan', 'klasifikasi_penyajian', 'komposit', 'publikasi_indikator_pembangun', 'nama_indikator_pembangun', 'kegiatan_variabel_pembangun', 'kode_kegiatan_variabel_pembangun', 'nama_variabel_pembangun', 'level_estimasi', 'umum'];
    foreach ($variables as $var) {
        $$var = $v->firstWhere('field', $var);
    }
@endphp

@section('content')

    <div class="pagetitle">
        <h1>Metadata Indikator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daftar Pengumpulan Data</a></li>
                <li class="breadcrumb-item">{{$data->nama_data}}</li>
                <li class="breadcrumb-item active">Tambah Indikator</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Metadata Indikator</h5>

                        <form action="{{route('simpan-indikator', $data->id)}}" method="POST">
                            @csrf
                            <div class="row mb-3 align-items-center">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Indikator</label>
                                <div class="col-sm-8">
                                    <div class="input-group has-validation">
                                        <input id="nama" name="nama" type="text" class="form-control {{ $nama ? ($nama->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" placeholder="Nama Indikator" value="{{old('nama', optional($data->variabel)->nama ?? $data->nama_data)}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$nama && $nama->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="nama">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$nama && !$nama->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="nama">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="nama"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-8">
                                    <textarea name="konsep" class="form-control {{ $konsep ? ($konsep->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" style="height: 100px" spellcheck="false" placeholder="Konsep" disabled>{{old('konsep', optional($data->variabel)->konsep ?? optional($data->standar)->konsep)}}</textarea>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$konsep && $konsep->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="konsep">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$konsep && !$konsep->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="konsep">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="konsep"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-8">
                                    <input id="definisi" name="definisi" type="text" class="form-control {{ $definisi ? ($definisi->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" placeholder="Definisi" value="{{old('definisi', optional($data->variabel)->definisi ?? optional($data->standar)->definisi)}}" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$definisi && $definisi->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="definisi">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$definisi && !$definisi->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="definisi">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="definisi"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="interpretasi" class="col-sm-2 col-form-label">Interpretasi</label>
                                <div class="col-sm-8">
                                    <input id="interpretasi" name="interpretasi" type="text" class="form-control {{ $interpretasi ? ($interpretasi->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" placeholder="Interpretasi" value="{{old('interpretasi', optional($data->indikator)->interpretasi)}}" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$interpretasi && $interpretasi->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="interpretasi">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$interpretasi && !$interpretasi->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="interpretasi">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="interpretasi"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="metode" class="col-sm-2 col-form-label">Metode / Rumus Perhitungan</label>
                                <div class="col-sm-8">
                                    <span id="metode_editor" class="form-control"></span>
                                    <textarea name="metode" id="metode" class="form-control d-none" style="height: 100px" spellcheck="false" placeholder="Metode / Rumus Perhitungan"></textarea>
                                    <small class="help-block text-muted">
                                        Rumus menggunakan format LaTeX.
                                    </small>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$metode && $metode->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="metode">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$metode && !$metode->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="metode">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="metode"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-8">
                                    <input id="ukuran" name="ukuran" type="text" class="form-control {{ $ukuran ? ($ukuran->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" placeholder="Ukuran" value="{{old('ukuran', optional($data->indikator)->ukuran ?? optional($data->standar)->ukuran)}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$ukuran && $ukuran->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="ukuran">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$ukuran && !$ukuran->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="ukuran">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="ukuran"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-8">
                                    <input id="satuan" name="satuan" type="text" class="form-control {{ $satuan ? ($satuan->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" placeholder="Satuan" value="{{old('satuan', optional($data->variabel)->satuan ?? optional($data->standar)->satuan)}}" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$satuan && $satuan->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="satuan">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$satuan && !$satuan->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="satuan">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="satuan"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi_penyajian" class="col-sm-2 col-form-label">Klasifikasi Penyajian</label>
                                <div class="col-sm-8">
                                    <textarea name="klasifikasi_penyajian" class="form-control {{ $klasifikasi_penyajian ? ($klasifikasi_penyajian->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" style="height: 100px" spellcheck="false" placeholder="Klasifikasi Penyajian">{{old('klasifikasi_penyajian', optional($data->indikator)->klasifikasi_penyajian)}}</textarea>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$klasifikasi_penyajian && $klasifikasi_penyajian->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="klasifikasi_penyajian">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$klasifikasi_penyajian && !$klasifikasi_penyajian->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="klasifikasi_penyajian">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="klasifikasi_penyajian"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="komposit" class="col-sm-2 col-form-label">Apakah indikator komposit?</label>
                                <div class="col-sm-10">
                                    <div class="form-check"><input class="form-check-input" type="radio" name="komposit"
                                                                   id="komposit1" value="1" {{old('komposit', optional($data->indikator)->komposit) == 1 ? 'checked' : ''}}> <label
                                            class="form-check-label" for="gridRadios1"> Ya </label></div>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="komposit"
                                                                   id="komposit2" value="0" {{old('komposit', optional($data->indikator)->komposit) == 0 || empty(old('komposit', optional($data->indikator)->komposit)) ? 'checked' : ''}}> <label
                                            class="form-check-label" for="gridRadios1"> Tidak </label></div>
                                </div>
                            </div>

                            <section class="komposit-section">
                                <div class="row mb-3">
                                    <label for="publikasi_indikator_pembangun" class="col-sm-2 col-form-label">Publikasi Ketersediaan
                                        Indikator Pembangun</label>
                                    <div class="col-sm-8">
                                        <input id="publikasi_indikator_pembangun" name="publikasi_indikator_pembangun" type="text" class="form-control {{ $publikasi_indikator_pembangun ? ($publikasi_indikator_pembangun->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" value="{{old('publikasi_indikator_pembangun', optional($data->indikator)->publikasi_indikator_pembangun)}}">
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group-sm">
                                            <button class="btn btn-actions btn-accept btn-sm {{$publikasi_indikator_pembangun && $publikasi_indikator_pembangun->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="publikasi_indikator_pembangun">Setuju <i class="bi bi-check"></i></button>
                                            <button class="btn btn-actions btn-reject btn-sm {{$publikasi_indikator_pembangun && !$publikasi_indikator_pembangun->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="publikasi_indikator_pembangun">Revisi <i class="bi bi-x"></i></button>
                                            <button class="btn btn-comment btn-sm btn-outline-primary" data-name="publikasi_indikator_pembangun"><i class="bi bi-chat-dots"></i> Komentar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_indikator_pembangun" class="col-sm-2 col-form-label">Nama Indikator
                                        Pembangun</label>
                                    <div class="col-sm-8">
                                        <textarea name="nama_indikator_pembangun" class="form-control {{ $nama_indikator_pembangun ? ($nama_indikator_pembangun->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" style="height: 100px" spellcheck="false" placeholder="Nama Indikator Pembangun">{{old('nama_indikator_pembangun', optional($data->indikator)->nama_indikator_pembangun)}}</textarea>
                                        <small class="text-muted">Daftar nama dipisah menggunakan enter.</small>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group-sm">
                                            <button class="btn btn-actions btn-accept btn-sm {{$nama_indikator_pembangun && $nama_indikator_pembangun->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="nama_indikator_pembangun">Setuju <i class="bi bi-check"></i></button>
                                            <button class="btn btn-actions btn-reject btn-sm {{$nama_indikator_pembangun && !$nama_indikator_pembangun->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="nama_indikator_pembangun">Revisi <i class="bi bi-x"></i></button>
                                            <button class="btn btn-comment btn-sm btn-outline-primary" data-name="nama_indikator_pembangun"><i class="bi bi-chat-dots"></i> Komentar</button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="no-komposit-section">
{{--                                <div class="row mb-3">--}}
{{--                                    <label for="kode_kegiatan_variabel_pembangun" class="col-sm-2 col-form-label">Kode Kegiatan Penghasil Variabel Pembangun</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <input id="kode_kegiatan_variabel_pembangun" name="kode_kegiatan_variabel_pembangun" type="text" class="form-control" disabled placeholder="Diisi oleh petugas" value="{{old('kode_kegiatan_variabel_pembangun', optional($data->indikator)->kode_kegiatan_variabel_pembangun)}}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row mb-3">--}}
{{--                                    <label for="kegiatan_variabel_pembangun" class="col-sm-2 col-form-label">Kegiatan Penghasil Variabel Pembangun</label>--}}
{{--                                    <div class="col-sm-8">--}}
{{--                                        <input id="kegiatan_variabel_pembangun" name="kegiatan_variabel_pembangun" type="text" class="form-control {{ $kegiatan_variabel_pembangun ? ($kegiatan_variabel_pembangun->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" value="{{old('kegiatan_variabel_pembangun', optional($data->indikator)->kegiatan_variabel_pembangun)}}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-sm-2">--}}
{{--                                        <div class="btn-group-sm">--}}
{{--                                            <button class="btn btn-actions btn-accept btn-sm {{$kegiatan_variabel_pembangun && $kegiatan_variabel_pembangun->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="kegiatan_variabel_pembangun">Setuju <i class="bi bi-check"></i></button>--}}
{{--                                            <button class="btn btn-actions btn-reject btn-sm {{$kegiatan_variabel_pembangun && !$kegiatan_variabel_pembangun->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="kegiatan_variabel_pembangun">Revisi <i class="bi bi-x"></i></button>--}}
{{--                                            <button class="btn btn-comment btn-sm btn-outline-primary" data-name="kegiatan_variabel_pembangun"><i class="bi bi-chat-dots"></i> Komentar</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row mb-3">
                                    <label for="nama_variabel_pembangun" class="col-sm-2 col-form-label">Nama Variabel Pembangun</label>
                                    <div class="col-sm-8">
                                        <textarea name="nama_variabel_pembangun" class="form-control {{ $nama_variabel_pembangun ? ($nama_variabel_pembangun->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" style="height: 100px" spellcheck="false" placeholder="Nama Variabel Pembangun">{{old('nama_variabel_pembangun', optional($data->indikator)->nama_variabel_pembangun)}}</textarea>
                                        <small class="text-muted">Daftar nama dipisah menggunakan enter.</small>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="btn-group-sm">
                                            <button class="btn btn-actions btn-accept btn-sm {{$nama_variabel_pembangun && $nama_variabel_pembangun->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="nama_variabel_pembangun">Setuju <i class="bi bi-check"></i></button>
                                            <button class="btn btn-actions btn-reject btn-sm {{$nama_variabel_pembangun && !$nama_variabel_pembangun->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="nama_variabel_pembangun">Revisi <i class="bi bi-x"></i></button>
                                            <button class="btn btn-comment btn-sm btn-outline-primary" data-name="nama_variabel_pembangun"><i class="bi bi-chat-dots"></i> Komentar</button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="row mb-3">
                                <label for="level_estimasi" class="col-sm-2 col-form-label">Level Estimasi</label>
                                <div class="col-sm-8">
                                    <select class="form-control {{ $level_estimasi ? ($level_estimasi->accepted ? 'is-valid' : 'is-invalid') : '' }} bg-light" name="level_estimasi" id="level_estimasi" disabled>
                                        <option value="nasional" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'nasional' || empty(old('level_estimasi', optional($data->indikator)->level_estimasi)) ? 'checked' : ''}}>Nasional</option>
                                        <option value="provinsi" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'provinsi' ? 'checked' : ''}}>Provinsi</option>
                                        <option value="kota" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kota' ? 'checked' : ''}}>Kabupaten/kota</option>
                                        <option value="kecamatan" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kecamatan' ? 'checked' : ''}}>Kecamatan</option>
                                        <option value="kelurahan" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kelurahan' ? 'checked' : ''}}>Desa/Kelurahan</option>
                                        <option value="rt" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'rt' ? 'checked' : ''}}>Rumah Tangga</option>
                                        <option value="individu" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'individu' ? 'checked' : ''}}>Individu</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$level_estimasi && $level_estimasi->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="level_estimasi">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$level_estimasi && !$level_estimasi->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="level_estimasi">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="level_estimasi"><i class="bi bi-chat-dots"></i> Komentar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="umum1" class="col-sm-2 col-form-label">Apakah kolom ini dapat diakses umum</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum1"
                                               value="1" {{old('umum', optional($data->indikator)->umum) == 1 || empty(old('umum', optional($data->indikator)->umum)) ? 'checked' : ''}} disabled>
                                        <label class="form-check-label" for="umum1">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum2" value="0" {{old('umum', optional($data->indikator)->umum) == 0 ? 'checked' : ''}} disabled>
                                        <label class="form-check-label" for="umum2">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="btn-group-sm">
                                        <button class="btn btn-actions btn-accept btn-sm {{$umum && $umum->accepted ? 'btn-success' : 'btn-outline-success'}}" data-name="umum">Setuju <i class="bi bi-check"></i></button>
                                        <button class="btn btn-actions btn-reject btn-sm {{$umum && !$umum->accepted ? 'btn-danger' : 'btn-outline-danger'}}" data-name="umum">Revisi <i class="bi bi-x"></i></button>
                                        <button class="btn btn-comment btn-sm btn-outline-primary" data-name="umum"><i class="bi bi-chat-dots"></i> Komentar</button>
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


@section('css')
    <link href="{{asset('assets/vendor/mathquill/mathquill.css')}}" rel="stylesheet">
@endsection
@push('js')
    <script src="{{asset('assets/vendor/mathquill/mathquill.min.js')}}"></script>
    <script>
        $(function () {
            const MQ = MathQuill.getInterface(2);

            $('section.no-komposit-section').hide();
            $('section.komposit-section').hide();
            $('input[name="komposit"]').change(function () {
                if ($('input[name="komposit"]:checked').val() == 1) {
                    $('section.komposit-section').show();
                    $('section.no-komposit-section').hide();
                } else {
                    $('section.komposit-section').hide();
                    $('section.no-komposit-section').show();
                }
            }).trigger('change');

            let metode = MQ.MathField(document.getElementById('metode_editor'), {
                disabled: true,
                spaceBehavesLikeTab: true,
                handlers: {
                    edit: function() {
                        $('#metode').val(encodeURIComponent(metode.latex()));
                    }
                }
            });
            document.querySelector('.mq-textarea textarea').disabled = true;

            let oldMetode = decodeURIComponent('{{old('metode', optional($data->indikator)->metode)}}');
            if (oldMetode !== '') {
                metode.latex(oldMetode);
            }

            $('button.btn-actions').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{route('verifikasi.verify', $data->id)}}',
                    method: 'PATCH',
                    data: {
                        category: 'indikator',
                        accepted: $(this).hasClass('btn-accept'),
                        field: $(this).data('name')
                    }
                })
                    .then((r) => Toast.fire({icon: r.ok ? 'success' : 'error', title: r.message}))
                    .catch(() => Toast.fire({icon: 'error', title: 'Gagal menyimpan perubahan'}));
            });

            $('button.btn-comment').on('click', function (e) {
                e.preventDefault();
                Swal.showLoading();
                let fieldName = $(this).data('name');
                $.get('{{route('verifikasi.get-komentar', $data->id)}}', {field: fieldName, category: 'indikator'})
                    .then(function(r) {
                        if (Swal.isLoading()) Swal.hideLoading();
                        Swal.fire({
                            title: 'Komentar untuk field ini',
                            input: 'textarea',
                            inputValue: r.comment ?? '-',
                            inputAttributes: {
                                autocapitalize: 'off',
                                spellCheck: false,
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            showLoaderOnConfirm: true,
                            preConfirm: (comment) => {
                                return $.post('{{route('verifikasi.komentar', $data->id)}}', {field: fieldName, comment: comment, category: 'indikator'})
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(response.message)
                                        }
                                        return response;
                                    })
                                    .catch(error => {
                                        Swal.showValidationMessage(
                                            `Request gagal: ${error}`
                                        )
                                    })
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Toast.fire({icon: result.value.ok ? 'success' : 'error', title: result.value.message});
                            }
                        });
                    });
            })
        });
    </script>
@endpush
