@extends('pages.main.layout')

@section('title', 'Standar Data - ' . $data->nama_data)
@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Standar Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daftar Pengumpulan Data</a></li>
                <li class="breadcrumb-item">Data - {{$data->nama_data}}</li>
                <li class="breadcrumb-item active">Standar Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Standar Data: <em>{{$data->nama_data}}</em></h5>

                        <form method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="konsep" class="col-sm-2 col-form-label">Konsep</label>
                                <div class="col-sm-10">
                                    <textarea id="konsep" name="konsep" class="form-control" placeholder="Konsep Standar Data">{{old('konsep', optional($data->standar)->konsep)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="definisi" class="col-sm-2 col-form-label">Definisi</label>
                                <div class="col-sm-10">
                                    <textarea id="definisi" name="definisi" class="form-control" placeholder="Definisi Standar Data">{{old('definisi', optional($data->standar)->definisi)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="klasifikasi" class="col-sm-2 col-form-label">Klasifikasi</label>
                                <div class="col-sm-10">
                                    <textarea id="klasifikasi" name="klasifikasi" class="form-control" placeholder="Klasifikasi Standar Data">{{old('klasifikasi', optional($data->standar)->klasifikasi)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ukuran" class="col-sm-2 col-form-label">Ukuran</label>
                                <div class="col-sm-10">
                                    <textarea id="ukuran" name="ukuran" class="form-control" placeholder="Ukuran Standar Data">{{old('ukuran', optional($data->standar)->ukuran)}}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                <div class="col-sm-10">
                                    <textarea id="satuan" name="satuan" class="form-control" placeholder="Satuan Standar Data">{{old('satuan', optional($data->standar)->satuan)}}</textarea>
                                </div>
                            </div>

                            @if(auth()->user()->hasAnyRole('produsen'))
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection
