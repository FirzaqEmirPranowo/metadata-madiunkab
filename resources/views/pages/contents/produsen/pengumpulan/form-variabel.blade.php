@extends('pages.main.layout')

@php
    if ($data->status_id == \App\Models\Data::STATUS_REVISI) {
        $variables = ['nama', 'alias', 'definisi', 'konsep', 'referensi_pemilihan', 'referensi_waktu', 'tipe_data', 'klasifikasi_isian', 'ukuran', 'satuan', 'aturan_validasi', 'kalimat_pertanyaan', 'umum'];
        foreach ($variables as $var) {
            $$var = $data->verifikasi->firstWhere('field', $var);
        }
    }
@endphp

@section('content')
    @include('sweetalert::alert')

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
                        <div class="d-flex align-content-center justify-content-between flex-wrap mb-3">
                            <h5 class="card-title">Metadata Variabel</h5>
                            <div class="align-self-center">
                                <button class="btn btn-xs btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalImport">Import Metadata <i class="bi bi-file-excel"></i></button>
                            </div>
                        </div>

                        <form action="{{route('simpan-variabel', $data->id)}}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Variabel</label>
                                <div class="col-sm-10">
                                    <input id="nama" name="nama" type="text" class="form-control {{ isset($nama) ? ($nama->accepted ? 'is-valid' : 'is-invalid') : '' }}"
                                           placeholder="Nama Variabel" value="{{old('nama', $data->nama_data)}}" readonly>
                                    @if (isset($nama) && !empty($nama->comment))
                                        <p class="text-muted text-comment">Komentar: {{$nama->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="alias" class="col-sm-2 col-form-label">Alias</label>
                                <div class="col-sm-10">
                                    <input id="alias" name="alias" type="text" class="form-control {{ isset($alias) ? ($alias->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Alias" value="{{old('alias', optional($data->variabel)->alias)}}">
                                    @if (isset($alias) && !empty($alias->comment))
                                        <p class="text-muted text-comment">Komentar: {{$alias->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-10">
                                    <textarea name="konsep" class="form-control {{ isset($konsep) ? ($konsep->accepted ? 'is-valid' : 'is-invalid') : '' }}" style="height: 100px" spellcheck="false" placeholder="Konsep">{{old('konsep', optional($data->variabel)->konsep ?? optional($data->standar)->konsep)}}</textarea>
                                    @if (isset($konsep) && !empty($konsep->comment))
                                        <p class="text-muted text-comment">Komentar: {{$konsep->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-10">
                                    <input id="definisi" name="definisi" type="text" class="form-control {{ isset($definisi) ? ($definisi->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Definisi" value="{{old('definisi', optional($data->variabel)->definisi ?? optional($data->standar)->definisi)}}">
                                    @if (isset($definisi) && !empty($definisi->comment))
                                        <p class="text-muted text-comment">Komentar: {{$definisi->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="referensi_pemilihan" class="col-sm-2 col-form-label">Referensi Pemilihan</label>
                                <div class="col-sm-10">
                                    <input id="referensi_pemilihan" name="referensi_pemilihan" type="text" class="form-control {{ isset($referensi_pemilihan) ? ($referensi_pemilihan->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Referensi Pemilihan" value="{{old('referensi_pemilihan', optional($data->variabel)->referensi_pemilihan)}}">
                                    @if (isset($referensi_pemilihan) && !empty($referensi_pemilihan->comment))
                                        <p class="text-muted text-comment">Komentar: {{$referensi_pemilihan->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="referensi_waktu" class="col-sm-2 col-form-label">Referensi Waktu</label>
                                <div class="col-sm-10">
                                    <input id="referensi_waktu" name="referensi_waktu" type="text" class="form-control {{ isset($referensi_waktu) ? ($referensi_waktu->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Referensi Waktu" value="{{old('referensi_waktu', optional($data->variabel)->referensi_waktu)}}">
                                    @if (isset($referensi_waktu) && !empty($referensi_waktu->comment))
                                        <p class="text-muted text-comment">Komentar: {{$referensi_waktu->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tipe_data" class="col-sm-2 col-form-label">Tipe Data</label>
                                <div class="col-sm-10">
                                    <select class="form-control {{ isset($tipe_data) ? ($tipe_data->accepted ? 'is-valid' : 'is-invalid') : '' }}" name="tipe_data" id="tipe_data">
                                        <option value="integer" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'integer' || empty(optional($data->variabel)->tipe_data) ? 'selected' : ''}}>Integer</option>
                                        <option value="float" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'float' ? 'selected' : ''}}>Float</option>
                                        <option value="char" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'char' ? 'selected' : ''}}>Char</option>
                                        <option value="string" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'string' ? 'selected' : ''}}>String</option>
                                        <option value="array" {{old('tipe_data', optional($data->variabel)->tipe_data) == 'array' ? 'selected' : ''}}>Array</option>
                                    </select>
                                    @if (isset($tipe_data) && !empty($tipe_data->comment))
                                        <p class="text-muted text-comment">Komentar: {{$tipe_data->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-10">
                                    <input id="ukuran" name="ukuran" type="text" class="form-control {{ isset($ukuran) ? ($ukuran->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Ukuran" value="{{old('ukuran', optional($data->variabel)->ukuran ?? optional($data->standar)->ukuran)}}">
                                    @if (isset($ukuran) && !empty($ukuran->comment))
                                        <p class="text-muted text-comment">Komentar: {{$ukuran->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <input id="satuan" name="satuan" type="text" class="form-control {{ isset($satuan) ? ($satuan->accepted ? 'is-valid' : 'is-invalid') : '' }}" placeholder="Satuan" value="{{old('satuan', optional($data->variabel)->satuan ?? optional($data->standar)->satuan)}}">
                                    @if (isset($satuan) && !empty($satuan->comment))
                                        <p class="text-muted text-comment">Komentar: {{$satuan->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi_isian" class="col-sm-2 col-form-label">Klasifikasi Isian</label>
                                <div class="col-sm-10">
                                    <textarea name="klasifikasi_isian" class="form-control {{ isset($klasifikasi_isian) ? ($klasifikasi_isian->accepted ? 'is-valid' : 'is-invalid') : '' }}" style="height: 100px" spellcheck="false" placeholder="Klasifikasi Isian">{{old('klasifikasi_isian', optional($data->variabel)->klasifikasi_isian ?? optional($data->standar)->klasifikasi)}}</textarea>
                                    @if (isset($klasifikasi_isian) && !empty($klasifikasi_isian->comment))
                                        <p class="text-muted text-comment">Komentar: {{$klasifikasi_isian->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="aturan_validasi" class="col-sm-2 col-form-label">Aturan Validasi</label>
                                <div class="col-sm-10">
                                    <textarea name="aturan_validasi" class="form-control {{ isset($aturan_validasi) ? ($aturan_validasi->accepted ? 'is-valid' : 'is-invalid') : '' }}" style="height: 100px" spellcheck="false" placeholder="Aturan Validasi">{{old('aturan_validasi', optional($data->variabel)->aturan_validasi)}}</textarea>
                                    @if (isset($aturan_validasi) && !empty($aturan_validasi->comment))
                                        <p class="text-muted text-comment">Komentar: {{$aturan_validasi->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kalimat_pertanyaan" class="col-sm-2 col-form-label">Kalimat Pertanyaan</label>
                                <div class="col-sm-10">
                                    <textarea name="kalimat_pertanyaan" class="form-control {{ isset($kalimat_pertanyaan) ? ($kalimat_pertanyaan->accepted ? 'is-valid' : 'is-invalid') : '' }}" style="height: 100px" spellcheck="false" placeholder="Kalimat Pertanyaan">{{old('kalimat_pertanyaan', optional($data->variabel)->kalimat_pertanyaan)}}</textarea>

                                    @if (isset($kalimat_pertanyaan) && !empty($kalimat_pertanyaan->comment))
                                        <p class="text-muted text-comment">Komentar: {{$kalimat_pertanyaan->comment}}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="umum1" class="col-sm-2 col-form-label">Apakah kolom ini dapat diakses umum</label>
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

                                    @if (isset($Umum) && !empty($Umum->comment))
                                        <p class="text-muted text-comment">Komentar: {{$Umum->comment}}</p>
                                    @endif
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

            <div class="modal fade" id="modalImport" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">Import Metadata Variabel dari Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda dapat meng-<em>import</em> metadata dari file Excel menggunakan <a href="{{url('/up-download', 'VARIABEL')}}" class="text-primary">template data <i class="bi bi-download"></i></a>.</p>
                            <form enctype="multipart/form-data" action="{{route('import-variabel', $data->id)}}" id="formImport" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">Berkas Excel</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" id="fileImport" name="metadata" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" form="formImport" role="button" onclick="document.getElementById('formImport').submit();">Upload</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
