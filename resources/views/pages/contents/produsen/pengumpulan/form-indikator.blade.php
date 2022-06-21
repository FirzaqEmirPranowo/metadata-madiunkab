@extends('pages.main.layout')
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
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Indikator</label>
                                <div class="col-sm-10">
                                    <input id="nama" name="nama" type="text" class="form-control"
                                           placeholder="Nama Indikator" value="{{old('nama', optional($data->indikator)->nama)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-10">
                                    <input id="konsep" name="konsep" type="text" class="form-control" placeholder="Konsep" value="{{old('ukuran', optional($data->indikator)->konsep ?? optional($data->standar)->konsep)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-10">
                                    <textarea name="definisi" class="form-control" style="height: 100px" spellcheck="false" placeholder="Definisi">{{old('definisi', optional($data->indikator)->definisi ?? optional($data->standar)->definisi)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="interpretasi" class="col-sm-2 col-form-label">Interpretasi</label>
                                <div class="col-sm-10">
                                    <input id="interpretasi" name="interpretasi" type="text" class="form-control" placeholder="Interpretasi" value="{{old('interpretasi', optional($data->indikator)->interpretasi)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="metode" class="col-sm-2 col-form-label">Metode / Rumus Perhitungan</label>
                                <div class="col-sm-10">
                                    <span id="metode_editor" class="form-control"></span>
                                    <textarea name="metode" id="metode" class="form-control d-none" style="height: 100px" spellcheck="false" placeholder="Metode / Rumus Perhitungan"></textarea>
                                    <small class="help-block text-muted">
                                        Rumus menggunakan format LaTeX.
                                    </small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-10">
                                    <input id="ukuran" name="ukuran" type="text" class="form-control" placeholder="Ukuran" value="{{old('ukuran', optional($data->indikator)->ukuran ?? optional($data->standar)->ukuran)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <input id="satuan" name="satuan" type="text" class="form-control" placeholder="Satuan" value="{{old('satuan', optional($data->indikator)->satuan ?? optional($data->standar)->satuan)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi_penyajian" class="col-sm-2 col-form-label">Klasifikasi Penyajian</label>
                                <div class="col-sm-10">
                                    <textarea name="klasifikasi_penyajian" class="form-control" style="height: 100px" spellcheck="false" placeholder="Klasifikasi Penyajian">{{old('klasifikasi_penyajian', optional($data->indikator)->klasifikasi_penyajian)}}</textarea>
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

                            {{--                            HIDE ini kalau bukan komposit --}}
                            <section class="komposit-section">
                                <div class="row mb-3">
                                    <label for="publikasi_indikator_pembangun" class="col-sm-2 col-form-label">Publikasi Ketersediaan
                                        Indikator Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="publikasi_indikator_pembangun" name="publikasi_indikator_pembangun" type="text" class="form-control" value="{{old('publikasi_indikator_pembangun', optional($data->indikator)->publikasi_indikator_pembangun)}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_indikator_pembangun" class="col-sm-2 col-form-label">Nama Indikator
                                        Pembangun</label>
                                    <div class="col-sm-10">
                                        <textarea name="nama_indikator_pembangun" class="form-control" style="height: 100px" spellcheck="false" placeholder="Nama Indikator Pembangun">{{old('nama_indikator_pembangun', optional($data->indikator)->nama_indikator_pembangun)}}</textarea>
                                        <small class="text-muted">Daftar nama dipisah menggunakan enter.</small>
                                    </div>
                                </div>
                            </section>
                            <section class="no-komposit-section">
                                <div class="row mb-3">
                                    <label for="kode_kegiatan_variabel_pembangun" class="col-sm-2 col-form-label">Kode Kegiatan
                                        Penghasil Variabel Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="kode_kegiatan_variabel_pembangun" name="kode_kegiatan_variabel_pembangun" type="text" class="form-control" disabled placeholder="Diisi oleh petugas" value="{{old('kode_kegiatan_variabel_pembangun', optional($data->indikator)->kode_kegiatan_variabel_pembangun)}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kegiatan_variabel_pembangun" class="col-sm-2 col-form-label">Kegiatan
                                        Penghasil Variabel Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="kegiatan_variabel_pembangun" name="kegiatan_variabel_pembangun" type="text" class="form-control" value="{{old('kegiatan_variabel_pembangun', optional($data->indikator)->kegiatan_variabel_pembangun)}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama_variabel_pembangun" class="col-sm-2 col-form-label">Nama Variabel
                                        Pembangun</label>
                                    <div class="col-sm-10">
                                        <input id="nama_variabel_pembangun" name="nama_variabel_pembangun" type="text" class="form-control" value="{{old('nama_variabel_pembangun', optional($data->indikator)->nama_variabel_pembangun)}}">
                                    </div>
                                </div>
                            </section>
                            {{--                            END HIDE--}}

                            <div class="row mb-3">
                                <label for="level_estimasi" class="col-sm-2 col-form-label">Level Estimasi</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="level_estimasi" id="level_estimasi">
                                        <option value="nasional" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'nasional' || empty(old('level_estimasi', optional($data->indikator)->level_estimasi)) ? 'checked' : ''}}>Nasional</option>
                                        <option value="provinsi" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'provinsi' ? 'checked' : ''}}>Provinsi</option>
                                        <option value="kota" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kota' ? 'checked' : ''}}>Kabupaten/kota</option>
                                        <option value="kecamatan" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kecamatan' ? 'checked' : ''}}>Kecamatan</option>
                                        <option value="kelurahan" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'kelurahan' ? 'checked' : ''}}>Desa/Kelurahan</option>
                                        <option value="rt" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'rt' ? 'checked' : ''}}>Rumah Tangga</option>
                                        <option value="individu" {{old('level_estimasi', optional($data->indikator)->level_estimasi) == 'individu' ? 'checked' : ''}}>Individu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="umum1" class="col-sm-2 col-form-label">Apakah kolom ini dapat
                                    diakses umum</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum1"
                                               value="1" {{old('umum', optional($data->indikator)->umum) == 1 || empty(old('umum', optional($data->indikator)->umum)) ? 'checked' : ''}}>
                                        <label class="form-check-label" for="umum1">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum2" value="0" {{old('umum', optional($data->indikator)->umum) == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="umum2">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->hasAnyRole('produsen'))
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            @endif

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
                spaceBehavesLikeTab: true,
                handlers: {
                    edit: function() {
                        $('#metode').val(encodeURIComponent(metode.latex()));
                    }
                }
            });
            let oldMetode = decodeURIComponent('{{old('metode', optional($data->indikator)->metode)}}');
            if (oldMetode !== '') {
                metode.latex(oldMetode);
            }
        })
    </script>
@endpush
