@extends('pages.main.layout')

@section('content')

    <div class="pagetitle">
        <h1>Detail Data: {{$data->nama_data}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Data</li>
                <li class="breadcrumb-item active">{{$data->nama_data}}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data</h5>

                        <form action="{{route('simpan-data', $data->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                                <div class="col-sm-10">
                                    <input id="nama_data" name="nama_data" type="text" class="form-control"
                                           value="{{$data->nama_data}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis Data</label>
                                <div class="col-sm-10">
                                    <select id="jenis_data" name="jenis_data" class="form-select" disabled>
                                        <option selected value="{{$data->jenis_data}}">{{$data->jenis_data}}</option>
                                        <option value="Indikator">Indikator</option>
                                        <option value="Variabel">Variabel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Produsen Data(PIC)</label>
                                <div class="col-sm-10">
                                    <select id="opd_id" name="opd_id" class="form-select"
                                            aria-label="Default select example" value="{{$data->opd_id}}" disabled>
                                        <option selected value="{{$data->opd_id}}">{{$data->opd->nama_opd}}</option>
                                        @foreach($opds as $opd)
                                            <option value="{{ $opd->id }}">{{ $opd->nama_opd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sumber Data</label>
                                <div class="col-sm-10">
                                    <select id="sumber_data" name="sumber_data" class="form-select" aria-label="Sumber Data">
                                        <option selected value="{{$data->sumber_data}}">{{$data->sumber_data}}</option>
                                        <option value="RPJMD">RPJMD</option>
                                        <option value="SPM">SPM</option>
                                        <option value="SDGs">SDGs</option>
                                    </select>
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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Berkas Data</div>
                        <form class="form-control dropzone" id="berkas">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <script>
        window.Dropzone.autoDiscover = false;
        $(function () {
            let existingBerkas = @json($existingBerkas);
            let berkasDz = new Dropzone('#berkas', {
                paramName: 'berkas',
                url: '{{route('upload-berkas', $data->id)}}',
                addRemoveLinks: true,
            });
            berkasDz.on('removedfile', function (file) {
                $.ajax({
                    url: file.deleteUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                })
            });
            $.each(existingBerkas, function (i, file) {
                berkasDz.files.push(file);
                berkasDz.emit('addedfile', file);
                berkasDz.emit('complete', file);
            });

        });
    </script>
@endpush
