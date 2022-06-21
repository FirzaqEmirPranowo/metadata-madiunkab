@extends('pages.main.layout')
@section('content')

    <div class="pagetitle">
        <h1>Metadata Variabel</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daftar Pengumpulan Data</a></li>
                <li class="breadcrumb-item">{{$data->nama_data}}</li>
                <li class="breadcrumb-item active">Metadata Variabel</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Metadata Variabel</h5>

                        <form action="{{route('simpan-variabel', $data->id)}}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Variabel</label>
                                <div class="col-sm-10">
                                    <input id="nama" name="nama" type="text" class="form-control"
                                           placeholder="Nama Variabel" value="{{old('nama', optional($data->variabel)->nama ?? $data->nama_data)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="alias" class="col-sm-2 col-form-label">Alias</label>
                                <div class="col-sm-10">
                                    <input id="alias" name="alias" type="text" class="form-control" placeholder="Alias" value="{{old('alias', optional($data->variabel)->alias)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-10">
                                    <textarea name="konsep" class="form-control" style="height: 100px" spellcheck="false" placeholder="Konsep">{{old('konsep', optional($data->variabel)->konsep ?? optional($data->standar)->konsep)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-10">
                                    <input id="definisi" name="definisi" type="text" class="form-control" placeholder="Definisi" value="{{old('definisi', optional($data->variabel)->definisi ?? optional($data->standar)->definisi)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="referensi_pemilihan" class="col-sm-2 col-form-label">Referensi Pemilihan</label>
                                <div class="col-sm-10">
                                    <input id="referensi_pemilihan" name="referensi_pemilihan" type="text" class="form-control" placeholder="Referensi Pemilihan" value="{{old('referensi_pemilihan', optional($data->variabel)->referensi_pemilihan)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="referensi_waktu" class="col-sm-2 col-form-label">Referensi Waktu</label>
                                <div class="col-sm-10">
                                    <input id="referensi_waktu" name="referensi_waktu" type="datetime-local" class="form-control" placeholder="Referensi Waktu" value="{{old('referensi_waktu', optional($data->variabel)->referensi_waktu)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tipe_data" class="col-sm-2 col-form-label">Tipe Data</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="tipe_data" id="tipe_data">
                                        <option value="integer" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'integer' || empty(optional($data->variabel)->tipe_data) ? 'selected' : ''}}>Integer</option>
                                        <option value="float" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'float' ? 'selected' : ''}}>Float</option>
                                        <option value="char" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'char' ? 'selected' : ''}}>Char</option>
                                        <option value="string" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'string' ? 'selected' : ''}}>String</option>
                                        <option value="array" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'array' ? 'selected' : ''}}>Array</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi_isian" class="col-sm-2 col-form-label">Klasifikasi Isian</label>
                                <div class="col-sm-10">
                                    <textarea name="klasifikasi_isian" class="form-control" style="height: 100px" spellcheck="false" placeholder="Klasifikasi Isian">{{old('klasifikasi_isian', optional($data->variabel)->klasifikasi_isian ?? optional($data->standar)->klasifikasi)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-10">
                                    <input id="ukuran" name="ukuran" type="text" class="form-control" placeholder="Ukuran" value="{{old('ukuran', optional($data->variabel)->ukuran ?? optional($data->standar)->ukuran)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <input id="satuan" name="satuan" type="text" class="form-control" placeholder="Satuan" value="{{old('satuan', optional($data->variabel)->satuan ?? optional($data->standar)->satuan)}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="aturan_validasi" class="col-sm-2 col-form-label">Aturan Validasi</label>
                                <div class="col-sm-10">
                                    <textarea name="aturan_validasi" class="form-control" style="height: 100px" spellcheck="false" placeholder="Aturan Validasi">{{old('aturan_validasi', optional($data->variabel)->aturan_validasi)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kalimat_pertanyaan" class="col-sm-2 col-form-label">Kalimat Pertanyaan</label>
                                <div class="col-sm-10">
                                    <textarea name="kalimat_pertanyaan" class="form-control" style="height: 100px" spellcheck="false" placeholder="Kalimat Pertanyaan">{{old('kalimat_pertanyaan', optional($data->variabel)->kalimat_pertanyaan)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="umum1" class="col-sm-2 col-form-label">Apakah kolom ini dapat
                                    diakses umum</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum1"
                                               value="1" {{old('umum', optional($data->variabel)->umum) == 1 || empty(old('umum', optional($data->variabel)->umum)) ? 'checked' : ''}}>
                                        <label class="form-check-label" for="umum1">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="umum" id="umum2" value="0" {{old('umum', optional($data->variabel)->umum) == 0 ? 'checked' : ''}}>
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
