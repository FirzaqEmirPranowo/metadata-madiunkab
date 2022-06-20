@extends('pages.main.layout')
@section('content')

    <div class="pagetitle">
        <h1>Tambah Indikator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daftar Pengumpulan Data</a></li>
                <li class="breadcrumb-item">{{$data->nama_data}}</li>
                <li class="breadcrumb-item"><a href="/data_produsen/pengumpulan/{{$data->id}}/metadata">Meta Data Indikator</a></li>
                <li class="breadcrumb-item active">Tambah Indikator</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Indikator Data</h5>

                        <form action="{{route('simpan-indikator', $data->id)}}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Indikator</label>
                                <div class="col-sm-10">
                                    <input id="nama" name="nama" type="text" class="form-control"
                                           placeholder="Nama Indikator">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-10">
                                    <input id="konsep" name="konsep" type="text" class="form-control" placeholder="Konsep">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-10">
                                    <textarea name="definisi" class="form-control" style="height: 100px" spellcheck="false" placeholder="Definisi"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="interpretasi" class="col-sm-2 col-form-label">Interpretasi</label>
                                <div class="col-sm-10">
                                    <input id="interpretasi" name="interpretasi" type="text" class="form-control" placeholder="Interpretasi">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="metode" class="col-sm-2 col-form-label">Metode / Rumus Perhitungan</label>
                                <div class="col-sm-10">
                                    <span id="metode_editor" class="form-control"></span>
                                    <textarea name="metode" class="form-control d-none" style="height: 100px" spellcheck="false" placeholder="Metode / Rumus Perhitungan"></textarea>
                                    <small class="help-block text-muted">
                                        Rumus menggunakan format LaTeX.
                                    </small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-10">
                                    <input id="ukuran" name="ukuran" type="text" class="form-control" placeholder="Ukuran">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <input id="satuan" name="satuan" type="text" class="form-control" placeholder="Satuan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi" class="col-sm-2 col-form-label">Klasifikasi Penyajian</label>
                                <div class="col-sm-10">
                                    <input id="klasifikasi" name="klasifikasi" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="komposit" class="col-sm-2 col-form-label">Terdapat Kolom Komposit?</label>
                                <div class="col-sm-10">
                                    <div class="form-check"><input class="form-check-input" type="radio" name="komposit"
                                                                   id="komposit1" value="1"> <label
                                            class="form-check-label" for="gridRadios1"> Ya </label></div>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="komposit"
                                                                   id="komposit2" value="0" checked> <label
                                            class="form-check-label" for="gridRadios1"> Tidak </label></div>
                                </div>
                            </div>

                            {{--                            HIDE ini kalau bukan komposit --}}
                            <section class="komposit-section">
                                <div class="row mb-3">
                                    <label for="publikasi" class="col-sm-2 col-form-label">Publikasi Ketersediaan
                                        Indikator Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="publikasi" name="publikasi" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_indikator_pembangun" class="col-sm-2 col-form-label">Nama Indikator
                                        Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="nama_indikator_pembangun" name="nama_indikator_pembangun" type="text"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_indikator_pembangun" class="col-sm-2 col-form-label">Kegiatan
                                        Penghasil Variabel Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="nama_indikator_pembangun" name="nama_indikator_pembangun" type="text"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kode_kegiatan_pembangun" class="col-sm-2 col-form-label">Kode Kegiatan
                                        Penghasil Variabel Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="kode_kegiatan_pembangun" name="kode_kegiatan_pembangun" type="text"
                                               class="form-control" disabled placeholder="Diisi oleh petugas">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_variabel_pembangun" class="col-sm-2 col-form-label">Nama Variabel
                                        Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="nama_variabel_pembangun" name="nama_variabel_pembangun" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </section>

                            {{--                            END HIDE--}}

                            <div class="row mb-3">
                                <label for="level_estimasi" class="col-sm-2 col-form-label">Level Estimasi</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="level_estimasi" id="level_estimasi">
                                        <option value="nasional">Nasional</option>
                                        <option value="provinsi">Provinsi</option>
                                        <option value="kota">Kabupaten/kota</option>
                                        <option value="kecamatan">Kecamatan</option>
                                        <option value="kelurahan">Desa/Kelurahan</option>
                                        <option value="rt">Rumah Tangga</option>
                                        <option value="individu">Individu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="level_estimasi" class="col-sm-2 col-form-label">Apakah Kolom ini dapat
                                    diakses umum</label>
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

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

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

            $('section.komposit-section').hide();
            $('input[name="komposit"]').change(function () {
                if ($(this).val() == 1) {
                    $('section.komposit-section').show();
                } else {
                    $('section.komposit-section').hide();
                }
            }).trigger('change');

            let metode = MQ.MathField(document.getElementById('metode_editor'), {
                spaceBehavesLikeTab: true,
                handlers: {
                    edit: function() {
                        $('#metode').val(encodeURIComponent(metode.latex()));
                    }
                }
            });
            let oldMetode = decodeURIComponent('{{old('metode')}}');
            if (oldMetode !== '') {
                metode.latex(oldMetode);
            }
        })
    </script>
@endpush
